<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Mailer\RegistrationMailer;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;

use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

class ProfileController extends AbstractController
{
    /**
     * @Route("/Profile", name="app_my_profile")
     */
    public function showEditDashboard(Environment $twig, Request $request, OfferRepository $repository, UserRepository $userRepository)
    {

        return new Response($twig->render('/profile.html.twig',
            [
                'user' => $repository->findBy(
                    [
                        'id' => $request->get('id')
                    ]
                )
            ]
        )
        );
    }





    /**
     * @Route("/profile/edit/{id}", name="profile_edit")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        RegistrationMailer $mailer, UserRepository $repository,
        $id
    ): Response
    {
        $user = $this->getDoctrine()->getManager();
        $user = $user->getRepository('App:User')->find($id);

        if ($user !== $this->getUser()) {

            return $this->redirectToRoute('homepage');

        } else {

            // standalone PHP class can be used, which can then be reused anywhere in your application(after $user): , ['standalone' => true]
            $form = $this->createForm(
                RegistrationFormType::class,
                $user,
                ['standalone' => true]
            );
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                // Activation token
                $user->setActiveToken(Uuid::uuid4());
                $mailer->sendMail($user);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // do anything else you need here, like send an email

                return $this->redirectToRoute('app_login');
            }

            return $this->render('/editProfile.html.twig', [
                'ProfileEditForm' => $form->createView(),
            ]);

        }
        }

        /**
         * @Route("/activation/needed", name="activation_needed")
         */
        public
        function activationNeeded()
        {
            return $this->render('UserRegister/activationControl.html.twig');
        }

        /**
         * @Route("/account/activate/{token}", name="activate_account")
         */
        public
        function activateToken(
            string $token,
            TokenStorageInterface $tokenStorage
        )
        {
            $manager = $this->getDoctrine()->getManager();
            $userRepository = $manager->getRepository(User::class);
            $user = $userRepository->findOneByActiveToken($token);

            if (!$user) {
                throw new NotFoundHttpException('User not found');
            }

            $user
                ->setActiveToken(null)
                ->setActive(true);
            $manager->flush();

            $tokenStorage->setToken(
                new UsernamePasswordToken($user, null, 'main', $user->getRoles())
            );

            return $this->redirectToRoute('homepage');
        }




}