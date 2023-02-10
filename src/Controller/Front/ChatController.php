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
use App\Entity\Message;
use App\Entity\User;
use App\Repository\ChannelRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/chat', name: 'chat_')]
class ChatController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $user, ManagerRegistry $doctrine): Response
    {
        //$entityManager = $doctrine->getManager();

        $firstUser = $user->find(1);
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

        if (!$connectedUser) {
            return $this->redirectToRoute('front_home_index', []);
        }

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
            'channels' => $channelList
        ]);
    }

    #[Route('/match/{id}', name: 'match')]
    public function chat($id, ChannelRepository $channelRepo, CookieGenerator $cookieGenerator): Response
    {
        $connectedUser = $this->getUser();

        $channel = $channelRepo->find($id);
        $messageList = $channel->getMessages();
        $chattingWith = $channel->getFirstUser() == $connectedUser ? $channel->getSecondUser() : $channel->getFirstUser();

        $response = $this->render('front/chat/chat.html.twig', [
            'channelId' => $channel->getId(),
            'messages' => $messageList,
            'chattingWith' => $chattingWith
        ]);
        //$response->headers->setCookie($cookieGenerator->generate());

        return $response;
    }

    #[Route('/send', name: 'send', methods: ["POST"])]
    public function sendMessage(MessageRepository $messageRepo, ChannelRepository $channelRepo, MessageBusInterface $bus, Request $request): Response
    {
        $sender = $this->getUser();

        if (!$sender){
            return new Response("Not authorized", 403);
        }

        $data = json_decode($request->getContent());

        $channel = $channelRepo->find($data->channelId);
        $content = $data->content;

        $message = new Message();
        $message->setSender($sender);
        $message->setContent($content);
        $message->setChannel($channel);
        $messageRepo->save($message, true);

        // Serialize message to send on json format
        $messageSerialized = [
            'content' => $message->getContent(),
            'user' => [
                'id' => $message->getSender()->getId(),
                'name' => $message->getSender()->getName(),
            ],
            'date' => $message->getCreationDate(),
        ];

        $update = new Update("/messages/channel/" . $channel->getId(), json_encode([
            "message" => $messageSerialized,
        ]));
        $bus->dispatch($update);

        return new Response("Message successfully sent", 200);
    }
}
