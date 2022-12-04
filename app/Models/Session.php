<?php

namespace App\Models;
/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */

use Illuminate\Database\Eloquent\Model;

class Session extends ModelUuid
{
    protected $fillable = [
        'user_id',
        'ip',
        'status'
    ];
}
