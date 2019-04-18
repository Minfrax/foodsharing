<?php

namespace App\Controller;


use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}