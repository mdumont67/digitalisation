<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Question;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class,[
                'label'=> 'Libellé de la question',
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
            ->add('Category', EntityType::class, [
                'class'=> Category::class,
                'label'=> 'Catégories',
                'query_builder'=> function(EntityRepository $er){
                    $er->createQueryBuilder('q')
                    ->andWhere('q.active is true')
                    ->orderBy('q.label, ASC')
                    ;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
