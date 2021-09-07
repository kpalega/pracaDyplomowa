<?php

namespace App\Form;

use App\Entity\Child;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Imię",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać imię',
                    ])
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => "Nazwisko",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać nazwisko',
                    ])
                ]
            ])
            ->add('active', ChoiceType::class, [
                'choices' => [
                    "Tak" => true,
                    "Nie" => false,
                ],
                "label" => "Aktualnie uczęszcza do placówki?"
            ])
            
            ->add('disability', CheckboxType::class, [
                'label'    => 'Czy dziecko jest niepełnosprawne?',
                'required' => false,
                "mapped" => false,
            ])
            ->add('disabilityName', TextType::class, [
                'label' => "Nazwa niepełnosprawności",
                'required' => false,
                "mapped" => false,
            ])
            ->add('disabilityDecision', TextType::class,[
                'label' => "Numer oświadczenia",
                'required' => false,
                "mapped" => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}
