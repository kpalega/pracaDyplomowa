<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\containsEqual;

class HomeController extends AbstractController
{
    #[Route('/', name: 'start', options: ['expose' => true])]
    public function start(): Response
    {
        return $this->render('home/start.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home', name: 'home', options: ['expose' => true])]
    public function home(): Response
    {
        
        $user = new User();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        if( in_array('ROLE_TEACHER', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles()) ){
            
            return $this->render('home/home.html.twig', [
            ]);
        } else {
            return $this->redirect('/news/1');
        }
    }
}
