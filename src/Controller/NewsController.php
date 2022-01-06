<?php

namespace App\Controller;

use App\Entity\Attachment;
use App\Entity\News;
use App\Entity\User;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class NewsController extends AbstractController
{

    public function cropImage($str){
        $SP = strpos( $str,"<img");
        $string1 = substr($str, 0, $SP);
        $string2 = substr($str, $SP);
        $TP = strlen($string1) + strpos( $string2, "/>") + strlen("/>");
        return substr($str, 0,$SP) . substr($str, $TP, strlen($str));
    }

    public function shortFormat($str){
        $SP = strpos( $str,"<p") + strlen("<p>");
        $string1 = substr($str, 0, $SP);
        $string2 = substr($str, $SP);
        $string3 = substr($str, strpos( $string1,">") + strlen(">"));
        dump($string3);
        $TP = strlen($string1) + strpos( $string2, "</p>");
        $returnValue = substr($str,$SP, $TP-3);
        if(strlen($returnValue) > 400){
           $returnValue = substr($returnValue, 0, 401) . "...";
        }
        return $returnValue;
    }

    #[Route('/news/{page}', name: 'news', options: ['expose' => true])]
    public function index($page): Response
    {
        $LIMIT = 5;
        $OFFSET = $LIMIT * ( $page - 1 );

        $entityManager = $this->getDoctrine()->getManager(); 
        $newsRepository = new NewsRepository($entityManager);

        $news = $newsRepository->findByLimit($LIMIT, $OFFSET);
        $pages = $newsRepository->countPages($LIMIT);

        foreach($news as $new){
            $str = $new->getContent();
            $mySubString = $this->cropImage($str);      
         
            $mySubString = $this->shortFormat($mySubString);

            $new->setContent($mySubString);
        }

        return $this->render('news/index.html.twig', [
            "news" => $news,
            'pages' => $pages,
        ]);
    }

    #[Route('/addNews', name: 'addNews', options: ['expose' => true])]
    public function addNews(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager(); 
        
        $temp = new News();
        $temp->setContent("");
        $temp->setTopic("");
        $user = new User();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $temp->setIduser($user);
        
        $date = new DateTime('now', (new \DateTimeZone('Europe/Warsaw')));
        $temp->setDate($date);

        $entityManager->persist($temp);
        $entityManager->flush();

        $form = $this->createForm(NewsType::class, $temp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news = $entityManager->getRepository(News::class)->find($temp->getIdnews() - 1);
            $data = $form->getData();
            $news->setContent($data->getContent());
            $news->setTopic($data->getTopic());
            $entityManager->remove($temp);
            $entityManager->flush();

            return $this->redirect('/news/1');
        
        }

        return $this->render('news/addNews.html.twig', [
            "newsForm" => $form->createView(),
            "idnews" => $temp->getIdnews()
        ]);
    }

    #[Route('/showNews/{id}', name: 'showNews', options: ['expose' => true])]
    
    public function showNews($id): Response
    {
        $news = new News();
        $entityManager = $this->getDoctrine()->getManager(); 
        $news = $entityManager->getRepository(News::class)->find($id);

        return $this->render('news/show.html.twig', [
            'news' => $news
        ]);
    }

}
