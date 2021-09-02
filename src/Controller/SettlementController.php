<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class SettlementController extends AbstractController
{
    #[Route('/settlement/{page}', name: 'settlement')]
    public function index( $page ): Response
    {
        $LIMIT = 5;
        $OFFSET = $LIMIT * ( $page - 1 );

        $datetest =  \DateTime::createFromFormat("d/m/Y","25/04/2015");
        $date = new \DateTime('@'.strtotime('today'));
        dump($datetest);
        $entityManager = $this->getDoctrine()->getManager();    
        $invRepo = new InvoiceRepository( $entityManager );
        $invoices = $invRepo->findByDate( $date, $LIMIT, $OFFSET );
        
        $allInvoices = $invRepo->count();
        
        $pages = ceil( $allInvoices/$LIMIT );
        dump ($pages);
        return $this->render('settlement/index.html.twig', [
            'controller_name' => 'SettlementController',
            'invoices' =>  $invoices,
            'month' => date('M'),
            'pages' => $pages,
        ]);
    }

    #[Route('/addInvoice', name: 'addInvoice')]
    public function addInvoice(Request $request): Response {

        $invoice = new Invoice();
        $category = new Category();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);
        
        $entityManager = $this->getDoctrine()->getManager(); 
        
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryID = $form->get("categoryId")->getData();   
            $category = $entityManager->getRepository(Category::class)->findOneBy([
                "idcategory" => $categoryID,
            ]);
            
            $invoice->setIdcategory($category);
            $entityManager->persist($invoice);
            $entityManager->flush();
        

            $this->addFlash(
                'notice',
                'Faktura została dodana!'
            );

            unset($invoice);
            unset($form);
            $invoice = new Invoice();
            $form = $this->createForm(InvoiceType::class, $invoice);
        }

        return $this->render('settlement/addInvoice.html.twig', [
            'controller_name' => 'SettlementController',
            'invoiceForm' => $form->createView(),
        ]);
    }
}