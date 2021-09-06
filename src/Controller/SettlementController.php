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

class SettlementController extends AbstractController
{
    #[Route('/settlement/{modifier}/{page}', name: 'settlement')]
    public function index( $page, $modifier ): Response
    {
        $LIMIT = 10;
        $OFFSET = $LIMIT * ( $page - 1 );
        
        $dateEnd = new \DateTime('@'.strtotime('today midnight'));
        $dateEnd->setTime(23,59);
        $dateStart = new DateTime();
        $dateStart->setDate($dateEnd->format('Y'), $dateEnd->format('m'), 1)->setTime(0,0);
        
        if( $modifier != 0){
            $dateEnd = $dateEnd->modify("$modifier month");
            $dateStart = $dateStart->modify("$modifier month");
        }

        $dateEnd->modify('last day of this month');

        $entityManager = $this->getDoctrine()->getManager();    
        $invRepo = new InvoiceRepository( $entityManager );
        $invoices = $invRepo->findByDate( $dateEnd, $dateStart, $LIMIT, $OFFSET );
        
        $pages = $invRepo->countPages($dateEnd,$dateStart,$LIMIT);
        $montlyBilling = $this->monthlyBilling($dateEnd,$dateStart);
        $yearlyBilling = $this->yearlyBilling($dateStart);
        dump($montlyBilling);
        dump($yearlyBilling);
        return $this->render('settlement/index.html.twig', [
            'controller_name' => 'SettlementController',
            'invoices' =>  $invoices,
            'month' => $dateStart->format('F'),
            'year' => $dateStart->format('Y'),
            'pages' => $pages,
            'categoriesMonth' => $montlyBilling,
            'categoriesYear' => $yearlyBilling,
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
    
    public function monthlyBilling($dateEnd, $dateStart) {

        $entityManager = $this->getDoctrine()->getManager();
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $invoiceRepo = new InvoiceRepository( $entityManager );

        foreach ($categories as $c)
        {
            $c->setSpecialValue(0);
            $c->setValue(0);
            $val = 0;
            $valSpec = 0;
            $invoices = $invoiceRepo->getInvoicesByCategory($c->getIdcategory(), $dateEnd, $dateStart);
            
            foreach ($invoices as $i){
                if(!$i->getSpecial()){
                    $val += $i->getValue();
                }
                else{
                    $valSpec += $i->getValue();
                }
            }
            
            $c->setSpecialValue($valSpec);
            $c->setValue($val);
        }
        dump($categories);
        return $categories;
    }

    public function yearlyBilling($date) {
        $dateStart = new DateTime(); 
        $dateStart->setDate($date->format('Y'), 1, 1)->setTime(0,0);
        $dateEnd = new DateTime(); 
        $dateEnd->setDate($date->format('Y'), 12, 31)->setTime(23,59);

        $entityManager = $this->getDoctrine()->getManager();
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $invoiceRepo = new InvoiceRepository( $entityManager );

        foreach ($categories as $c)
        {
            $val = 0;
            $valSpec = 0;

            $c->setSpecialValue(0);
            $c->setValue(0);
            $invoices = $invoiceRepo->getInvoicesByCategory($c->getIdcategory(), $dateEnd, $dateStart);
            foreach ($invoices as $i){
                if(!$i->getSpecial()){
                    $val += $i->getValue();
                }
                else{
                    $valSpec += $i->getValue();
                }
            }
            $c->setValue($val);
            $c->setSpecialValue($valSpec);
        }
        dump($categories);

        return $categories;
    }
}