<?php

namespace App\Controller;

use App\Entity\Specialization;
use App\Entity\User;
use App\Form\RegistrationFormType;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $specName = $form->get("specName")->getData();
            $specTitle = $form->get("specTitle")->getData();
             
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            if( $specName != null && $user->getRoles() != "ROLE_USER"){
                
                $entityManager = $this->getDoctrine()->getManager();    
                $specialization = $entityManager->getRepository(Specialization::class)->findOneBy([
                    "name" => $specName,
                    "academictitle" => $specTitle
                ]);

                if($specialization == null){
                    
                    $specialization = new Specialization();
                    $specialization->setAcademictitle($specTitle);
                    $specialization->setName($specName);
                   
                    $entityManager->persist($specialization);
                    $entityManager->flush();                      
                }
                
                $user->setIdspecialization($specialization);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Użytkownik został dodany!'
            );
            
            unset($user);
            unset($form);
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
