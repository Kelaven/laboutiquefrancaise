<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', passwordType::class, [
                'label' => 'Votre mot de passe actuel',
                'attr' => [
                    'placeholder' => "123456"
                ],
                'mapped' => false
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
                    'label' => 'Votre nouveau mot de passe', 
                    'hash_property_path' => 'password', // Hacher. password ici correspond à la colonne password dans l'entity 
                    'attr' => [
                        'placeholder' => "123456"
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "123456"
                    ]
                ],
                'mapped' => false, // ne pas faire le lien avec l'entity User car dedans le champ s'appelle password et non pas plainPassword
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour mon mot de passe",
                'attr' => [
                    'class' => "btn btn-success"
                ]
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event){
// die('EVENT');
                $form = $event->getForm(); // récupération du form
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher']; // donc je récupère ici mon passwordhasher, grâce à AccountController et à la fonction de ce fichier configureOptions


                    // 1. récupérer le mdp saisi par l'utilisateur et le comparer au mdp en BDD (dans l'entity)
                    $isValid = $passwordHasher->isPasswordValid(
                        $user, // Symfony trouve automatiquement le mot de passe à comparer dans $user, car l’objet $user est une instance de l’entité User qui contient toutes les propriétés de l’utilisateur chargé, y compris le mot de passe haché.
                        $form->get('actualPassword')->getData() // actualPassword correspond à la ligne 21
                    );
// dd($isValid);

                    // 2. si c'est différent alors renvoyer une erreur
                    if (!$isValid) {
                        $form->get('actualPassword')->addError(new FormError("Votre mot de passe actuel n'est pas conforme, veuillez vérifier votre saisie.")); // addError() permet d'ajouter des erreurs à des inputs
                    }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null // par défaut, le password hasher est null.
        ]);
    }
}
