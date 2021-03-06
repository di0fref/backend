<?php

namespace App\Providers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {

            $token = $request->header('token');
            /* Decode token */
            $token_decoded = User::decodeJWT($token);

            if ($token) {
//                return User::where('id', "tCl7drll5xaGLyG9O0trQ1WaEJg1")->first();
                return User::where('id', $token_decoded->user)->first();

            }
            return null;
        });
    }
}
