<?php

namespace App\Controleurs;

use App\BaseControleur;
use Core\Requete;
use Core\Reponse;

/**
 * TeamController Contrôleur
 */
class TeamController extends BaseControleur
{
    /**
     * Exemple d'action
     */
    public function index(Requete $requete, Reponse $response): string
    {
        return vue('company.team', [
            'teams' => [
                ['id' => 1, 'name' => 'Équipe Alpha'],
                ['id' => 2, 'name' => 'Équipe Beta'],
                ['id' => 3, 'name' => 'Équipe Gamma'],
            ],
        ]);
    }
    public function all(Requete $requete, Reponse $response)
    {
        // Simuler des données d'utilisateurs
        $users = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Charlie'],
        ];

        return json($users);
    }
}
