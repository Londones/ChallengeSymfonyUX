<?php

namespace App\Controller\Front;

use App\Mercure\CookieGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;
use App\Repository\ChannelRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;

#[Route('/chat', name: 'chat_')]
class ChatController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepo): Response
    {
        $connectedUser = $this->getUser();

        $channelListRequest = $userRepo->getChannels($connectedUser);
        $channelList = [];

        foreach($channelListRequest as $channel) {
            $otherUser = $channel->getFirstUser() == $connectedUser ? $channel->getSecondUser() : $channel->getFirstUser();
            $lastMessage = $channel->getMessages()->last();

            array_push($channelList, [
                'user' => $otherUser,
                'id' => $channel->getId(),
                'lastMessage' => $lastMessage
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

        if(($channel->getFirstUser() != $connectedUser) && ($channel->getSecondUser() != $connectedUser)){
            return $this->redirectToRoute('front_home_index', []);
        }

        $messageList = $channel->getMessages();
        $chattingWith = $channel->getFirstUser() == $connectedUser ? $channel->getSecondUser() : $channel->getFirstUser();

        $response = $this->render('front/chat/chat.html.twig', [
            'channelId' => $channel->getId(),
            'messages' => $messageList,
            'chattingWith' => $chattingWith
        ]);
        $response->headers->setCookie($cookieGenerator->generate());

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

        if(($channel->getFirstUser() != $sender) && ($channel->getSecondUser() != $sender)){
            return new Response("Not allowed to send on this channel", 403);
        }

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
