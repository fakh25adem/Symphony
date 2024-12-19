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

#[Route('/dash')]
final class DashController extends AbstractController
{
    #[Route(name: 'dash_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Dashbord/index.html.twig');
    }

}




