<?php
/**
 * Created by PhpStorm.
 * User: Student
 * Date: 16/04/2019
 * Time: 16:09
 */

namespace App\Controller;

use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Offer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Twig\Environment;

class ViewOfferController extends AbstractController
{
    /**
     * @Route("/offer/{id}", name="offer_viewPage")
     */
    public function viewPage(Request $request, Environment$twig, OfferRepository $repository, Offer $id)
    {
        // Fecthing the offer
        return new Response(
            $twig->render(
                'OfferView/viewOfferForm.html.twig',
                [
                    'offers' => $repository->findBy(
                        [
                            'id' => $request->get('id')
                        ]
                    )
                ]
            )
        );

    }


    /**
     * @Route("/picture/{picture}", name="get_picture_content")
     */

    public function gimmePic(Offer $picture)
    {

        $path = $this->getParameter('upload_directory') . $picture->getPicturePath();

        return new Response(
            file_get_contents($path),
            200,
            [
                'Content-Type' => $picture->getMimeType()
            ]
        );
    }


}