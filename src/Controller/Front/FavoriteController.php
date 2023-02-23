<?php

namespace App\Controller\Front;

use App\Repository\SwipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favorite', name: 'favorite_')]
class FavoriteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SwipeRepository $swipeRepo): Response
    {
        $connectedUser = $this->getUser();
        $favorites = $connectedUser->getFavorites();

        $favList = [];
        foreach($favorites as $favorite){
            $user = $favorite->getFavReceiver();

            //Check that, even if it's in favorite, user maybe have like this user
            $isLiked = false;
            $existingSwipe = $swipeRepo->getExistingSwipe($connectedUser, $user);
            if($existingSwipe->getIsSwipeRight()){
                $isLiked = true;
            }

            array_push($favList, [
                'user' => $user,
                'isLiked' => $isLiked
            ]);
        }

        return $this->render('front/favorite/index.html.twig', [
            'favorites' => $favList,
        ]);
    }
}
