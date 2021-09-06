<?php

namespace App\Controller;

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
    #[Route('/news/{page}', name: 'news')]
    public function index($page): Response
    {
        $LIMIT = 5;
        $OFFSET = $LIMIT * ( $page - 1 );

        $entityManager = $this->getDoctrine()->getManager(); 
        $newsRepository = new NewsRepository($entityManager);

        $news = $newsRepository->findByLimit($LIMIT, $OFFSET);
        $pages = $newsRepository->countPages($LIMIT);

        return $this->render('news/index.html.twig', [
            "news" => $news,
            'pages' => $pages,
        ]);
    }

    #[Route('/addNews', name: 'addNews')]
    public function addNews(Request $request): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager(); 

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $news->setIduser($user);
            $date = new DateTime('now', (new \DateTimeZone('Europe/Warsaw')));

            $news->setDate($date);
            $entityManager->persist($news);
            $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Artykuł został dodany!'    
                );

            unset($news);
            unset($form);
            $news = new News();
            $form = $this->createForm(NewsType::class, $news);
        
        }

        return $this->render('news/addNews.html.twig', [
            "newsForm" => $form->createView(),
        ]);
    }
}
