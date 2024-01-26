<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Task::with('demand')->with('users')->with('user')->get();
        $tasks = auth()->user()->tasks;

        return TaskResource::collection($tasks->load('demand'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request;
        $user = auth()->user()->id;
        
        $task = new Task([
            'title' => $input['title'],
            'description' => $input['description'],
            'status' => $input['status'],
            'deadline' => $input['deadline'],
            'demand_id' => $input['demand_id'],
            'created_by' => auth()->user()->id
        ]);
        
        $task->save();
        // return dd($task);
        $usersIds = $input['users_ids']; 
        $task->users()->sync($usersIds);
        
        return response($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task->load('demand')->load('users')->load('messages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
