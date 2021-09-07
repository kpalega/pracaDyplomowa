<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\isNan;

class PersonnelController extends AbstractController
{
    #[Route('/personnel/{page}', name: 'personnel')]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager(); 
        $teachers = $entityManager->getRepository(User::class)->findby([
            'idspecialization' => is_scalar('idspecialization')
        ]);
        return $this->render('personnel/index.html.twig', [
            'pages' => 1,
            "teachers" => $teachers,
        ]);
    }
}
