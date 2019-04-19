<?php

namespace App\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


/**
 * @Route("/admConsole", name="app_admin")
 */
class AdminOfferFormType
{
    public function showDashboard(Environment $twig)
    {
        return new Response($twig->render('Admin/adminDashboard.html.twig'));
    }
}