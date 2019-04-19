<?php


namespace App\Controller;


use App\Entity\Offer;
use App\Form\CreateOfferFormType;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $offer = new Offer();
        $form = $formFactory->create(
            CreateOfferFormType::class,
            $offer,
            ['standalone' => true]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Title

            //$title = $form->get('title')->getData();



            // Offer picture
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            $fileName = Uuid::uuid4()->toString() . '.' . $file->getExtension();
            $offer->setPicturePath($fileName);
            $offer->setSharerId($this->getUser());
            $offer->setMimeType($file->getMimeType());
            $file->move($this->getParameter('upload_directory'), $fileName);

            //
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($offer);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return new Response(
            $twig->render(
                'OfferCED/addOfferForm.html.twig',
                ['CreateOfferForm' => $form->createView()]  // to addForm
            )
        );

    }






}























