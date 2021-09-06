<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnelController extends AbstractController
{
    #[Route('/personnel/{page}', name: 'personnel')]
    public function index(): Response
    {
        return $this->render('personnel/index.html.twig', [
            'pages' => 1,
        ]);
    }
}
