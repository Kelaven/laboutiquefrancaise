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


class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => "Votre prénom",
                        'attr' => [
                'placeholder' => "John",
            ]
        ])
        ->add('lastname', TextType::class, [
            'label' => "Votre nom",
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
        ->add('password', PasswordType::class, [
            'label' => "Votre mot de passe",
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
            'data_class' => User::class,
        ]);
    }
}
