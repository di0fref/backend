<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function login(Request $request)
    {
        $user = DB::table("users")
            ->where("username", $request->username)
//            ->where("password", Hash::make($request->password))
            ->where("password", $request->password)
            ->get(["id"])
            ->first();

        if ($user) {
            $u = User::find($user->id);
            $u->api_token = "kalle";//Str::random(40);
            $u->save();
            return response()->json($u);
        } else {
            return response()->json("Invalid user", 401);
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
