<?php

namespace App\Form;

use App\Entity\Axis;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceAxisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('axis', EntityType::class, [
                'label' => 'Choisir l\'axe que vous souhaitez remplir', 
                'class'=> Axis::class, 
                'required'=>true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'axis1'=> null
            // Configure your form options here
        ]);
    }
}
