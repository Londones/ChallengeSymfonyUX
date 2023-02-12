<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewCategoryController extends AbstractController
{
    #[Route('/view/category', name: 'app_view_category')]
    public function index(): Response
    {
        return $this->render('front/view_category/index.html.twig', [
            'controller_name' => 'ViewCategoryController',
        ]);
    }

    public function getCategoriesByUserId($userId): array
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(['user_id' => $userId]);

        return $categories;
    }

    public function getAllCategories(): array
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $categories;
    }

    public function addCategoryToUser($userId, $categoryId): void
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($userId);

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($categoryId);

        $user->addCategory($category);
        $category->addUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->persist($category);
        $entityManager->flush();
    }
}
