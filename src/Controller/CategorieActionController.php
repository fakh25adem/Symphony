<?php

namespace App\Controller;

use App\Entity\CategorieAction;
use App\Form\CategorieActionType;
use App\Repository\CategorieActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorie/action')]
final class CategorieActionController extends AbstractController
{
    #[Route(name: 'app_categorie_action_index', methods: ['GET'])]
    public function index(CategorieActionRepository $categorieActionRepository): Response
    {
        return $this->render('categorie_action/index.html.twig', [
            'categorie_actions' => $categorieActionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_action_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieAction = new CategorieAction();
        $form = $this->createForm(CategorieActionType::class, $categorieAction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieAction);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_action_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_action/new.html.twig', [
            'categorie_action' => $categorieAction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_action_show', methods: ['GET'])]
    public function show(CategorieAction $categorieAction): Response
    {
        return $this->render('categorie_action/show.html.twig', [
            'categorie_action' => $categorieAction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_action_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieAction $categorieAction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieActionType::class, $categorieAction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_action_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_action/edit.html.twig', [
            'categorie_action' => $categorieAction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_action_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieAction $categorieAction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieAction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categorieAction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_action_index', [], Response::HTTP_SEE_OTHER);
    }
}
