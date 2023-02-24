<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil', name: 'profil_')]
#[UniqueEntity(fields: ['email'], message: "Le user existe déjà")]
class ProfileController extends AbstractController
{
    #[Route('/me', name: 'me', methods: ['GET'])]
    public function show(): Response
    {
        $user = $this->getUser();
        if($user){
            $itemsOfUser = $user->getItems();
        } else {
            return $this->redirectToRoute('front_app_login');
        }
        return $this->render('front/profil/show.html.twig', [
            'user' => $user,
            'items' => $itemsOfUser,
        ]);
    }

    #[Route('/me/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('front_profil_me',[], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/profil/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/me', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$this->getUser()->getId(), $request->request->get('_token'))) {
            $session = new Session();
            $session->invalidate();
            $userRepository->remove($this->getUser(), true);
        }

        return $this->redirectToRoute('front_app_login');
    }

    #[Route('/public/{id}/', name: 'user', methods: ['GET'])]
    public function showPublicProfil(User $user): Response
    {
        if ($user) {
            return $this->render('front/profil/show_public.html.twig', [
                'user' => $user,
                'items' => $user->getItems(),
            ]);
        }
    }
}
