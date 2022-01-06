<?php

namespace App\Form;

use App\Entity\Activities;
use App\Entity\Child;
use App\Entity\Group;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $group = $options['group'];
        $builder        
        ->add('date', DateTimeType::class, [
            'label' => "Data",
            'data' => $options['date'],
            'widget' => 'single_text',
            'attr' => ['class' => 'disabled'],
        ])
        ->add('children', EntityType::class, [
            'class' => 'App\Entity\Child',   
            "label" => "Wybierz obecne dzieci:",  
            'choice_label' => function (Child $child) {
                return $child->getFullname();
            },
            'query_builder' => function(EntityRepository $repository) use ($group) {
                $qb = $repository->createQueryBuilder('c');
                return $qb
                    ->setParameter('class', $group)
                    ->where($qb->expr()->isMemberOf(':class','c.idclass'))
                    ->orderBy('c.surname', 'ASC')
                ;
            },
            'mapped' => false,
            'multiple' => true,
            'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activities::class,
            'date' => "string",
            'group' => Group::class
        ]);

    }

}
