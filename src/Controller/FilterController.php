<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class FilterController extends AbstractController
{

    /**
     * @Route ("/reloadContent/{cantonID}", name="reloadContent")
     * @param Request $request
     * @param Environment $twig
     * @param OfferRepository $repository
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function filterAction(Request $request, Environment $twig, OfferRepository $repository)
    {
        return new Response(
            $twig->render(
                'Default/reloadContent.html.twig',
                [
                    'offers' => $repository->findBy(
                    [
                        'cantonID' => $request->attributes->get('cantonID')
                    ]
                    )
                ]
            )
        );
    }
}