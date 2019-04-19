<?php
/**
 * Created by PhpStorm.
 * User: Student
 * Date: 17/04/2019
 * Time: 15:09
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditUserController extends AbstractController
{
    /**
     * @Route("/edituser/{id}", name="app_edituser")
     */
    public function editUser(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        $id
    ): Response {
        $user = new User();
        $form = $this->editUser(EditUserFormType::class, $user, ['standalone' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('UserEdit/userEdit.html.twig', [
            'EditUserFormType' => $form->createView(),
        ]);
    }

}