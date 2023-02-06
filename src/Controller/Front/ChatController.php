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

#[Route('/chat', name: 'chat_')]
class ChatController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CookieGenerator $cookieGenerator): Response
    {
        $response = $this->render('front/chat/index.html.twig', []);
        $response->headers->setCookie($cookieGenerator->generate());

        return $response;
    }

    #[Route('/send', name: 'send', methods: ["POST"])]
    public function ping(MessageBusInterface $bus, Request $request): RedirectResponse
    {
        $data = json_decode($request->getContent());

        $update = new Update("/messages/main-chat", json_encode([
            "content" => $data->content
        ]));
        $bus->dispatch($update);

        return $this->redirectToRoute("front_chat_index");
    }
}
