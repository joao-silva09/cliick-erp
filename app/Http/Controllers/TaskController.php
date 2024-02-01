<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Message;
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

        return TaskResource::collection($tasks->load('demand.customer')->sortBy('deadline'));
    }

    /**
     * Display a listing of the resource.
     */
    public function completedTasks()
    {
        $tasks = auth()->user()->tasks;

        return TaskResource::collection($tasks
            ->load('demand.customer')
            ->where('status', 'Concluído')
            ->sortBy('deadline')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function complete(Request $request, Task $task)
    {
        $input = $request;

        $user = auth()->user();

        $task->status = "Concluído";

        $message = Message::create([
            "message" => $input['message'],
            "task_id" => $task->id,
            "message_type" => 'completed',
            'username' => $user['first_name'] . ' ' . $user['last_name'],
        ]);
        
        $task->save();
        
        return new MessageResource($message);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function requestApproval(Request $request, Task $task)
    {
        $input = $request;

        $user = auth()->user();

        $task->status = "Aguardando aprovação";

        $message = Message::create([
            "message" => $input['message'],
            "task_id" => $task->id,
            "message_type" => 'request_approval',
            'username' => $user['first_name'] . ' ' . $user['last_name'],
        ]);
        
        $task->save();
        
        return new MessageResource($message);
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
        
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task->load('demand.customer')->load('users')->load('messages'));
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
