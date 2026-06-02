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
}
