<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class NoteController extends Controller
{

    public function showAllNotes(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("notes")
                ->where("deleted", "0")
                ->where("user_id", Auth::id())
                ->get()

        );
    }


    public function getTrash(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("notes")
                ->where("deleted", "1")
                ->where("user_id", Auth::id())
                ->orderBy("name")
                ->get()
        );

    }


    public function bookmarks(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("notes")
                ->where("bookmark", "1")
                ->where("deleted", "0")
                ->where("user_id", Auth::id())
                ->orderBy("name")
                ->get()
        );

    }

//    function folder($id, \Illuminate\Http\Request $request)
//    {
//        return response()->json(
//            DB::table("notes")
//                ->where("folder_id", $id)
//                ->where("deleted", 0)
//                ->where("user_id", $request->header("uid"))
//                ->get(["*", "name as label", DB::raw("concat('note') as type")])
//        );
//    }

    public function showOneNote($id, \Illuminate\Http\Request $request)
    {
        return response()->json(
            DB::table("notes")
                ->where("deleted", "0")
                ->where("id", $id)
                ->where("user_id", Auth::id())
                ->get()
                ->first()

        );
    }

    public function create(Request $request)
    {
        $Note = Note::create(
            [
                "user_id" => Auth::id(),
                "name_" => "",
                "text" => null,
                "folder_id" => $request->folder_id,
                "team_id" => ""
            ],
        );


        return response()->json($Note, 201);
    }

    public function update($id, Request $request)
    {
        $Note = Note::findOrFail($id);
        $Note->update($request->all());

        return response()->json($Note, 200);
    }

    public function delete($id, \Illuminate\Http\Request $request)
    {
        Note::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
