<?php

namespace App\Models;
/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */
use Illuminate\Database\Eloquent\Model;

class Team extends ModelUuid
{
    protected $fillable = [
        'name',
        'id',
    ];
}
