<?php

namespace App\Form;

use App\Entity\Axis;
use App\Entity\Company;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', EntityType::class, [
                'label'=> 'Entreprise',
                'class' => Company::class,
                'required'=> true
            ])
            ->add('quizQuestions', CollectionType::class,[
                'label'=> false,
                'entry_type'=> QuizQuestionsCollectionType::class,
                    'data'=> $options['questions'], 
                
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
            'questions' => null
        ]);
    }
}
