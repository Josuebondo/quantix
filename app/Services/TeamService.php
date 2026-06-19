<?php

namespace App\Services;

use App\Modeles\company;
use App\Modeles\role;
use App\Modeles\users;

class TeamService
{
    public function getCompanyTeam(int $compay_id): array
    {

        $user = users::ou('company_id', '=', $compay_id)->et('deted_at', '=', null)->obtenir();
        $data = [];
        return $data;
    }
    public function getRoles(company $compay)
    {
        $roles = $compay->roles();
        $data = [];
        foreach ($roles as $role) {
            $data[] = [
                'id' => $role->id,
                'name' => $role->name,
                'code' => $role->code
            ];
        }
        return $data;
    }
    public function getWarehouses(company $compay)
    {
        $warehouses = $compay->warehouses();
        $data = [];
        // dd($warehouses);
        foreach ($warehouses as $warehouse) {
            $data[] = [
                'id' => $warehouse->id,
                'name' => $warehouse->name,
                'code' => $warehouse->code,
                'adreesse' => $warehouse->address,
                'type' => $warehouse->type,


            ];
        }
        return $data;
    }
}
