<?php

namespace App\Controleurs;

use App\BaseControleur;
use Core\Requete;
use Core\Reponse;

/**
 * AppController Contrôleur
 */
class AppController extends BaseControleur
{
    /**
     * Exemple d'action
     */
    public function index(Requete $requete, Reponse $response): string
    {
        return vue('app.index');
    }
}
