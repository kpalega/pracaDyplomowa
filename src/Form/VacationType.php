<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Vacation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class VacationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vacationdays', null , [
                'label' => "Dni urlopu",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać lata',
                    ])
                ],
                'data' =>  $options['vacation']
            ])
            ->add('workedyears', null , [
                'label' => "Przepracowane lata",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać lata',
                    ])
                ],
                'data' =>  $options['years']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vacation::class,
            'years' => "int",
            'vacation' => "int"
        ]);
    }
}
