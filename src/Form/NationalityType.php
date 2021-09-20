<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NationalityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [
                'Français' => 'Français',
                'Allemand' => 'Allemand',
                'Americain' => 'Americain',
                'Russe' => 'Russe',
            ],
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}