<?php

namespace App\Services;

use App\Modeles\users;

class TeamService
{
    public function getCompanyTeam(int $compay_id): array
    {
        $user = users::ou('company_id', '=', $compay_id)->et('deted_at', '=', null)->obtenir();
        $data = [];
    }
}
