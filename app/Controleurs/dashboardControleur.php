<?php

namespace App\Controleurs;

use App\BaseControleur;
use App\Modeles\company;
use Core\Requete;
use Core\Reponse;

use App\Modeles\test;
use App\Services\CompanyService;

/**
 * dashboardControker Contrôleur
 */
class dashboardControleur extends BaseControleur
{
    /**
     * Exemple d'action
     */
    public function index(Requete $requete, Reponse $response)
    {
        //verfier la configuration de la compagnie est complète avant d'afficher le dashboard

        $company_id = auth()->user()['company_id'];
        if (!CompanyService::isCompleted($company_id)) {
            return redirection('/company/configuration');
        }
        return vue('dashboard.gerant');
    }
    public function test(Requete $requete, Reponse $response)
    {
        $db = test::ou('produit_id', '=', "3")->enTableau();
        // $data = test::->enTableau();
        dd($db);
    }
}
