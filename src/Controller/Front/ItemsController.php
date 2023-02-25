<?php

namespace App\Controller\Front;

use App\Entity\Deal;
use App\Entity\Items;
use App\Entity\User;
use App\Form\ItemsType;
use App\Repository\CategoryRepository;
use App\Repository\ItemsRepository;
use App\Repository\DealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/items')]
class ItemsController extends AbstractController
{
    #[Route('/', name: 'app_items_index', methods: ['GET'])]
    public function index(ItemsRepository $itemsRepository): Response
    {
        return $this->render('front/items/index.html.twig', [
            'items' => $itemsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_items_new')]
    public function new(Request $request, ItemsRepository $itemsRepository, CategoryRepository $categoryRepository): Response
    {

        $item = new Items();
        $form = $this->createForm(ItemsType::class, $item);
        $form->handleRequest($request);

        //set le owner 
        $owner = $this->getUser();
        if ($owner) {
            $item->setOwner($owner);
        };

        if ($form->isSubmitted() && $form->isValid()) {
            $itemsRepository->save($item, true);

            return $this->redirectToRoute('front_profil_me', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/items/new.html.twig', [
            'item' => $item,
            'form' => $form,
            'categories' => $categoryRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'app_items_show', methods: ['GET'])]
    public function show(Items $item): Response
    {
        $connectedUser = $this->getUser();
        if($item->getOwner() != $connectedUser){
            return $this->redirectToRoute('front_profil_me', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/items/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Items $item, ItemsRepository $itemsRepository, CategoryRepository $categoryRepository): Response
    {
        $connectedUser = $this->getUser();
        if($item->getOwner() != $connectedUser){
            return $this->redirectToRoute('front_profil_me', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(ItemsType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemsRepository->save($item, true);

            return $this->redirectToRoute('front_profil_me', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/items/edit.html.twig', [
            'item' => $item,
            'form' => $form,
            'categories' => $categoryRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'app_items_delete', methods: ['POST'])]
    public function delete(Request $request, Items $item, ItemsRepository $itemsRepository): Response
    {
        $connectedUser = $this->getUser();
        if($item->getOwner() != $connectedUser){
            return $this->redirectToRoute('front_profil_me', [], Response::HTTP_SEE_OTHER);
        }

        if ($this->isCsrfTokenValid('delete' . $item->getId(), $request->request->get('_token'))) {
            $itemsRepository->remove($item, true);
        }

        return $this->redirectToRoute('front_profil_me', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/exchange-with-user/{id}', name: 'app_items_exchange', methods: ['GET'])]
    public function itemExchange(User $secondeUser, DealRepository $dealRepository): Response
    {
        $connecterUser = $this->getUser();

        if ($secondeUser) {
            $items =  $secondeUser->getItems();
            $notAlreadyExist = [];
            $alreadyExist = [];

            for ($i = 0; $i < count($items); $i++) {
                if ($dealItem = $dealRepository->findOneBy(['secondUserObject' => $items[$i]->getId()])) {
                    if ($dealItem->getFirstUser() && $dealItem->getSecondUser()) {
                        if ($foundDeal = $dealRepository->findBy(['secondUserObject' => $items[$i]->getId(), 'firstUser' => $connecterUser->getId(), 'secondUser' => $secondeUser->getId()])) {
                            array_push($alreadyExist, $foundDeal);
                        } else {
                            array_push($notAlreadyExist, $items[$i]);
                        }
                    }
                } else {
                    array_push($notAlreadyExist, $items[$i]);
                }
            }

            return $this->render('front/items/userItemsExchange.html.twig', [
                'items' => $notAlreadyExist,
                'user' => $secondeUser,
            ]);
        }
    }


    #[Route('/response-exchange-with-user/{id}', name: 'app_items_exchange_response', methods: ['GET'])]
    public function itemExchangeRespponse(User $firstUser, DealRepository $dealRepository, Request $request): Response
    {

        $deal = $request->query->get('deal');
        $connecterUser = $this->getUser();
        $itemsTemp = [];

        if ($firstUser) {
            $items =  $firstUser->getItems();
            for($i = 0; $i < count($items); $i++) {
                $dealOfItem = $dealRepository->findOneBy(['firstUserObject' => $items[$i]->getId(), 'status' => array("Crée","Acceptée") ]);
                if (! $dealOfItem) {
                    array_push($itemsTemp, $items[$i]);
                }
            }
            

            return $this->render('front/items/userItemsExchangeResponse.html.twig', [
                'items' => $itemsTemp,
                'firstUser' => $firstUser,
                'deal' => $deal,
            ]);
        }
    }
}
