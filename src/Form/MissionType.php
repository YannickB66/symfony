<?php

namespace App\Form;

use App\Entity\Mission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('codename')
            ->add('statut')
            ->add('type')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('country')
            ->add('agent',ChoiceType::class)
            ->add('requireSpeciality',ChoiceType::class)
            ->add('hideout',ChoiceType::class)
            ->add('contact',ChoiceType::class)
            ->add('target',ChoiceType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
