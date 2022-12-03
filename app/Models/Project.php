<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends ModelUuid
{
    protected $fillable = [
        'name',
        'text',
        'deleted',
        'user_id',
        "order",
        "color"
    ];

}
