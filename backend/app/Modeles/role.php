<?php

namespace App\Modeles;

use Core\Modele;

/**
 * Role Modèle - Gestion des rôles
 */
class role extends Modele
{
    protected string $table = 'roles';
    protected string $clesPrimaire = 'id';

    /**
     * Relation: un rôle appartient à une entreprise
     */
    public function company()
    {
        return $this->appartientA('App\Modeles\company', 'company_id', 'id');
    }

    /**
     * Relation: un rôle a plusieurs permissions
     */
    public function permissions()
    {
        return $this->plusieursAPlusieurs(
            'App\Modeles\permission',
            'role_permissions',
            'role_id',
            'permission_id'
        );
    }
}
