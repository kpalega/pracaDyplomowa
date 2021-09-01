<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Invoice;
use App\Form\InvoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettlementController extends AbstractController
{
    #[Route('/settlement', name: 'settlement')]
    public function index(): Response
    {
        return $this->render('settlement/index.html.twig', [
            'controller_name' => 'SettlementController',
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