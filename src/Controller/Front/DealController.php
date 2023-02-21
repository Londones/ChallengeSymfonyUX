<?php

namespace App\Controller\Front;

use App\Entity\Deal;
use App\Entity\User;
use App\Entity\Items;
use App\Form\DealType;
use App\Repository\DealRepository;
use App\Repository\ItemsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/deal')]
class DealController extends AbstractController
{
    #[Route('/', name: 'app_deal_index', methods: ['GET'])]
    public function index(DealRepository $dealRepository, UserRepository $userRepository, ItemsRepository $itemsRepository): Response
    {

        $currentUser = $this->getUser();

        //*les demandes d'échanges reçue par le user actuels
        if ($receivedExchangeRequests = $dealRepository->findBy(['secondUser' => $currentUser])) {
            for ($i = 0; $i < count($receivedExchangeRequests); $i++) {
                $secondUserId = $receivedExchangeRequests[$i]->getSecondUser()->getId();
                $secondtUser = $userRepository->findOneBy([
                    'id' =>  $secondUserId
                ]);

                $objectId = $receivedExchangeRequests[$i]->getSecondUserObject()->getId();
                $object = $itemsRepository->findOneBy([
                    'id' =>   $objectId
                ]);

                if ($secondtUser && $object) {
                    $receivedExchangeRequests[$i]->setSecondUser($secondtUser);
                    $receivedExchangeRequests[$i]->setSecondUserObject($object);
                }
            }
        }

        //*les demandes d'échanges envoyés par le user actuel
        if ($sentExchangeRequests = $dealRepository->findBy(['firstUser' =>  $currentUser])) {
            for ($i = 0; $i < count($sentExchangeRequests); $i++) {
                $secondUserId = $sentExchangeRequests[$i]->getSecondUser()->getId();
                $secondtUser = $userRepository->findOneBy([
                    'id' =>  $secondUserId
                ]);

                $objectId = $sentExchangeRequests[$i]->getSecondUserObject()->getId();
                $object = $itemsRepository->findOneBy([
                    'id' =>   $objectId
                ]);

                if ($secondtUser && $object) {
                    $sentExchangeRequests[$i]->setSecondUser($secondtUser);
                    $sentExchangeRequests[$i]->setFirstUserObject($object);
                }
            }
        }

        return $this->render('front/deal/index.html.twig', [
            'receivedExchangeRequests' =>  $receivedExchangeRequests,
            'sentExchangeRequests' =>  $sentExchangeRequests,
        ]);
    }

    #[Route('/new/{item}', name: 'app_deal_new')]
    public function new(Request $request, DealRepository $dealRepository, Items $item, UserRepository $userRepository): Response
    {

        if ($item) {
            $firstUser = $this->getUser();
            $secondUserId = $item->getOwner();
            $secondtUser = $userRepository->find($secondUserId);

            $deal = new Deal();
            $deal->setFirstUser($firstUser);
            $deal->setSecondUser($secondtUser);
            $deal->setFirstUserObject(null); //first user object que le user 1 VEUT.

            $deal->setSecondUserObject($item);
            $deal->setFirstUserResponse(null);
            $deal->setSecondeUserResponse(null);
            $deal->setStatus("Crée");

            $dealRepository->save($deal, true);
        }

        return $this->redirectToRoute('front_app_deal_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_deal_show', methods: ['GET'])]
    public function show(Deal $deal): Response
    {
        return $this->render('front/deal/show.html.twig', [
            'deal' => $deal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_deal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Deal $deal, DealRepository $dealRepository): Response
    {
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dealRepository->save($deal, true);

            return $this->redirectToRoute('front_app_deal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/deal/edit.html.twig', [
            'deal' => $deal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deal_delete', methods: ['POST'])]
    public function delete(Request $request, Deal $deal, DealRepository $dealRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $deal->getId(), $request->request->get('_token'))) {
            $dealRepository->remove($deal, true);
        }

        return $this->redirectToRoute('front_app_deal_index', [], Response::HTTP_SEE_OTHER);
    }
}
