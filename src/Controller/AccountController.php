<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\PasswordUserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;


class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            
        ]);
    }

    #[Route('/compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response // emmène avec toi la méthode Request, et puis le password hasher et enfin l'entityManagerInterface
    {
        $user = $this->getUser(); // récupèrer l'utilisateur connecté
// dd($user);
        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordHasher' => $passwordHasher
        ]); // $user pour transmettre les infos au formulaire de modification de mdp /// en 3eme parametre on peut envoyer un tableau avec des infos que l'on peut transmettre à notre form, ce que l'on fait avec le pwd hasher

        $form->handleRequest($request); // écoute ce qu'il y a dans la méthode Request

        if ($form->isSubmitted() && $form->isValid()) {
// dd($form->getData());
        $entityManager->flush(); // on ne fait pas de persist() car il ne s'agit pas d'une création. 

        $this->addFlash(
            'success',
            'Les modifications sont bien enregistrées.'
        );

        }

        return $this->render('account/password.html.twig', [
            'modifyPwd' => $form->createView()
        ]);
    }
}
