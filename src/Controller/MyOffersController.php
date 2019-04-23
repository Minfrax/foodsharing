<?php


namespace App\Controller;


use App\Entity\Offer;
use App\Entity\User;
use App\Form\CreateOfferFormType;
use App\Form\EditOfferFormType;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class MyOffersController extends AbstractController
{
    /**
     * @Route("/MyOffers", name="app_my_offers")
     */
    public function showEditDashboard(Environment $twig, Request $request, OfferRepository $repository, UserRepository $userRepository)
    {
        $usr = $this->getUser();
        return new Response($twig->render('/myoffers.html.twig',
            [
                'offers' => $repository->findBy(
                    [
                        'sharer_id' => $usr
                    ]
                )
            ]
        )
        );
    }


    /**
     * @Route("/MyOffers/del/{id}", name="offer_del")
     */
    public function deleteUserOffer(Request $request, Environment $twig, OfferRepository $repository,$id)
    {
        $offer = $this->getDoctrine()->getManager();

        $post = $offer->getRepository('App:Offer')->find($id);

        $offer->remove($post);
        $offer->flush();

        return $this->redirectToRoute('app_my_offers');

    }


    /**
     * @Route("/MyOffers/EditOffer/{id}", name="app_edit")
     */
    public function editOffer (
        Request $request,
        FormFactoryInterface $formFactory,
        Environment $twig,
        $id

    )
    {

        $usr = $this->getUser();

        $offer= $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($id);
        $form = $formFactory->create(
            EditOfferFormType::class,
            $offer,
            ['standalone' => true]
        );
        $form->handleRequest($request);

        $sharer = $offer->getSharerId();


        if($usr !== $sharer){
            return new Response(
                $this->redirectToRoute('homepage')
        );
        } else if ($form->isSubmitted() && $form->isValid()) {
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
            $manager->flush();

            return $this->redirectToRoute('app_my_offers');
        }

        return new Response(
            $twig->render(
                '/editOffer.html.twig',
                ['EditOfferForm' => $form->createView()]  // to addForm
            )
        );

    }

}