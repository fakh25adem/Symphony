<?php

namespace App\Controller;

use App\Entity\ObjectifEnvironm;
use App\Form\ObjectifEnvironmType;
use App\Repository\ObjectifEnvironmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/objectif/environm')]
final class ObjectifEnvironmController extends AbstractController
{
    #[Route(name: 'app_objectif_environm_index', methods: ['GET'])]
    public function index(ObjectifEnvironmRepository $objectifEnvironmRepository): Response
    {
        return $this->render('objectif_environm/index.html.twig', [
            'objectif_environms' => $objectifEnvironmRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_objectif_environm_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $objectifEnvironm = new ObjectifEnvironm();
        $form = $this->createForm(ObjectifEnvironmType::class, $objectifEnvironm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($objectifEnvironm);
            $entityManager->flush();

            return $this->redirectToRoute('app_objectif_environm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('objectif_environm/new.html.twig', [
            'objectif_environm' => $objectifEnvironm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objectif_environm_show', methods: ['GET'])]
    public function show(ObjectifEnvironm $objectifEnvironm): Response
    {
        return $this->render('objectif_environm/show.html.twig', [
            'objectif_environm' => $objectifEnvironm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_objectif_environm_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ObjectifEnvironm $objectifEnvironm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ObjectifEnvironmType::class, $objectifEnvironm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_objectif_environm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('objectif_environm/edit.html.twig', [
            'objectif_environm' => $objectifEnvironm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objectif_environm_delete', methods: ['POST'])]
    public function delete(Request $request, ObjectifEnvironm $objectifEnvironm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objectifEnvironm->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($objectifEnvironm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_objectif_environm_index', [], Response::HTTP_SEE_OTHER);
    }
}
