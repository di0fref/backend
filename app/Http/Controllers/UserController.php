<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Google\Auth\AccessToken;


class UserController extends Controller
{
    public function login(Request $request)
    {
        $idToken = $request->input("idToken");
        putenv('GOOGLE_APPLICATION_CREDENTIALS=/Users/fredrik/Documents/noteer.json');

        $auth = new AccessToken();
        try {
            /* Validate idToken */
            $data = $auth->verify($idToken);
        } catch (\Exception $e) {
            return response()->json("Invalid user", 401);
        }

        $user_data = $request->input("user");
        $user = User::find($user_data["uid"]);

        if ($user) {
            $user->api_token = Str::random(40);
            $user->save();
            return response()->json($user);

        } else {
            /* Create new user */
            $user = User::create(
                [
                    "id" => $user_data["uid"],
                    "email" => $user_data["email"],
                    "password" => "",
                    "username" => $user_data["email"],
                    "first_name" => $user_data["displayName"],
                    "last_name" => $user_data["displayName"],
                    "avatar" => $user_data["photoURL"],
                    "settings" => "",
                    "api_token" => Str::random(40)
                ]
            );

            return response()->json($user);
        }
    }

//bin2hex(random_bytes(40)
    public function create(Request $request)
    {
        $User = User::create($request->all());

        return response()->json($User, 201);
    }

    public function update($id, Request $request)
    {
        $User = User::findOrFail($id);
        $User->update($request->all());

        return response()->json($User, 200);
    }

    public function delete($id, \Illuminate\Http\Request $request)
    {
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
