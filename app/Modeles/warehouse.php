<?php

namespace App\Modeles;

use Core\Modele;

/**
 * warehouse Modèle
 */
class warehouse extends Modele
{
    protected string $table = 'warehouses';
    /**
     * Relation: un entrepot appartient à une entreprise
     */
    public function company()
    {
        return $this->appartientA('App\Modeles\company', 'company_id', 'id');
    }
}
