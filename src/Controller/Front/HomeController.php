<?php

namespace App\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepo): Response
    {
        $connectedUser = $this->getUser();
        $userToSwipe = $userRepo->getUserToSwipe($connectedUser);
        //dd($userToSwipe);

        return $this->render('front/home/index.html.twig', [
            'userToSwipe' => $userToSwipe
        ]);
    }
}
