<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class,[
                'label' => "Treść wiadomości",   
                'attr' => ['style' => 'height: 375px'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Mail jest pusty',
                    ])
                ]
            ])
            ->add('toUser', ChoiceType::class,[
                'label' => "Do: ",   
                'choice_label' => function (User $user) {
                    return $user->getFullname();
                },
                'choices' => $options['users'],
                'mapped' => false
            ])
            
            ->add('fromUser', TextType::class,[
                'label' => "Od: ",
                'disabled' => true,
                'data' => $options['currentUser']->getFullname()
            ])
            ->add('topic', TextType::class, [
            'label' => "Temat",
            'constraints' => [
                new NotBlank([
                    'message' => 'Proszę podać temat',
                ])
            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'users' => User::class,
            'currentUser' => User::class
        ]);
    }
}
