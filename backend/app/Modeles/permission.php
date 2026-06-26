<?php

namespace App\Modeles;

use Core\Modele;

/**
 * Permission Modèle - Gestion des permissions
 */
class permission extends Modele
{
    protected string $table = 'permissions';
    protected string $clesPrimaire = 'id';

    /**
     * Relation: une permission a plusieurs rôles
     */
    public function roles()
    {
        return $this->plusieursAPlusieurs(
            'App\Modeles\role',
            'role_permissions',
            'permission_id',
            'role_id'
        );
    }
}
