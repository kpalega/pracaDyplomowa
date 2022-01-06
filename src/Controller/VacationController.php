<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vacation;
use App\Form\VacationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VacationController extends AbstractController
{
    #[Route('/addVacation/{id}', name: 'addVacation')]
    public function index($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager(); 
        $teacher = new User();
        $teacher = $entityManager->getRepository(User::class)->find($id);
        
        $temp = $entityManager->getRepository(Vacation::class)->findOneBy(array('iduser' => $teacher->getID()));

        $vacation = new Vacation();
        if($temp == null){
            $options = [
                'years' => 0,
                'vacation' => 0
            ];
        } else {
            $options = [
                'years' => $temp->getWorkedyears(),
                'vacation' => $temp->getVacationdays()
            ];
        }
            
        $form = $this->createForm(VacationType::class, $vacation, $options );
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            if($temp != null){
                $temp->setVacationdays($vacation->getVacationdays());
                $temp->setWorkedyears($vacation->getWorkedyears());
                $entityManager->persist($temp);
                $entityManager->flush();
            } 
            else {
                $vacation->setIduser($teacher);
                $entityManager->persist($vacation);
                $entityManager->flush();
            }
            return $this->redirect("/personnel/1");
        }

        return $this->render('vacation/index.html.twig', [
            'vacationForm' => $form->createView(),
        ]);
    }
}
