<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\ToDoTask;
use Illuminate\Http\Response;

class ToDoTaskController extends Controller
{
    /**
     * Return all tasks from the current request as JSON
     * (Future - could be filtered)
     */
    public function index( $showCompleted=0 ) : JsonResponse
    {
        $tasks = ToDoTask::orderBy('created_at', 'desc');

        if( $showCompleted == 0 )
            $tasks->whereCompleted(0);

        return response()->json($tasks->get());
    }


    /**
     * Create/store a new ToDoTask record in database
     */
    public function create( Request $request) : JsonResponse
    {
        $this->validate($request, [
            'task' => 'required', 'string', 'max:250', 'unique:todo_tasks,task'
        ]);

        $task = new ToDoTask();
        $task->task = $request->task;
        $task->save();

        return response()->json($task);
    }

    // actually the only thing you can update is marking a task complete
    public function update( Request $request, ToDoTask $task ) : JsonResponse
    {

        // only update the task status if the change would be valid, otherwise ignore it
        if( ( (boolean)$request->completed != $task->completed )  ) {

            $task->completed = (boolean) $request->completed;

            // only save to db if a change was made
            $task->save();

        }

        return response()->json($task);
    }

    public function delete( ToDoTask $task ) : Response
    {
        $task->delete();
        return response(null, 202);
    }
}
