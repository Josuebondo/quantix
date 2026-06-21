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
    public function getRoles(company $compay): array
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
    public function getWarehouses(company $compay): array
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
    public function getInvitation(company $compay): array
    {
        $invitations = $compay->invitations();
        $data = [];
        // dd($invitations);
        foreach ($invitations as $invitation) {
            $data[] = [
                'id' => $invitation->id,
                'name' => $invitation->name,
                'status' => $invitation->status,
                'email' => $invitation->email,
                'expires_at' => $invitation->expires_at,
                'accepted_at' => $invitation->accepted_at,
                'created_at' => $invitation->created_at,
                'updated_at' => $invitation->updated_at,


            ];
        }
        return $data;
    }
    public function getTeam(company $compay): array
    {
        $data = $compay->usersWithDetails();
        $users = [];
        // dd($data);
        foreach ($data as $user) {
            $users[] = [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'warehouse_id' => $user->warehouse_id,
                'warehouse_name' => $user->warehouse_name,
                'role' => $user->role_name,
                'status' => $user->status,
                'last_login_at' => $user->last_login_at,
                'created_at' => $user->created_at,


            ];
        }
        return $users;
    }
}
