<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Google\Auth\AccessToken;
use Ramsey\Uuid\Uuid;


class UserController extends Controller
{

    public function login(Request $request)
    {
        $idToken = $request->input("idToken");
        $auth = new AccessToken();
        try {
            /* Validate idToken */
            $data = $auth->verify($idToken);

        } catch (\Exception $e) {
            return response()->json("Invalid user", 401);
        }
        $user_data = $request->input("user");
        $user = User::find($user_data["uid"]);

//        $session = Session::where("user_id", $user->id)
//            ->where("ip", User::getIp())
//            ->where("status", "confirmed")
//            ->get();
//
//        if(empty($session)){
//            return response()->json([
//                "status" => "fail",
//                "reason" => "missing_session",
//                "session" => $session
//            ]);
//        }

        /* Add session */
        $session = Session::upsert(
            [
                "id" => Str::uuid()->toString(),
                "user_id" => $user_data["uid"],
                "ip" => User::getIp(),
                "status" => "pending"
            ],
            ["user_id", "ip"],
            ["ip"]
        );

        if ($user) {
            $user->api_token = User::encodeJWT($user);
            $user->save();
            return response()->json($user);
        } else {
            /* Create new user */
            $user = User::create([
                "id" => $user_data["uid"],
                "email" => $user_data["email"],
                "username" => $user_data["email"],
                "name" => $user_data["displayName"] ?? "",
                "avatar" => $user_data["photoURL"] ?? "",
            ]);
            $user->api_token = User::encodeJWT($user);
            $user->save();

            return response()->json($user);
        }
    }

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
