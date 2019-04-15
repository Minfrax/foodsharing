<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CreateOfferController extends AbstractController
{
    /**
     * @Route("/create", name="app_create")
     */
    public function createOffer (
        Request $request,
        FormFactoryInterface $formFactory,
        Environment $twig
    )
    {

    }
}