<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Symfony\Component\HttpFoundation\Session\Session;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET', 'POST'])]
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
            ->add('id', TextColumn::class, [
                'label' => 'ID',
                'searchable' => false
                ])
            ->add('roles', TextColumn::class, [
                'label' => 'Rôles',
                'searchable' => false,
                'data' => function($context, $value) {
                return implode(', ', $value);
            }])
            ->add('email', TextColumn::class, [
                'label' => 'Email',
                'searchable' => true
                ])
            ->add('name', TextColumn::class, [
                'label' => 'Nom',
                'searchable' => true
                ])
            ->add('actions', TextColumn::class, [
                'label' => 'Actions',
                'orderable'=> false, 
                'render' => function($value, $context) {
                $user_id = $context->getId();
                return sprintf('<a type="button" href="/admin/user/%s"><i class="fa-regular fa-eye"></i></a>
                <a type="button" href="/admin/user/%s/edit"><i class="fa-solid fa-pen-to-square"></i></a>', $user_id, $user_id);
            }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => User::class
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('back/user/index.html.twig', [
            'nav' => 'user',
            'datatable' => $table,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $session = new Session();
            $session->getFlashBag()->add('success_add_user', "L'utilisateur " .$user->getName() ." a bien été ajouté(e).");

            return $this->redirectToRoute('back_app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/new.html.twig', [
            'nav' => 'user',
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('back/user/show.html.twig', [
            'nav' => 'user',
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $session = new Session();
            $session->getFlashBag()->add('success_edit_user', "L'utilisateur " .$user->getName() ." a bien été modifié(e).");

            return $this->redirectToRoute('back_app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/edit.html.twig', [
            'nav' => 'user',
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $session = new Session();
            $session->getFlashBag()->add('success_delete_user', "L'user " .$user->getName() ." a bien été supprimé(e).");
        }

        return $this->redirectToRoute('back_app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}