<?php

namespace App\Modeles;

use Core\Modele;
use Core\BaseBD;
use Core\Validateur;

/**
 * Users Modèle - Gestion des utilisateurs
 */
class users extends Modele
{
    protected string $table = 'users';
    protected string $clesPrimaire = 'id';
}
