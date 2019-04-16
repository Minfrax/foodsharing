<?php

namespace App\Controller;


use App\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DefaultController
{
    /**
     * @Route("/", name="homepage")
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\RuntimeError
     * @throws \Twiig\Error\SyntaxError
     */
    public function hompageAction(Environment $twig, Request $request, OfferRepository $repository)
    {
        return new Response(
            $twig->render(
                'Default/homepage.html.twig',
            [
                'offers' => $repository->findAll(
                    $request
                )
            ]
            )
        );
    }

    /**
     * @param Environment $twig
     * @Route("/view", name="viewOfferForm")
     * @return Response
     */
    public function testAction(Environment $twig, Request $request, OfferRepository $repository)
    {
        return new Response(
            $twig->render(
                'OfferView/viewOfferForm.html.twig',
                [
                    'offers' => $repository->findAll(
                        $request
                    )
                ]
            )
        );
    }
}