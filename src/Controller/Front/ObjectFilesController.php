<?php

namespace App\Controller\Front;

use App\Entity\ObjectFiles;
use App\Form\ObjectFilesType;
use App\Repository\ObjectFilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/object/files')]
class ObjectFilesController extends AbstractController
{
    #[Route('/', name: 'app_object_files_index', methods: ['GET'])]
    public function index(ObjectFilesRepository $objectFilesRepository): Response
    {
        return $this->render('object_files/index.html.twig', [
            'object_files' => $objectFilesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_object_files_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ObjectFilesRepository $objectFilesRepository): Response
    {
        $objectFile = new ObjectFiles();
        $form = $this->createForm(ObjectFilesType::class, $objectFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectFilesRepository->save($objectFile, true);

            return $this->redirectToRoute('app_object_files_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('object_files/new.html.twig', [
            'object_file' => $objectFile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_object_files_show', methods: ['GET'])]
    public function show(ObjectFiles $objectFile): Response
    {
        return $this->render('object_files/show.html.twig', [
            'object_file' => $objectFile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_object_files_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ObjectFiles $objectFile, ObjectFilesRepository $objectFilesRepository): Response
    {
        $form = $this->createForm(ObjectFilesType::class, $objectFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectFilesRepository->save($objectFile, true);

            return $this->redirectToRoute('app_object_files_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('object_files/edit.html.twig', [
            'object_file' => $objectFile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_object_files_delete', methods: ['POST'])]
    public function delete(Request $request, ObjectFiles $objectFile, ObjectFilesRepository $objectFilesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objectFile->getId(), $request->request->get('_token'))) {
            $objectFilesRepository->remove($objectFile, true);
        }

        return $this->redirectToRoute('app_object_files_index', [], Response::HTTP_SEE_OTHER);
    }
}
