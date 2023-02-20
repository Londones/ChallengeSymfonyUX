<?php

namespace App\Controller\Front;

use App\Entity\Items;
use App\Form\ItemsType;
use App\Repository\CategoryRepository;
use App\Repository\ItemsRepository;
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
        if($owner){
            $item->setOwner($owner);
        };

        if ($form->isSubmitted() && $form->isValid()) {
            $itemsRepository->save($item, true);

            return $this->redirectToRoute('front_app_user_index', [], Response::HTTP_SEE_OTHER);
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
        $user = $this->getUser();
        return $this->render('front/items/show.html.twig', [
            'user' => $user,
            'item' => $item,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_items_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Items $item, ItemsRepository $itemsRepository, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(ItemsType::class, $item);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $itemsRepository->save($item, true);
            
            return $this->redirectToRoute('front_app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/items/edit.html.twig', [
            'user' => $user,
            'item' => $item,
            'form' => $form,
            'categories' => $categoryRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'app_items_delete', methods: ['POST'])]
    public function delete(Request $request, Items $item, ItemsRepository $itemsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $itemsRepository->remove($item, true);
        }

        return $this->redirectToRoute('front_app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
