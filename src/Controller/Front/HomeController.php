<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $connectedUser = $this->getUser();
        $haveCategory = true;

        if(!$connectedUser->getCategory()->toArray()){
            $haveCategory = false;
        }

        return $this->render('front/home/index.html.twig', [
            'haveCategory' => $haveCategory
        ]);
    }
}
