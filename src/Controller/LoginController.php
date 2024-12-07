<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // Gérer les erreurs
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier username (email) : s'il se trompe de mdp, il n'aura pas à retaper son mail
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            // pour communiquer avec twig : 
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }
}
