<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettlementController extends AbstractController
{
    #[Route('/settlement/{modifier}/{page}', name: 'settlement')]
    public function index( $page, $modifier , Request $request ): Response
    {
        
        $dateEnd = new \DateTime('@'.strtotime('today midnight'));
        $dateEnd->setTime(23,59);
        $dateStart = new DateTime();
        $dateStart->setDate($dateEnd->format('Y'), $dateEnd->format('m'), 1)->setTime(0,0);
        
        $LIMIT = 2;
        $OFFSET = $LIMIT * ( (int) $page - 1 );
        
        if( $modifier != 0){
            $dateEnd = $dateEnd->modify("$modifier month");
            $dateStart = $dateStart->modify("$modifier month");
        }

        $dateEnd->modify('last day of this month');

        $entityManager = $this->getDoctrine()->getManager();    
        $invRepo = new InvoiceRepository( $entityManager );
        $invoices = $invRepo->findByDate( $dateEnd, $dateStart, $LIMIT, $OFFSET );
        
        $pages = $invRepo->countPages($dateEnd,$dateStart,$LIMIT);

        return $this->render('settlement/index.html.twig', [
            'controller_name' => 'SettlementController',
            'invoices' =>  $invoices,
            'month' => $dateStart->format('F'),
            'year' => $dateStart->format('Y'),
            'pages' => $pages,
            'date' => $dateEnd
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
  
    public function countValues( $dateEnd, $dateStart ){
        $entityManager = $this->getDoctrine()->getManager();
        $categoriesMonth = $entityManager->getRepository(Category::class)->findAll();
        $invoiceRepo = new InvoiceRepository( $entityManager );
  
        $jsonData = array();  
        $idx = 0;
        $valAll = 0;
        $valSpecAll = 0;
        
        foreach ($categoriesMonth as $c)
        {  
            
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
            
            $temp = array(
                'name' => $c->getName(),  
                'value' => $val,
                'specialValue' => $valSpec  
             );   
            $jsonData[$idx++] = $temp; 
            $valAll += $val;
            $valSpecAll += $valSpec;
        }
        
        $temp = array(
            'name' => "<b>Razem</b>",  
            'value' => '<b>' . $valAll . '</b>',
            'specialValue' => '<b>' . $valSpecAll . '</b>'  
         );   
         $jsonData[$idx++] = $temp; 
        
         return new JsonResponse($jsonData);
    }


    #[Route('/ajaxMonth')]

    public function ajaxMonth(Request $request) {  

        if ($request->isXmlHttpRequest()) {  
            $dateEnd = DateTime::createFromFormat('Y-m-d G:i', $_POST['date']);
            $dateEnd->modify("-2 hour");
            $dateStart = new DateTime();
            $dateStart->setDate($dateEnd->format('Y'), $dateEnd->format('m'), 1)->setTime(23,59);
            $dateStart->modify('-1 day');
            return  $this->countValues( $dateEnd, $dateStart );
        }
        else {
            return new JsonResponse("Brak danych"); 
        }
     }         
     #[Route('/ajaxYear')]

    public function ajaxYear(Request $request) {  

        if ($request->isXmlHttpRequest()) {  
            $date = DateTime::createFromFormat('Y-m-d G:i', $_POST['date']);
            $date->modify("-2 hour");
            
            $dateStart = new DateTime(); 
            $dateStart->setDate($date->format('Y'), 1, 1)->setTime(0,0);
            $dateStart->modify('-1 day');
            $dateEnd = new DateTime(); 
            $dateEnd->setDate($date->format('Y'), 12, 31)->setTime(23,59);

        return $this->countValues( $dateEnd, $dateStart );
    }
        else {
            return new JsonResponse("Brak danych"); 
        }
     }         
}