<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    function getAll(\Illuminate\Http\Request $request)
    {

//        $tasksLists = TaskList::all();

//        foreach ($tasksLists as $tasksList) {
        $todos = Task::where("user_id", Auth::id())
//                ->where("task_list_id", $tasksList->id)
            ->orderBy("order", "asc")
            ->get();
//        }

        return response()->json(
            $todos
        );

    }

    function create(\Illuminate\Http\Request $request)
    {

        $task = Task::create(
            [
                "user_id" => Auth::id(),
                "name" => $request->name,
                "text" => $request->text,
                "due" => $request->due ? $request->due : null,
                "prio" => $request->prio,
                "type" => $request->type
            ],
        );
        return response()->json($task, 201);

    }

    function update($id, \Illuminate\Http\Request $request)
    {
        $d = $request->all();
        if(isset($d["due"])){
            $d["due"] = empty($d["due"])?null:$d["due"];
        }
        $task = Task::findOrFail($id);
        $task->update($d);

        return response()->json($task, 200);
    }

    function delete($id)
    {
        Task::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
