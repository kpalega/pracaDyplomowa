<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\Disability;
use App\Form\ChildType;
use App\Repository\ChildRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChildController extends AbstractController
{
    private $LIMIT = 10;
    private $OFFSET = 0;

    #[Route('/childrenbook/{page}', name: 'childrenbook' , options: ['expose' => true])]
    public function index($page): Response
    {
        $this->OFFSET = $this->LIMIT * ( $page - 1 );
        
        $entityManager = $this->getDoctrine()->getManager(); 
        $childRepository = new ChildRepository($entityManager);

        $children = $childRepository->findByLimit($this->LIMIT, $this->OFFSET);
        
        foreach ($children as $child){
            if($child->getIddisability() != null){
                $childRepository->findDisabilities($child->getIdchild());
            }
        }

        $pages = $childRepository->countPages($this->LIMIT);

        return $this->render('child/index.html.twig', [
            'pages' => $pages,
            'children' => $children
        ]);
    }
    

    
    #[Route('/addChild', name: 'addChild', options: ['expose' => true])]
    public function addChild(Request $request): Response
    {
        $child = new Child();
        $disability = new Disability();

        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);
        
        $entityManager = $this->getDoctrine()->getManager(); 
        
        if($request->isXmlHttpRequest()){
                
            if ($form->isSubmitted() && $form->isValid()) {
                
                $disabilityName = $form->get("disabilityName")->getData();   
                $disabilityDecision = $form->get("disabilityDecision")->getData();   
                
                
                $entityManager->persist($child);
                $entityManager->flush();

                $disability->setName($disabilityName);
                $disability->setDecision($disabilityDecision);
                
                $entityManager->persist($disability);
                $entityManager->flush();

                $disability->addIdchild($child);
                $child->addIddisability($disability);

                $entityManager->persist($disability);
                $entityManager->flush();
                
                $entityManager->persist($child);
                $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Dziecko został dodane!'
                );

                unset($child);
                unset($form);
                $child = new Child();
                $form = $this->createForm(ChildType::class, $child);
            }
        } else {
            return $this->render('child/addChild.html.twig', [
                "childForm" => $form->createView(),
            ]);
        }
    }

    #[Route('/archiveChild/{id}', name: 'archiveChild')]
    public function archiveGroup($id, Request $request){
        if ($request->isXmlHttpRequest()) {  
            $entityManager = $this->getDoctrine()->getManager(); 
            $child = new Child();
            $child = $entityManager->getRepository(Child::class)->find($id);
            $child->setActive(false);
            $entityManager->persist($child);
            $entityManager->flush();
            return new JsonResponse("Pomyślnie usunięto");
        }
        else {
            return new JsonResponse("Błąd"); 
        }
    }
    

}
