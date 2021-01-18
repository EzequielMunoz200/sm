<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 50,
                    ]),
                    new Type([
                        'type' => 'alpha'
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 50,
                    ]),
                    new Type([
                        'type' => 'alpha'
                    ])
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse postale',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 50,
                    ]),
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [
                    new Length([
                        'min' => 1,
                        //Y, prononcée [i], est une commune française située dans le département de la Somme, en région Hauts-de-France.
                        'max' => 50,
                        //Beaujeu-Saint-Vallier-Pierrejux-et-Quitteur (Haute-Saône) (38 lettres).
                    ]),
                    new Type([
                        'type' => 'alpha'
                    ])
                ]
            ])
            ->add('zip', NumberType::class, [
                'label' => 'Code postal',
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 5,
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Task::class,
        ]);
    }
}
