<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressAutocompleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('autocomplete', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'addressAutocomplete'],
                'mapped' => false // ne fait pas de $address->setAutocomplete()
            ])
            ->add('lon', HiddenType::class)
            ->add('lat', HiddenType::class)
            ->add('street', HiddenType::class)
            ->add('streetNumber', HiddenType::class)
            ->add('zipCode', HiddenType::class)
            ->add('city', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            // le formulaire est mappé à l'entité Address
            'data_class' => Address::class
        ]);
    }
}
