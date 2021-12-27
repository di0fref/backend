<?php

namespace App\Models;
/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */
use Illuminate\Database\Eloquent\Model;

class Note extends ModelUuid
{
    protected $fillable = [
        'name',
        'folder_id',
        'text',
        'bookmark',
        'locked',
        'deleted',
        'user_id',
        'team_id'
    ];
}
