<?php

namespace App\Controleurs;

use App\BaseControleur;
use App\Modeles\users;
use App\Services\InvitationService;
use App\Services\TeamService;
use Core\Reponse;
use Core\Requete;

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
            [
                'id' => 1,
                'name' => 'John Owner',
                'email' => 'owner@acme.cd',
                'role' => 'Owner',
                'warehouse' => 'Tous les entrepôts',
                'status' => 'Actif',
                'last_login' => "Aujourd'hui, 09:42",
                'created_at' => '10/06/2026'
            ],

            [
                'id' => 2,
                'name' => 'Marie Admin',
                'email' => 'marie@acme.cd',
                'role' => 'Admin',
                'warehouse' => 'Entrepôt Central',
                'status' => 'Actif',
                'last_login' => "Aujourd'hui, 08:15",
                'created_at' => '11/06/2026'
            ],

            [
                'id' => 3,
                'name' => 'Patrick Stock',
                'email' => 'patrick@acme.cd',
                'role' => 'Employé',
                'warehouse' => 'Entrepôt Central',
                'status' => 'Actif',
                'last_login' => 'Hier, 17:28',
                'created_at' => '12/06/2026'
            ],

            [
                'id' => 4,
                'name' => 'Sarah Vente',
                'email' => 'sarah@acme.cd',
                'role' => 'Employé',
                'warehouse' => 'Magasin Gombe',
                'status' => 'Inactif',
                'last_login' => '08/06/2026 14:30',
                'created_at' => '05/06/2026'
            ],

            [
                'id' => 5,
                'name' => 'David Manager',
                'email' => 'david@acme.cd',
                'role' => 'Manager',
                'warehouse' => 'Entrepôt Est',
                'status' => 'Actif',
                'last_login' => 'Aujourd\'hui, 10:05',
                'created_at' => '09/06/2026',
                'statut' => 'inactif'
            ],

            [
                'id' => 6,
                'name' => 'Grace Support',
                'email' => 'grace@acme.cd',
                'role' => 'Employé',
                'warehouse' => 'Entrepôt Ouest',
                'status' => 'Suspendu',
                'last_login' => '01/06/2026 11:20',
                'created_at' => '28/05/2026',
                'statut' => 'inactif'
            ]
        ];
        $stats = [
            'activeUsers' => 142,
            'activeTrend' => '+18 ce mois-ci',

            'pendingInvites' => 11,
            'pendingTrend' => '+4 cette semaine',

            'roles' => 8,

            'totalUsers' => 167,
            'totalTrend' => '+24 ce mois-ci'
        ];
        return json([
            'users' => $users,
            'stats' => $stats
        ]);
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
    public function mouvements(Requete $requete, Reponse $response)
    {
        // Simuler des données de documents
        $documents = [
            ['id' => 1, 'name' => 'Document A', 'type' => 'PDF'],
            ['id' => 2, 'name' => 'Document B', 'type' => 'Word'],
            ['id' => 3, 'name' => 'Document C', 'type' => 'Excel'],
        ];

        return vue('company.mouvement', [
            'documents' => $documents,
        ]);
    }
    public function data(Requete $req, Reponse $res)
    {

        $company = users::company();
        $ts = new TeamService();
        $roles = $ts->getRoles($company);
        $entrepots = $ts->getWarehouses($company);
        $teams = $ts->getTeam($company);
        $invitations = $ts->getInvitation($company);
        // dd($teams['0']['first_name']);
        $stats = [
            'activeUsers' => 142,
            'activeTrend' => '+18 ce mois-ci',

            'pendingInvites' => 11,
            'pendingTrend' => '+4 cette semaine',

            'roles' => 8,

            'totalUsers' => 167,
            'totalTrend' => '+24 ce mois-ci'
        ];
        $data = [
            'roles' => $roles,
            'entrepots' => $entrepots,
            'teams' => $teams,
            'stats' => $stats,
            'invitations' => $invitations

        ];
        return $res->json($data);
    }
    public function invite(Requete $req, Reponse $res)
    {
        $data = $req->json();
        $v = validateur();
        $v->ajouter('email', ['email', 'requis']);
        $v->ajouter('nom', ['requis']);
        $v->ajouter('Entrepôt', ['requis']);
        $v->ajouter('role', ['requis']);
        if (!$v->valider($data)) {
            return $res->json([
                "success" => false,
                'errors' => $v->erreurs(),
                'message' => 'Erreur de validation'
            ]);
        }
        $state = [
            'role_id' => $data['role'],
            'warehouse' => $data['Entrepôt'],
            'email' => $data['email'],
            'name' => $data['nom']
        ];
        $company = users::company();
        $InvS = new InvitationService();
        $result = $InvS->createInvitation($state, $company);

        return $res->json($result);
    }
}
