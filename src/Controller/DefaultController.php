<?php

namespace App\Controller;


use App\Repository\OfferRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function hompageAction(Request $request, Environment $twig,  OfferRepository $repository, PaginatorInterface $paginator)
    {
        return new Response(
            $twig->render(
                'Default/homepage.html.twig',
            [
                'offers' => $repository->findPaginated(
                    $request,
                    $paginator
                )
            ]
            )
        );
    }


    /**
     * @param Environment $twig
     * @return Response
     * @Route("/tos", name="terms")
     */
    public function termOfService(Environment $twig)
    {
        return new Response(
            $twig->render(
                'Terms/terms.html.twig'
            )
        );
    }










































    public function filterAction(Request $request, Environment $twig, OfferRepository $repository)
    {
        return new Response(
            $twig->render(
                'Default/homepage.html.twig',
                [
                    'offers' => $repository->findBy(
                        [
                            'cantonID' => $request->get('cantonID')
                        ]
                    )
                ]
            )
        );
    }
}