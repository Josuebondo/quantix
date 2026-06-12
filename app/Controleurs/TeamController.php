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
    public function entrepots(Requete $requete, Reponse $response)
    {
        // Simuler des données d'entrepôts
        $entrepots = [
            ['id' => 1, 'name' => 'Entrepôt A', 'location' => 'Paris'],
            ['id' => 2, 'name' => 'Entrepôt B', 'location' => 'Lyon'],
            ['id' => 3, 'name' => 'Entrepôt C', 'location' => 'Marseille'],
        ];

        return vue('company.entrepots', [
            'entrepots' => $entrepots,
        ]);
    }
}
