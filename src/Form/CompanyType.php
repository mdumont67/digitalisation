<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class,[
                'label'=> 'Nom de l\'entreprise',
                'required'=>true
            ])
            ->add('address', TextType::class,[
                'label'=>'adresse'
            ])
            ->add('business', TextType::class,[
                'label'=> 'Domaine d\'activité'
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
            'data_class' => Company::class,
        ]);
    }
}
