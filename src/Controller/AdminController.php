<?php

namespace App\Controller;


use App\Entity\Offer;
use App\Form\EditOfferFormType;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class AdminController extends AbstractController
{

    /**
     * @Route("/admConsole", name="app_adm")
     */
    public function showDashboard(Environment $twig, Request $request, OfferRepository $repository, UserRepository $userRepository)
    {
        return new Response($twig->render('Admin/adminDashboard.html.twig',
            [
                'offers' => $repository->findAll(
                    $request
                ),
                'users' => $userRepository->findAll(
                    $request
                )
            ]
        )
        );
    }


    /**
     * @Route("/admConsole/del/{id}", name="adm_del")
     */
    public function deleteOffer(Request $request, Environment $twig, OfferRepository $repository, $id)
    {
        $offer = $this->getDoctrine()->getManager();

        $post = $offer->getRepository('App:Offer')->find($id);

        $offer->remove($post);
        $offer->flush();

        return $this->redirectToRoute('app_adm');

    }

    /**
     * @Route("/admConsole/delUser/{id}", name="adm_u_del")
     */
    public function deleteUser(Request $request, Environment $twig, OfferRepository $repository, $id)
    {
        $offer = $this->getDoctrine()->getManager();

        $post = $offer->getRepository('App:User')->find($id);

        $offer->remove($post);
        $offer->flush();

        return $this->redirectToRoute('app_adm');

    }

    public function grandAdmin(UserRepository $repository)
    {

    }

    /**
     * @Route("/admConsole/EditOffer/{id}", name="adm_edit")
     */
    public function editOffer (
        Request $request,
        FormFactoryInterface $formFactory,
        Environment $twig,
        $id

    )
    {
        $offer= $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($id);
        $form = $formFactory->create(
            EditOfferFormType::class,
            $offer,
            ['standalone' => true]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Title

            //$title = $form->get('title')->getData();



            // Offer picture
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            $fileName = Uuid::uuid4()->toString() . '.' . $file->getExtension();
            $offer->setPicturePath($fileName);
            $offer->setSharerId($this->getUser());
            $offer->setMimeType($file->getMimeType());
            $file->move($this->getParameter('upload_directory'), $fileName);

            //
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirectToRoute('app_adm');
        }

        return new Response(
            $twig->render(
                'Admin/adminEdit.html.twig',
                ['AdminEditForm' => $form->createView()]  // to addForm
            )
        );

        }


    }