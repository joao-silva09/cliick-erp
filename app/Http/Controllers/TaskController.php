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

        return TaskResource::collection($tasks
            ->where('status', '!=', 'Concluído')
            ->load('demand.customer')
            ->sortBy('deadline')
        );
    }
    
    /**
     * Display a listing of the resource.
     */
    public function getByTeam(Team $team)
    {
        // $demands = Demand::whereHas('teams', function ($query) use ($team) {
        //     $query->where('team_id', $team->id);
        // })->get();
        // // $demands = Demand::with('customer')->get();
        // return DemandResource::collection($demands
        //     ->load('customer')
        //     ->load('tasks')
        //     ->load('teams')
        //     ->load('tasks.users')
        // );

        return new TeamResource($team
            ->load('tasks.customer')
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function getByCustomer(Customer $customer)
    {
        // $demands = Demand::where('customer_id', $customer->id)->get();
        // $demands = Demand::with('customer')->get();
        return new CustomerResource($customer
            ->load('tasks.teams')
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function completedTasks()
    {
        $tasks = auth()->user()->tasks;

        return TaskResource::collection($tasks
            ->load('customer')
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
        $user = auth()->user();
        
        $task = new Task([
            'title' => $input['title'],
            'description' => $input['description'],
            'status' => $input['status'],
            'deadline' => $input['deadline'],
            'customer_id' => $input['customer_id'],
            'teams_ids' => $input['teams_ids'],
            'users_ids' => $input['users_ids'],
            'created_by' => auth()->user()->id
        ]);

        $task->save();
        $teamsIds = $input['teams_ids']; 
        $task->teams()->sync($teamsIds);
        
        $task->save();
        $usersIds = $input['users_ids']; 
        $task->users()->sync($usersIds);

        Message::create([
            "message" => '<b>Título: </b>' . $task['title'] . 
                        '<br><b>Descrição: </b>' . $task->description .
                        '<br><b>Data de Criação: </b>' . $task->created_at->format('d/m/Y') .
                        '<br><b>Prazo: </b>' . $task->deadline,
                        '<br><b>Criado Por: </b>' . $user['first_name'] . ' ' . $user['last_name'],
            "task_id" => $task->id,
            "message_type" => 'new_task',
            'username' => 'Sistema',
        ]);
        
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task
            ->load('demand.customer', 'demand.teams')
            ->load('user')
            ->load('users')
            ->load('messages')
        );
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
