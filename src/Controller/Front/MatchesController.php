<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchesController extends AbstractController
{
    #[Route('/matches', name: 'app_matches')]
    public function index(): Response
    {
        return $this->render('front/matches/index.html.twig', [
            'controller_name' => 'MatchesController',
        ]);
    }
}
