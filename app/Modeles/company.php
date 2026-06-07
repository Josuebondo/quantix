<?php

namespace App\Modeles;

use Core\Modele;

/**
 * Company Modèle - Gestion des entreprises
 */
class company extends Modele
{
    protected string $table = 'companies';
    protected string $clesPrimaire = 'id';

    /**
     * Relation: une entreprise a plusieurs utilisateurs
     */
    public function users()
    {
        return $this->aPlusieurs(users::class, 'company_id', 'id');
    }

    /**
     * Relation: une entreprise a plusieurs rôles
     */
    public function roles()
    {
        return $this->aPlusieurs('App\Modeles\role', 'company_id', 'id');
    }
    public function hasCompleteSetup(): bool
    {
        // Vérifier les informations de base de l'entreprise
        if (empty($this->name) || empty($this->email) || empty($this->phone)) {
            return false;
        }

        //Verfier les setup step est complet
        if (isset($this->setup_step) && $this->setup_step < 3) {
            return false;
        }

        return true;
    }
}
