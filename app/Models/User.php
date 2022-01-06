<?php

namespace App\Models;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'avatar',
        'settings',
        'api_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'username'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static function encodeJWT($user)
    {
        $key = env("KEY");
        $signature = env("SIGNATURE");
        $payload = array(
            "iss" => "https://noteer.com",
            "aud" => "https://noteer.com",
            "user" => $user->id
        );

        $jwt = JWT::encode($payload, $key);
        JWT::sign($jwt, $signature);
        return $jwt;
    }

    public static function decodeJWT($jwt)
    {
        $key = env("KEY");
        return JWT::decode($jwt, $key, ['HS256']);
    }
}

