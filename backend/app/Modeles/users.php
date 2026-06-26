<?php

namespace App\Modeles;

use Core\Modele;
use Core\BaseBD;


/**
 * Users Modèle - Gestion des utilisateurs
 */
class users extends Modele
{
    protected string $table = 'users';
    protected string $clesPrimaire = 'id';

    public static function getUserRolesWithPermissions(int $userId): array
    {
        $bd = BaseBD::obtenir();

        $sql = "
        SELECT
            r.id AS role_id,
            r.name AS role_name,
            r.description AS role_description,
            p.id AS permission_id,
            p.name AS permission_name,
            p.module AS permission_module,
            p.code AS permission_code
        FROM user_roles ur
        LEFT JOIN roles r ON ur.role_id = r.id
        LEFT JOIN role_permissions rp ON rp.role_id = r.id
        LEFT JOIN permissions p ON p.id = rp.permission_id
        WHERE ur.user_id = :userid
        ";

        $rows = $bd->tous($sql, [
            ':userid' => $userId
        ]);

        $roles = [];
        $permissions = [];
        $module = [];

        foreach ($rows as $row) {

            if (
                !empty($row['role_name']) &&
                !in_array($row['role_name'], $roles, true)
            ) {
                $roles[] = $row['role_name'];
            }

            if (
                !empty($row['permission_code']) &&
                !in_array($row['permission_code'], $permissions, true)
            ) {
                $permissions[] = $row['permission_code'];
            }
            if (
                !empty($row['permission_module']) &&
                !in_array($row['permission_module'], $module, true)
            ) {
                $module[] = $row['permission_module'];
            }
        }

        return [
            'roles' => $roles,
            'permissions' => $permissions,
            'modules' => $module
        ];
    }
    public static function company(): company
    {
        $comp = company::trouver(auth()->user()['company_id']);
        return $comp;
    }
}
