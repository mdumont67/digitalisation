<?php

namespace App\Form;

use App\Entity\Axis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AxisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class,[
                'label' => 'Libéllé',
                'required'=> true
            ])
            ->add('active', ChoiceType::class,[
                'label' => 'Active',
                'choices'=> [
                    'Oui' => true,
                    'Non'=> false
                ],
                'required'=> true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Axis::class,
        ]);
    }
}
