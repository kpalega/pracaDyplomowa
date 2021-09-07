<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    private $LIMIT = 10;
    private $OFFSET = 0;

    #[Route('/groups/{page}', name: 'groups')]
    public function index($page): Response
    {
        $this->OFFSET = $this->LIMIT * ( $page - 1 );
        
        $entityManager = $this->getDoctrine()->getManager(); 
        $groupRepository = new GroupRepository($entityManager);

        $groups = new Group();
        $groups = $groupRepository->findByLimit($this->LIMIT, $this->OFFSET);
        
        $pages = $groupRepository->countPages($this->LIMIT);

        return $this->render('group/index.html.twig', [
            'pages' => $pages,
            'groups' => $groups
        ]);
    }

    #[Route('/addGroup', name: 'addGroup')]
    public function addGroup( Request $request ): Response{
        $group = new Group();

        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);
        
        $entityManager = $this->getDoctrine()->getManager(); 
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($group);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Grupa została dodana!'
            );

            unset($group);
            unset($form);
            $group = new Group();
            $form = $this->createForm(GroupType::class, $group);
        }

        return $this->render('group/addGroup.html.twig', [
            "groupForm" => $form->createView(),
        ]);
    }
}
