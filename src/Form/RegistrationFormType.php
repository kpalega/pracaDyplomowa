<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
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
            ->add('email',  EmailType::class, [
                'label' => "Adres email",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać email',
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać hasło',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Hasło powinno zawierać przynajmniej {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('active', ChoiceType::class, [
                'choices' => [
                    "Aktualny" => true,
                    "Zaarchiwizowany" => false,
                ],
                "label" => "Aktualny użytkownik?"
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    "Dyrektor" => 'ROLE_ADMIN',
                    "Nauczyciel" => 'ROLE_TEACHER',
                    "Rodzic" => "ROLE_USER",
                ],
                "label" => "Kim jest użytkownik?"
            ])
        ;

        $builder
        ->get('roles')
        ->addModelTransformer(new CallbackTransformer(
        function ($rolesArray) {
             // transform the array to a string
             return count($rolesArray)? $rolesArray[0]: null;
        },
        function ($rolesString) {
             // transform the string back to an array
             return [$rolesString];
        }
));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
