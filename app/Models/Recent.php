<?php

namespace App\Models;

/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */

use Illuminate\Database\Eloquent\Model;

class Recent extends ModelUuid
{
    protected $fillable = [
        'id',
        'note_id',
        'user_id'
    ];
}
