<?php

namespace App\Controleurs;

use App\BaseControleur;
use App\Modeles\Plan;

/**
 * PlanControleur Contrôleur
 */
class PlanControleur extends BaseControleur
{
    /**
     * Afficher la liste
     */
    public function index()
    {
        $plan = Plan::ou('id', '>', 0)->tout();
        // dd($plan);

        return vue('plan.index', ['items' => $plan]);
    }

    /**
     * Afficher le formulaire de création
     */
    public function creer()
    {
        return vue('plan.creer');
    }

    /**
     * Enregistrer un nouvel élément
     */
    public function enregistrer()
    {
        $plan = Plan::creer([
            'nom' => $this->requete()->publier('nom'),
        ]);

        return redirection('/');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function editer()
    {
        $id = $this->requete()->param('id');
        $plan = Plan::trouver($id);

        if (!$plan) {
            return redirection('/404');
        }

        return vue('plan.editer', ['item' => $plan]);
    }

    /**
     * Mettre à jour un élément
     */
    public function mettreAJour()
    {
        $id = $this->requete()->param('id');
        $plan = Plan::trouver($id);

        if (!$plan) {
            return redirection('/404');
        }

        $plan->mettreAJour([
            'nom' => $this->requete()->publier('nom'),
        ]);

        return redirection('/');
    }

    /**
     * Supprimer un élément
     */
    public function supprimer()
    {
        $id = $this->requete()->param('id');
        $plan = Plan::trouver($id);

        if (!$plan) {
            return redirection('/404');
        }

        $plan->supprimer();
        return redirection('/');
    }
}
