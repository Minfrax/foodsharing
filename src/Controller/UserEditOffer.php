<?php


namespace App\Controller;


use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class UserEditOffer extends AbstractController
{
    /**
     * @Route("/EditOffer", name="app_edit_offer")
     */
    public function showEditDashboard(Environment $twig, Request $request, OfferRepository $repository, UserRepository $userRepository)
    {
        return new Response($twig->render('OfferCED/UserEditOffer.html.twig',
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
     * @Route("/EditOffer/del/{id}", name="offer_del")
     */
    public function deleteUserOffer(Request $request, Environment $twig, OfferRepository $repository, $id)
    {
        $offer = $this->getDoctrine()->getManager();

        $post = $offer->getRepository('App:Offer')->find($id);

        $offer->remove($post);
        $offer->flush();

        return $this->redirectToRoute('app_edit_offer');

    }

}