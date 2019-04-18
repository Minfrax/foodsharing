<?php


namespace App\Controller;


use App\Mailer\PasswordMailer;
use App\Repository\UserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Twig\Environment;

class PasswordController extends AbstractController
{
    /**
     * @Route("/password/reset")
     */
    public function resetPassword(
        Environment $twig,
        Request $request,
        UserRepository $userRepository,
        PasswordMailer $mailer
    )
    {
        $defaultData = ['message' => 'Your email address'];

        $form = $this->createFormBuilder($defaultData)
            ->add('email', EmailType::class, ["constraints" => [
                new NotBlank()
            ],
                'label' => "Email:"])
            ->add("submit", SubmitType::class, ["label" => 'Sent'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data array of email, name and message keys
            $data = $form->getData();

            $user = $userRepository->findOneBy(["email" => $data["email"]]);

            if ($user) {
                $user->setActiveToken(Uuid::uuid4());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $mailer->sendMail($user);

                return new Response($twig->render('PasswordRecovery/emailPasswordRestoreSent.html.twig', [
                    "user" => $user
                ]));
            }
        }
        return new Response($twig->render('PasswordRecovery/emailPasswordReset.html.twig', [
            "resetPasswordEmailForm" => $form->createView()
        ]));
    }

    /**
     * @Route("password/restore/{token}",name="restore_password")
     */

    public function restorePassword(
        Environment $twig, $token,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository,
        Request $request
    )
    {
        $defaultData = ['message' => 'Enter a nes password'];

        $form = $this->createFormBuilder($defaultData)
            ->add('resetPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => 'New Password',
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add("Reset", SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $user = $userRepository->findOneByActiveToken($token);

        if ($form->isSubmitted() && $form->isValid()) {
            // data array of email, name and message keys
            $data = $form->getData();

            if ($user) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $data["resetPassword"]
                    )
                );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return new Response($twig->render('PasswordRecovery/restorePassword.html.twig', [
                    "user" => $user
                ]));
            }
        } else if ($user) {
            return new Response($twig->render('PasswordRecovery/formConfirmPasswordRestore.html.twig', [
                'formRestorePass' => $form->createView()
            ]));
        }

        return new Response($twig->render('PasswordRecovery/errorRestorePassword.html.twig'));

    }



}