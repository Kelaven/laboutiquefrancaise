<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\RegisterUserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = new User(); // on crée un nouvel utilisateur pour l'envoyer plus tard en BDD

        $form = $this->createForm(RegisterUserType::class, $user); // j'ajoute $user pour remplir le nouvel utilisateur crée juste avant, qui est alors encore vide

        $form->handleRequest($request); // écouter ce que l'utilisateur soumet dans le form

        if ($form->isSubmitted() && $form->isValid()) {
// dd($form->getData());
            $entityManager->persist($user); // figer les données. On lui indique qu'on veut enregistrer les données dans la table user. 
            $entityManager->flush(); // enregistrer les données

        }

        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}
