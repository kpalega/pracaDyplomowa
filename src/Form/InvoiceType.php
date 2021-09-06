<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('invoicenumber', TextType::class, [
                'label' => "Numer faktury",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać Numer faktury',
                    ]),
                    new Length([
                        'max' => 16,
                        'maxMessage' => 'Numer faktury nie powinien przekraczać {{ limit }} znaków',
                    ]),
                ]
            ])
            ->add('date', DateType::class, [
                'label' => "Data wystawienia",
                'widget' => 'choice',
                'format' => 'yyyy-MM-dd',
                'placeholder' => [
                    'year' => 'Rok', 'month' => 'Miesiąc', 'day' => 'Dzień',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać datę',
                    ])
                ]
            ])
            ->add('name', TextType::class, [
                'label' => "Nazwa faktury",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać imię',
                    ])
                ]
            ])
            ->add('value', MoneyType::class, [
                'label' => "Wartość faktury",
                'currency' => "PLN",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać wartość faktury',
                    ])
                ]
            ])
            ->add('special', CheckboxType::class, [
                'label'    => 'Kwota specjalna?',
                'required' => false,
            ])
            ->add('categoryId', ChoiceType::class, [
                'choices' => [
                    "" => "",
                    "Wynagrodzenia i pochodne od wynagrodzeń osoby fizycznej prowadzącej przedszkole" => "1",
                    "Wynagrodzenia i pochodne od wynagrodzeń, pozostałe" => "2",
                    "Najem pomieszczeń" => "3",
                    "Wydatki eksploatacyjne związane z najmem pomieszczeń" => "4",
                    "Remonty" => "5",
                    "Obsługa prawna" => "6",
                    "Inne zadania organu prowadzącego" => "7",
                    "Książki i zbiory biblioteczne" => "8",
                    "Środki dydaktyczne" => "9",
                    "Sprzęt rekreacyjny i sportowy" => "10",
                    "Meble" => "11",
                    "Pozostałe środki trwałe" => "12"
                ],
                "label" => "Kategoria",
                "mapped" => false,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
