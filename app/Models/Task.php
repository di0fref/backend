<?php

namespace App\Models;
/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'text',
        'completed',
        'deleted',
        'user_id',
        'task_list_id'
    ];

    protected $casts = [
        "completed" => "boolean",
        "deleted" => "boolean"
    ];
}
