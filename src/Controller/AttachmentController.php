<?php

namespace App\Controller;

use App\Entity\News;
use App\Services\AttachmentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttachmentController extends AbstractController
{

    private $attachmentManager;

    public function __construct(AttachmentManager $attachmentManager)
    {
        $this->attachmentManager = $attachmentManager;
    }

    #[Route('/attachment/{id}', name: 'attachment')]
    public function index(Request $request, String $id): Response
    {
        $file = $request->files->get('file');
        $news = $this->attachmentManager->getNews($id);
        $filenameAndPath = $this->attachmentManager->uploadAttachment($file, $news);
        return $this->json([
            'location' => $filenameAndPath['path']
        ]); 
    }
}
