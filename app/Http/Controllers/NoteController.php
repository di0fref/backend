<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NoteController extends Controller
{
    public function showAllNotes()
    {
        return response()->json(

            DB::table("notes")
                ->where("deleted", 0)
                ->get()
        );
    }


    public function getTrash()
    {
        return response()->json(

            DB::table("notes")
                ->where("deleted", 1)
                ->orderBy("name")
                ->get()
        );

    }


    public function bookmarks()
    {

        return response()->json(

            DB::table("notes")
                ->where("bookmark", 1)
                ->where("deleted", 0)
                ->orderBy("name")
                ->get()
        );

    }

    function folder($id)
    {
        return response()->json(
            DB::table("notes")
                ->where("folder_id", $id)
                ->where("deleted", 0)
                ->get(["*", "name as label", DB::raw("concat('note') as type")])
        );
    }

    public function showOneNote($id)
    {
        return response()->json(Note::find($id));
    }

    public function create(Request $request)
    {
        $Note = Note::create($request->all());

        return response()->json($Note, 201);
    }

    public function update($id, Request $request)
    {
        $Note = Note::findOrFail($id);
        $Note->update($request->all());

        return response()->json($Note, 200);
    }

    public function delete($id)
    {
        Note::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
