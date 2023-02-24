<?php

namespace App\Controller\Front;

use App\Entity\VerificationRequest;
use App\Repository\ItemsRepository;
use App\Repository\VerificationRequestRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Items;
use App\Form\VerificationRequestType;


#[Route('/request')]
class VerificationRequestController extends AbstractController
{
    #[Route('/', name: 'app_verification_request_index', methods: ['GET'])]
    public function getVerificationRequest(VerificationRequestRepository $verificationRequestRepository, Request $request): Response
    {
        return $this->render('back/verification_request/index.html.twig', [
            'nav' => 'verification_request',
            'verification_requests' => $verificationRequestRepository->findAll(),
        ]);
    }

    #[Route('/item/{id}', name: 'app_verification_request_new', methods: ['GET', 'POST'])]
    public function createVerificationRequest(ManagerRegistry $doctrine, Request $request, VerificationRequestRepository $verificationRequestRepository): Response
    {
        $user = $this->getUser();
        $id = $request->get('id');
        $item = $doctrine->getRepository(Items::class)->find($id);
        $itemName = $item->getName();
        $verificationRequest = new VerificationRequest();
        $verificationRequest->setRequestedBy($user);
        $verificationRequest->setItemRequested($item);
        $form = $this->createForm(VerificationRequestType::class, $verificationRequest);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $verificationRequestRepository->save($verificationRequest, true);
            $session = new Session();
            $session->getFlashBag()->add('success_create_request', "La demande de certifier l'item " .$itemName ." a bien été envoyée.");

            return $this->redirectToRoute('front_app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('front/verification_request/new.html.twig', [
            'controller_name' => 'VerificationRequestController',
            'item_name' => $itemName,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/request/{id}/accept', name: 'app_verification_request_accept', methods: ['GET', 'POST'])]
    public function acceptVerificationRequest(ManagerRegistry $doctrine, Request $request, VerificationRequestRepository $verificationRequestRepository, ItemsRepository $itemsRepository) {
        $id = $request->get('id');
        $verificationRequest = $doctrine->getRepository(VerificationRequest::class)->find($id);
        $verificationRequest->setStatus('Accepté');
        $verificationRequestRepository->save($verificationRequest, true);
        $item = $verificationRequest->getItemRequested();
   
        $item->setIsVerified(true);
        $itemsRepository->save($item, true);

        $session = new Session();
        $session->getFlashBag()->add('success_accept_request', "La demande de certifier l'item " .$item->getName() ." a bien été acceptée.");

        return $this->redirectToRoute('front_app_verification_request_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/request/{id}/refuse', name: 'app_verification_request_refuse', methods: ['GET', 'POST'])]
    public function refuseVerificationRequest(ManagerRegistry $doctrine, Request $request, VerificationRequestRepository $verificationRequestRepository) {
        $id = $request->get('id');
        $verificationRequest = $doctrine->getRepository(VerificationRequest::class)->find($id);
        $verificationRequest->setStatus('Refusé');
        $verificationRequestRepository->save($verificationRequest, true);
        $item = $verificationRequest->getItemRequested();

        $session = new Session();
        $session->getFlashBag()->add('success_refuse_request', "La demande de certifier l'item " .$item->getName() ." a bien été refusée.");

        return $this->redirectToRoute('front_app_verification_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
