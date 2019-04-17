<?php
/**
 * Created by PhpStorm.
 * User: Student
 * Date: 16/04/2019
 * Time: 16:09
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offer;


class OfferViewController
{
    /**
     * @Route("/offer/{id}", name="view_offer")
     */
    public function viewOfferAction($id)
    {
        $offer= Offer::findById($id);
        if (!$offer) {
            throw $this->createNotFoundException('The offer does not exist');
        }
        else {
            $featured = Offer::findOne(['id' => 'featured']);
            $offer = Offer::get();

            return $this->render('templates/OfferView/viewOfferForm.html.twig', $id);
        }
    }
}