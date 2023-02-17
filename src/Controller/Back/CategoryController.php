<?php

namespace App\Controller\Back;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Symfony\Component\HttpFoundation\Session\Session;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_category_index', methods: ['GET', 'POST'])]
    public function index(DataTableFactory $dataTableFactory, Request $request) : Response
    {
        
        $table = $dataTableFactory->create()
            ->add('id', TextColumn::class, [
                'label' => 'ID',
                'searchable' => false
                ])
            ->add('name', TextColumn::class, [
                'label' => 'Libellé',
                'searchable' => false,
            ])
            ->add('description', TextColumn::class, [
                'label' => 'Description',
                'searchable' => true
            ])
            ->add('actions', TextColumn::class, [
                'label' => 'Actions',
                'orderable'=> false, 
                'render' => function($value, $context) {
                $category_id = $context->getId();
                return sprintf('<a type="button" href="/admin/category/%s"><i class="fa-regular fa-eye"></i></a>
                <a type="button" href="/admin/category/%s/edit"><i class="fa-solid fa-pen-to-square"></i></a>', $category_id, $category_id);
            }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Category::class
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('back/category/index.html.twig', [
            'nav' => 'category',
            'datatable' => $table,
        ]);
        
    }

    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);
            $session = new Session();
            $session->getFlashBag()->add('success_add_category', "La catégorie " .$category->getName() ." a bien été ajouté(e).");

            return $this->redirectToRoute('back_app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/category/new.html.twig', [
            'nav' => 'category',
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('back/category/show.html.twig', [
            'nav' => 'category',
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);
            $session = new Session();
            $session->getFlashBag()->add('success_edit_category', "La catégorie " .$category->getName() ." a bien été modifié(e).");

            return $this->redirectToRoute('back_app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/category/edit.html.twig', [
            'nav' => 'category',
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
            $session = new Session();
            $session->getFlashBag()->add('success_delete_category', "La catégorie " .$category->getName() ." a bien été supprimé(e).");
        }

        return $this->redirectToRoute('back_app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
