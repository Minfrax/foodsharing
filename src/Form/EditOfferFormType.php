<?php


namespace App\Form;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class EditOfferFormType
 /**
 * @Route("/EditOffer", name="app_edit_offer")
 */

{
    public function editDashboard(Environment $twig)
    {
        return new Response($twig->render('OfferCED/UserEditOffer.html.twig'));
    }


}