<?php
/**
 * Created by PhpStorm.
 * User: Student
 * Date: 16/04/2019
 * Time: 16:09
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Offer;

class OfferViewController
{
    public function presentOffer(Offer $offer){

        $offer = Offer::getId();

        return;
    }

    /**
     * @Route("/offer", name="view_offer")
     */
    public function viewOfferAction(Request $request)
    {
        $offer = Offer::getId();

        return render('templates/OfferView/viewOfferForm.html.twig');
    }
}