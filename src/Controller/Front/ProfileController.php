<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Entity\Deal;
use App\Form\ProfileType;
use App\Repository\DealRepository;
use App\Repository\ItemsRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
#[UniqueEntity(fields: ['email'], message: "Le user existe déjà")]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        if ($user) {
            $itemsOfUser = $user->getItems();
        } else {
            return $this->redirectToRoute('front_app_login');
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'items' => $itemsOfUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('front_app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('front_app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/public/{id}/', name: 'app_user_show_public', methods: ['GET'])]
    public function showPublicProfil(User $user): Response
    {
        if ($user) {
            return $this->render('user/show_public.html.twig', [
                'user' => $user,
            ]);
        }
    }
}
