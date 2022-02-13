<?php

namespace App\Models;
/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $fillable = [
        'name',
        'text',
        'deleted',
        'user_id',
    ];

    protected $casts = [
        "deleted" => "boolean"
    ];
}
