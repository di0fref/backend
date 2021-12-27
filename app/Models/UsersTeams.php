<?php

namespace App\Models;
/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */
use Illuminate\Database\Eloquent\Model;

class UsersTeams extends ModelUuid
{
    protected $fillable = [
        'user_id',
        'team_id',
        'id',
    ];
}
