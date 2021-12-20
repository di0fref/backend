<?php

namespace App\Models;
/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'sort_order',
    ];
}
