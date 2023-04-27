<?php

namespace App\Form;

use App\Entity\Axis;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Nom de la catégorie',
                'required'=> true,
            ])
            ->add('active', ChoiceType::class,[
                'label' => 'Active',
                'choices'=> [
                    'Oui' => true,
                    'Non'=> false
                ],
                'required'=> true
            ])
            ->add('axis', EntityType::class,[
                'class'=> Axis::class,
                'label' => 'Axe principal', 
                'required' => true,
                'query_builder' => function(EntityRepository $er){
                    $er->createQueryBuilder('a')
                    ->andWhere('a.active is true')
                    ;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
