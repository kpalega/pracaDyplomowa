<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vacation;
use App\Repository\UserRepository;
use App\Repository\UserTestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnelController extends AbstractController
{
   
    private $LIMIT = 10;
    private $OFFSET = 0;
    #[Route('/personnel/{page}', name: 'personnel', options: ['expose' => true])]
    public function index($page): Response
    {

        $this->OFFSET = $this->LIMIT * ( $page - 1 );
        
        $entityManager = $this->getDoctrine()->getManager(); 
        $userRepository = new UserRepository($entityManager);

        $teachers = new User();
        $teachers = $userRepository->findByLimit($this->LIMIT, $this->OFFSET);
        
        $pages = $userRepository->countPages($this->LIMIT);

        $allVacations = $entityManager->getRepository(Vacation::class)->findAll();
        return $this->render('personnel/index.html.twig', [
            'pages' => $pages,
            "teachers" => $teachers,
            'vacations' => $allVacations,
        ]);
    }
}
