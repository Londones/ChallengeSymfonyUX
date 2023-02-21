<?php

namespace App\Controller\Front;

use App\Entity\Channel;
use App\Entity\Matches;
use App\Entity\Swipe;
use App\Repository\ChannelRepository;
use App\Repository\MatchesRepository;
use App\Repository\SwipeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/swipe', name: 'swipe_')]
class SwipeController extends AbstractController
{
    #[Route('/next', name: 'next', methods: ['GET'])]
    public function index(UserRepository $userRepo): Response
    {
        $connectedUser = $this->getUser();
        $userToSwipe = $userRepo->getUserToSwipe($connectedUser);

        // TODO put when items have images
        //$itemsImages = []
        //foreach($userToSwipe->getImage() as $item){
            //array_push($categories, $category->getName());
        //}

        $categories = [];
        foreach($userToSwipe->getCategory() as $category){
            array_push($categories, $category->getName());
        }

        $userSerialized = [
            'id' => $userToSwipe->getId(),
            'imageUrl' => $userToSwipe->getImage(),
            'name' => $userToSwipe->getName(),
            'categories' => $categories,
            //'itemsImage' => $itemsImages
        ];

        return new Response(json_encode(array(
            'user' => $userSerialized
        )), 200);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request, UserRepository $userRepo, SwipeRepository $swipeRepo, MatchesRepository $matchRepo, ChannelRepository $channelRepo): Response
    {
        $connectedUser = $this->getUser();

        $data = json_decode($request->getContent());

        $swippedUser = $userRepo->find($data->swippedId);

        $swipe = new Swipe();
        $swipe->setSwipper($connectedUser);
        $swipe->setSwipped($swippedUser);
        $swipe->setIsSwipeRight($data->isSwipeRight);
        $swipeRepo->save($swipe, true);

        $alreadySwiped = $swipeRepo->findOneBy(array('swipper' => $swippedUser->getId()));
        $isMatch = false;

        if ($alreadySwiped && $alreadySwiped->getIsSwipeRight() && $swipe->getIsSwipeRight()){
            //Only to handle js mistake
            $alreadyExistingMatch = $matchRepo->getExistingMatch($connectedUser, $swippedUser);

            if(!$alreadyExistingMatch){
                $isMatch = true;

                $newMatch = new Matches;
                $newMatch->setFirstUser($connectedUser);
                $newMatch->setSecondUser($swippedUser);
                $matchRepo->save($newMatch, true);

                $newChannel = new Channel;
                $newChannel->setFirstUser($connectedUser);
                $newChannel->setSecondUser($swippedUser);
                $channelRepo->save($newChannel, true);
            }
        }

        return new Response(json_encode(array(
            'isMatch' => $isMatch,
            'userName' => $swippedUser->getName()
        )), 200);
    }
}
