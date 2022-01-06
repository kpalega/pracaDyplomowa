<?php 

namespace App\Services;

use App\Entity\Attachment;
use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AttachmentManager{
    
    private $container; 
    private $entityManager;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
    }
    
    public function getNews (String $id){
        return $this->entityManager->getRepository(News::class)->find($id);
    }

    public function uploadAttachment(UploadedFile $file, News $news){
        $filename = md5(uniqid()) . "." . $file->guessExtension();

        $file->move(
            $this->getUploadsDirectory(),
            $filename
        );
    
        $attachment = new Attachment();

        $attachment->setFilename($filename);
        $attachment->setPath( "/uploads/" . $filename);
   
        $news->setAttachment($attachment);
        $this->entityManager->persist($attachment);
        $this->entityManager->flush();

        return [
            'filename' => $attachment->getFilename(),
            'path' => $attachment->getPath(),
        ];
    }

    public function getUploadsDirectory(){
        return $this->container->getParameter('uploads');
    }
}