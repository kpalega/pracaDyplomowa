<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessangeType;
use App\Repository\MessageRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class MessangeController extends AbstractController
{
    #[Route('/messange', name: 'messange')]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager(); 
        
        $messageRepository = new MessageRepository($entityManager);

        $user = new User();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $messages = new Message();
        $messages = $messageRepository->findByUser($user);

        return $this->render('messange/index.html.twig', [
            "messages" => $messages,
            'user' => $user
        ]);
    }

    #[Route('/addMessange', name: 'addMessange')]
    public function addMessange(Request $request): Response{

        $entityManager = $this->getDoctrine()->getManager();
        $users = new User();
        $users = $entityManager->getRepository(User::class)->findBy([],[
            "surname" => "ASC"
        ]);
        $user = new User();
        $user = $this->get('security.token_storage')->getToken()->getUser();
 
        $messange = new Message();

        $form = $this->createForm(MessangeType::class, $messange, [
            "users" => $users,
            "currentUser" => $user
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $toUser = new User();
            $toUser = $form->get("toUser")->getData();

            $messange->addIduser($toUser);
            $messange->addIduser($user);
            $messange->setFromUser($user);
            $messange->setDate(new DateTime());
            $messange->setAchived(true);
            $messange->setSeen(false);

            $entityManager->persist($messange);
            $entityManager->flush();
            return $this->redirect('messange');
        }
        

        return $this->render('messange/addMessage.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/showMessage')]

    public function showMessage(Request $request) {  

        $entityManager = $this->getDoctrine()->getManager(); 
        $jsonData = array();  

        if ($request->isXmlHttpRequest()) {  
            $mess = $entityManager->getRepository(Message::class)->find($_POST['id']);
            
            $user = new User();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if($mess->getSeen() != true && $mess->getFromUser() != $user){
                $mess->setSeen(true);
                $entityManager->persist($mess);
                $entityManager->flush();
            }
           
            $temp = array(
                'topic' => $mess->getTopic(),  
                'content' => $mess->getContent(),
                'date' => $mess->getDate(),
                'seen' => $mess->getSeen(),
                'user' => $mess->getIduser(),
            );
            $jsonData[0] = $temp; 
            $result = new JsonResponse($jsonData);

            dump($result);
            return $result;
        }
        else {
            return new JsonResponse("Brak danych"); 
        }
     }         
}
