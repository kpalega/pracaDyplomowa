<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;

use App\Entity\Child;
use App\Entity\Group;
use App\Repository\ChildRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => "Nazwa",
            'constraints' => [
                new NotBlank([
                    'message' => 'Proszę podać nazwę',
                ])
            ]
        ])
        ->add('active', ChoiceType::class, [
            'choices' => [
                "Tak" => true,
                "Nie" => false,
            ],
            "label" => "Czy grupa jest aktualna?"
        ])
        ->add('children', EntityType::class, [
            'class' => 'App\Entity\Child',     
            'choice_label' => function (Child $child) {
                return $child->getFullname();
            },
            'query_builder' => function(EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('c');
                return $qb
                    ->where($qb->expr()->neq('c.active', 'false'))
                    ->orderBy('c.surname', 'ASC')
                ;
            },
            'mapped' => false,
            'label' => 'Wybierz członków grupy',
            'multiple' => true,
            'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
