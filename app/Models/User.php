<?php

namespace App\Models;

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
    public static function generateSecureToken($length, $lengthType) {

        // Work out byte length
        switch($lengthType) {

            case 'bits':
                $byteLength = ceil($length / 8);
                break;

            case 'bytes':
                $byteLength = $length;
                break;

            case 'chars':
                $byteLength = $length / 2; // In hex one char = 4 bits, i.e. 2 chars per byte
                break;

            default:
                return false;
                break;
        }

        // Try getting a cryptographically secure token
        $token = openssl_random_pseudo_bytes($byteLength);

        if ($token !== false) {

            return bin2hex($token);

        }
        else {

            // openssl_random_pseudo_bytes failed
            return false;

        }

    }
}

