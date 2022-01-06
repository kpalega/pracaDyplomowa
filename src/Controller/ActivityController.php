<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Entity\Child;
use App\Entity\Group;
use App\Form\ActivityType;
use DateTime;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    #[Route('/addActivity/{id}/{modifier}', name: 'addActivity')]
    public function index($modifier, $id, Request $request): Response
    {        
        $date = new DateTime();
            
        if( $modifier != 0){
             $date = $date->modify("$modifier day");
        }
        $entityManager = $this->getDoctrine()->getManager();    
        $group = new Group();
        $group = $entityManager->getRepository(Group::class)->find($id);
        $children = $group->getIdchild();
        
        $options = [];
        $options['date'] = $date;
        $options['group'] = $group->getIdclass();
        $activity = new Activities();
        $form = $this->createForm(ActivityType::class, $activity, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity->setIduser($this->get('security.token_storage')->getToken()->getUser());

            $children = new Child();
            $children = $form->get("children")->getData();
            $activity->setPresence(true);

            $entityManager->persist($activity);
            $entityManager->flush();

            foreach ($children as $child){
                $child->addIdactivity($activity);
                $activity->addIdchild($child);

                $entityManager->persist($child);
                $entityManager->flush();
            
                $entityManager->persist($activity);
                $entityManager->flush();        
            }  
            return $this->redirectToRoute('presence', ['id' => $group->getIdclass(), 'modifier' => 0]);
        }
        
        return $this->render('activity/index.html.twig', [
            'children' => $children,
            'idGroup' => $group->getIdclass(),
            'group' => $group,
            'date' => $date,
            'form' => $form->createView()
        ]);
    }

    
    #[Route('/presence/{id}/{modifier}', name: 'presence', options: ['expose' => true])]
    public function presence($modifier, $id): Response
    {
        $date = new DateTime();
            
        if( $modifier != 0){
             $date = $date->modify("$modifier day");
        }

        $entityManager = $this->getDoctrine()->getManager();    
        $group = new Group();
        $group = $entityManager->getRepository(Group::class)->find($id);
        $children =$group->getIdchild();
        
       
        return $this->render('activity/presence.html.twig', [
            'children' => $children,
            'idGroup' => $group->getIdclass(),
            'group' => $group,
            'date' => $date,
        ]);
    }
}
