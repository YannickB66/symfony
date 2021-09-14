<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Speciality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identificationCode')
            ->add('name')
            ->add('firstName')
            ->add('birthdate')
            ->add('nationality')
            ->add('speciality')
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
