<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => "Votre prénom",
            'constraints' => [
                new Length([
                    'min' => 2,
                    'max' => 30
                    ])
            ],
            'attr' => [
                'placeholder' => "John",
            ]
        ])
        ->add('lastname', TextType::class, [
            'label' => "Votre nom",
            'constraints' => [
                new Length([
                    'min' => 2,
                    'max' => 30
                    ])
            ],
            'attr' => [
                'placeholder' => "Doe"
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => "Votre adresse email",
            'attr' => [
                'placeholder' => "john@doe.fr"
            ]
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'constraints' => [
                new Length([
                    'min' => 4,
                    'max' => 30
                    ])
            ],
            'first_options'  => [
                'label' => 'Votre mot de passe', 
                'hash_property_path' => 'password', // hacher
                'attr' => [
                    'placeholder' => "123456"
                ],
            ],
            'second_options' => [
                'label' => 'Confirmer Votre mot de passe',
                'attr' => [
                    'placeholder' => "123456"
                ]
            ],
            'mapped' => false, // ne pas faire le lien avec l'entity User car dedans le champ s'appelle password et non pas plainPassword
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Valider",
            'attr' => [
                'class' => "btn btn-success"
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [ // Ajouter la contrainte de mail unique dans le form si on ne souhaite pas le faire dans l'entity
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => 'email'
                ])
                ],
            'data_class' => User::class,
        ]);
    }
}
