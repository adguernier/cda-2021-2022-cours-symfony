<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // le $builder nous permet de construire le formulaire
        $builder
            ->add('title')
            ->add('description')
            ->add('price', MoneyType::class, [
                'divisor' => 100
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'annonce.status_0' => Annonce::STATUS_VERY_BAD,
                    'annonce.status_1' => Annonce::STATUS_BAD,
                    'annonce.status_2' => Annonce::STATUS_GOOD,
                    'annonce.status_3' => Annonce::STATUS_VERY_GOOD,
                    'annonce.status_4' => Annonce::STATUS_PERFECT
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
            'translation_domain' => 'annonce'
        ]);
    }
}
