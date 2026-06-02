<?php

namespace App\Controleurs;

use App\BaseControleur;
use Core\Requete;
use Core\Reponse;
use Bmvc\BAuth\Support\Password;
use Bmvc\BAuth\Auth;
use Bmvc\BAuth\Config;



/**
 * testControleur Contrôleur
 */
class testControleur extends BaseControleur
{
    /**
     * Exemple d'action
     */
    public function index(Requete $requete, Reponse $response)
    {
        // Créer la configuration
        $config = new Config([
            'jwt' => ['secret' => 'a279034786db47d795eb309e910e9ae6b465e716076b49acc9b485c944fa39e0', 'expiresIn' => 3600],
            'password' => ['algorithm' => PASSWORD_BCRYPT, 'options' => ['cost' => 12]],
        ]);
        // dd($config->get('jwt.secret')); // Affiche la clé secrète JWT
        $password = new Password($config);
        $hashed = $password->hash('mypassword123');
        // dd($hashed);
        if ($password->verify('mypassword123', $hashed)) {
            echo "Mot de passe correct !";
        } else {
            echo "Mot de passe incorrect.";
        }
    }
}
