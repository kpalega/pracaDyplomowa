<?php

namespace App\Controller;

use App\Entity\Event;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class CalenderController extends AbstractController
{
    #[Route('/calendar', name: 'calendar')]
    public function index(): Response
    {
        return $this->render('calender/index.html.twig', [

        ]);
    }

    #[Route('/calendar/fetchEvent', name: 'fetchEvent')]
    public function fetchEvent(){
        $data = [];
        $entityManager = $this->getDoctrine()->getManager();
        $events = new Event();
        $events = $entityManager->getRepository(Event::class)->findAll();
        foreach($events as $event){
            $data[] = [
                'id' => $event->getIdevent(),
                'title' => $event->getTitle(),
                'start' => $event->getStartEvent()->format(DateTime::ATOM),
                'end' => $event->getEndEvent()->format(DateTime::ATOM),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/calendar/addEvent', name: 'addEvent')]
    public function addEvent(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $event = new Event();
        if ($request->isXmlHttpRequest()) {  
            $end = new DateTime($_POST['end']);
            $start= new DateTime($_POST['start']);
            $event->setEndEvent($end);
            $event->setStartEvent($start);
            $event->setTitle($_POST['title']);
            $entityManager->persist($event);
            $entityManager->flush();
        }
        return new JsonResponse();
    }

    #[Route('/calendar/updateEvent', name: 'updateEvent')]
    public function updateEvent(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $event = new Event();
        if ($request->isXmlHttpRequest()) { 
            $event = $entityManager->getRepository(Event::class)->find($_POST['id']);
            $event->setEndEvent(new DateTime($_POST['end']));
            $event->setStartEvent(new DateTime($_POST['start']));
            $entityManager->persist($event);
            $entityManager->flush();
        }
        return new JsonResponse();
    }

    #[Route('/calendar/deleteEvent', name: 'deleteEvent')]
    public function deleteEvent(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $event = new Event();
        if ($request->isXmlHttpRequest()) { 
            $event = $entityManager->getRepository(Event::class)->find($_POST['id']);
            $entityManager->remove($event);
            $entityManager->flush();
        }
        return new JsonResponse();
    }
}
