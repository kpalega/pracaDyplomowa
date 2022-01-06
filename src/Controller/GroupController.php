<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    private $LIMIT = 10;
    private $OFFSET = 0;

    #[Route('/groups/{page}', name: 'groups', options: ['expose' => true])]
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

    #[Route('/addGroup', name: 'addGroup', options: ['expose' => true] )]
    public function addGroup( Request $request ): Response{
        $group = new Group();

        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);
        
        $entityManager = $this->getDoctrine()->getManager(); 
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $children = new Child();
            $children = $form->get("children")->getData();
            
            $entityManager->persist($group);
            $entityManager->flush();

            foreach ($children as $child){
                $child->addIdclass($group);
                $group->addIdchild($child);
                
                $entityManager->persist($group);
                $entityManager->flush();
            
                $entityManager->persist($child);
                $entityManager->flush();
            }
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

    #[Route('/detailsGroup/{id}', name: 'detailsGroup', options: ['expose' => true])]
    public function detailsGroup($id): Response{
    
        $entityManager = $this->getDoctrine()->getManager(); 
        $group = new Group();
        $group = $entityManager->getRepository(Group::class)->find($id);
        $children =$group->getIdchild();
        return $this->render('group/details.html.twig', [
            'group' => $group,
            'children' => $children
        ]);
    }

    #[Route('/archiveGroup/{id}', name: 'archiveGroup')]
    public function archiveGroup($id, Request $request){
        if ($request->isXmlHttpRequest()) {  
            $entityManager = $this->getDoctrine()->getManager(); 
            $group = new Group();
            $group = $entityManager->getRepository(Group::class)->find($id);
            $group->setActive(false);
            $entityManager->persist($group);
            $entityManager->flush();
            return new JsonResponse("Pomyślnie usunięto");
        }
        else {
            return new JsonResponse("Błąd"); 
        }
    }
}
