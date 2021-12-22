<?php

namespace App\Http\Controllers;

use App\Models\Recent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RecentController extends Controller
{
    public function showAllRecents()
    {
        return response()->json(
            DB::table("recents")
                ->join("notes", "notes.id" ,"=", "recents.note_id")->get()
        );
    }

    public function showOneRecent($id)
    {
        return response()->json(Recent::find($id));
    }

    public function create(Request $request)
    {
        response()->json(
            DB::table("recents")->upsert(
                [
                    "note_id" => $request->id,
                    "updated_at" => Carbon::now(),
                    "user_id" => $request->header("Credentials")
                ],
                ["note_id", "user_id"], ["updated_at" => Carbon::now()]
            ));


    }

    public function update($id, Request $request)
    {
        $Recent = Recent::findOrFail($id);
        $Recent->update($request->all());
        return response()->json($Recent, 200);
    }

    public function delete($id)
    {
        Recent::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
