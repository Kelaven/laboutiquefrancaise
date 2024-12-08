<?php

// Grandes lignes du test :
// 1. Créer un faux client qui se comporte comme un navigateur
// 2. Remplir les champs de mon formulaire d'inscription
// 3. Regarder si dans ma page le flash message success s'affiche


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        // 1. création du client qui va sur la page d'inscription : 
        $client = static::createClient(); 
        $crawler = $client->request('GET', '/inscription');

        // 2. on dit au client sur quel bouton il doit cliquer, on lui donne les name des inputs à remplir ainsi que leurs valeurs
        $client->submitForm('Valider', [
            'register_user[firstname]' => 'Kitty',
            'register_user[lastname]' => 'Cat',
            'register_user[email]' =>  'kitty.cat@gmail.com',
            'register_user[plainPassword][first]' => '123456',
            'register_user[plainPassword][second]' => '123456'
        ]);
        // on lui dit de suivre la redirection :
        $this->assertResponseRedirects('/connexion'); // vérifier si la redirection fonctionne
        $client->followRedirect();

        // 3.
        $this->assertSelectorExists('div:contains("Votre compte est correctement créé, veuillez vous connecter.")');

    }
}



