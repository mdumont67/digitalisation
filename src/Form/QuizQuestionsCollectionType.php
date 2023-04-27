<?php

namespace App\Form;

use App\Entity\QuizQuestions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizQuestionsCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            if (null != $event->getData()) {
                $builder = $event->getForm();
                $data = $event->getData();
                $label = $data->getQuestion()->getLabel();
                $builder
                    ->add('rating', RangeType::class, [
                        'label' => $label,
                        'attr' => [
                            'min' => 1,
                            'max' => 5,
                        ], 
                    ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizQuestions::class,
        ]);
    }
}
