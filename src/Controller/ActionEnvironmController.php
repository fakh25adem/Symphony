<?php

namespace App\Controller;

use App\Entity\ActionEnvironm;
use App\Form\ActionEnvironmType;
use App\Repository\ActionEnvironmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/action/environm')]
final class ActionEnvironmController extends AbstractController
{
    #[Route(name: 'app_action_environm_index', methods: ['GET'])]
    public function index(ActionEnvironmRepository $actionEnvironmRepository): Response
    {
        return $this->render('action_environm/index.html.twig', [
            'action_environms' => $actionEnvironmRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_action_environm_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actionEnvironm = new ActionEnvironm();
        $form = $this->createForm(ActionEnvironmType::class, $actionEnvironm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $actionEnvironm->setPoints($actionEnvironm->getImpactCarbon()*10);
            $objectifs = $actionEnvironm->getObjectifs();

            foreach ($objectifs as $objectif) {


                    $objectif->setPtsCummules($actionEnvironm->getPoints() + $objectif->getPtsCummules());
                    if ($objectif->getPtsCummules() < $objectif->getPtsCible()) {
                        $objectif->setStatut("en cours");
                    } else {
                        $objectif->setStatut("objectif atteint");
                    }
                    $entityManager->persist($objectif);
                    $entityManager->flush();
                    $entityManager->persist($actionEnvironm);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_action_environm_index', [], Response::HTTP_SEE_OTHER);
                }
            }



        return $this->render('action_environm/new.html.twig', [
            'action_environm' => $actionEnvironm,
            'form' => $form,
        ]);
    }
    #[Route('/export/csv', name: 'app_action_environm_export_csv', methods: ['GET'])]
    public function exportCsv(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les actions environnementales
        $actionsEnvironms = $entityManager->getRepository(ActionEnvironm::class)->findAll();

        // Créer un flux de données CSV
        $csvData = [];
        $csvData[] = ['ID', 'Type', 'Description', 'Date', 'Impact Carbone', 'Points']; // En-têtes

        foreach ($actionsEnvironms as $actionEnvironm) {
            $csvData[] = [
                $actionEnvironm->getId(),
                $actionEnvironm->getType(),
                $actionEnvironm->getDescription(),
                $actionEnvironm->getDate() ? $actionEnvironm->getDate()->format('Y-m-d') : '',
                $actionEnvironm->getImpactCarbon(),
                $actionEnvironm->getPoints(),
            ];
        }

        // Créer une réponse avec un fichier CSV
        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="actions_environnementales.csv"');

        $handle = fopen('php://output', 'w');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);

        return $response;
    }


    #[Route('/{id}', name: 'app_action_environm_show', methods: ['GET'])]
    public function show(ActionEnvironm $actionEnvironm): Response
    {
        return $this->render('action_environm/show.html.twig', [
            'action_environm' => $actionEnvironm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_action_environm_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ActionEnvironm $actionEnvironm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActionEnvironmType::class, $actionEnvironm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_action_environm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('action_environm/edit.html.twig', [
            'action_environm' => $actionEnvironm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_action_environm_delete', methods: ['POST'])]
    public function delete(Request $request, ActionEnvironm $actionEnvironm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actionEnvironm->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($actionEnvironm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_action_environm_index', [], Response::HTTP_SEE_OTHER);
    }
}
