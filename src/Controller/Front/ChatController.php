<?php

namespace App\Controller\Front;

use App\Mercure\CookieGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Channel;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/chat', name: 'chat_')]
class ChatController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $user, ManagerRegistry $doctrine): Response
    {
        //$entityManager = $doctrine->getManager();

        //$firstUser = $user->find(5);
        //$secondUser = $user->find(4);

        //$match = new Matche();
        //$match->setFirstUser($firstUser);
        //$match->setSecondUser($secondUser);

        //$channel = new Channel();
        //$channel->setFirstUser($firstUser);
        //$channel->setSecondUser($secondUser);

        //$entityManager->persist($match);
        //$entityManager->persist($channel);
        //$entityManager->flush();

        $connectedUser = $this->getUser();

        $channelListRequest = $user->getChannels($connectedUser);
        $channelList = [];

        foreach($channelListRequest as $channel) {
            $otherUser = $channel->getFirstUser() == $connectedUser ? $channel->getSecondUser() : $channel->getFirstUser();
            array_push($channelList, [
                'user' => $otherUser,
                'id' => $channel->getId(),
            ]);
        }

        return $this->render('front/chat/index.html.twig', [
            'channelList' => $channelList
        ]);
    }

    #[Route('/match/{id}', name: 'match')]
    public function chat($id, CookieGenerator $cookieGenerator): Response
    {
        $response = $this->render('front/chat/chat.html.twig', [
            'channelId' => $id,
        ]);
        //$response->headers->setCookie($cookieGenerator->generate());

        return $response;
    }

    #[Route('/send', name: 'send', methods: ["POST"])]
    public function sendMessage(MessageBusInterface $bus, Request $request): RedirectResponse
    {
        $data = json_decode($request->getContent());
        $channelId = $data->channelId;
        $sender = $this->getUser();

        $update = new Update("/messages/channel/" . $channelId, json_encode([
            "content" => $data->content
        ]));
        $bus->dispatch($update);

        return $this->redirectToRoute("front_chat_index");
    }
}
