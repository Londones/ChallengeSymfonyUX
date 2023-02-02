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

    #[Route('/message', name: 'message', methods: ["POST"])]
    public function sendMessage(MessageBusInterface $bus, Request $request): RedirectResponse
    {
        $update = new Update('/messages', json_encode([
            'message' => $request->request->get('message'),
        ]));
        $bus->dispatch($update);

        return $this->redirectToRoute("front_chat_index");
    }

    #[Route('/ping', name: 'ping', methods: ["POST"])]
    public function ping(MessageBusInterface $bus): RedirectResponse
    {
        $update = new Update('http://monsite.com/ping', "[]");
        $bus->dispatch($update);

        return $this->redirectToRoute("front_chat_index");
    }
}
