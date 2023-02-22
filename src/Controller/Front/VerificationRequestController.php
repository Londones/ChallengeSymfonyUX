<?php

namespace App\Controller\Front;

use App\Entity\VerificationRequest;
use App\Repository\VerificationRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/request')]
class VerificationRequestController extends AbstractController
{
    #[Route('/', name: 'app_verification_request')]
    public function index(Request $request, VerificationRequest $verificationRequest, VerificationRequestRepository $verificationRequestRepository): Response
    {
        $form = $this->createForm(VerificationRequestType::class, $verificationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $verificationRequestRepository->save($verificationRequest, true);

            return $this->redirectToRoute('front_app_items_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('verification_request/index.html.twig', [
            'controller_name' => 'VerificationRequestController',
            'form' => $form,
        ]);
    }
}
