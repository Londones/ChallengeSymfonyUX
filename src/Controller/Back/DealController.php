<?php

namespace App\Controller\Back;

use App\Repository\DealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/deal')]
class DealController extends AbstractController
{
    #[Route('/', name: 'app_deal_index', methods: ['GET'])]
    public function index(DealRepository $dealRepository): Response
    {
        return $this->render('back/deal/index.html.twig', [
            'controller_name' => 'DealController',
            'nav' => 'deal',
            'deals' => $dealRepository->findAll(),
        ]);
    }
}
