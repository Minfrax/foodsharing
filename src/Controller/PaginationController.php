<?php
/**
 * Created by PhpStorm.
 * User: Student
 * Date: 19/04/2019
 * Time: 16:41
 */

namespace App\Controller;

use App\Repository\OfferRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\DefaultController;
use Symfony\Component\HttpFoundation\Response;


class PaginationController extends DefaultController
{
    /**
     * @Route("homepage", name="homepage")
     * @param OfferRepository $repository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return
     */
    public function indexAction(OfferRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query = '', /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('homepage.html.twig', [
            'pagination' => $pagination,
        ]);
        // parameters to template
        return $this->render('AcmeMainBundle:Offer:homepage.html.twig', array('pagination' => $pagination));
    }
}