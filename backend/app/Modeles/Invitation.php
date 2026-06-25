<?php

namespace App\Modeles;

use Core\Modele;

/**
 * Invitation Modèle
 */
class Invitation extends Modele
{
    protected string $table = 'invitations';


    /**
     * Relation: une invitaion appartient à une entreprise
     */
    public function company()
    {
        return $this->appartientA('App\Modeles\company', 'company_id', 'id');
    }
}
