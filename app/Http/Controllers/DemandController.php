<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\DemandResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Models\Customer;
use App\Models\Demand;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demands = Demand::with('customer')
            ->with('tasks')
            ->with('user')
            ->get();
        
        return DemandResource::collection($demands);
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
            ->load('demands.tasks')
            ->load('demands.customer')
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
        ->load('demands.teams')
        ->load('demands.tasks')
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function getUsersByDemand(Demand $demand)
    {
        $users = $demand
            ->teams()
            ->with('users')
            ->get()
            ->pluck('users')
            ->flatten();

        $response = $users
            ->unique('id')
            ->sortBy('name');

        return UserResource::collection($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request;

        $demand = Demand::create([
            'title' => $input['title'],
            'description' => $input['description'] ?? null,
            'status' => $input['status'],
            'deadline' => $input['deadline'],
            'customer_id' => $input['customer_id'],
            'created_by' => auth()->user()->id
        ]);

        $teamsIds = $input['teams_ids'];
        $demand->teams()
            ->sync($teamsIds);

        return new DemandResource($demand->load('customer'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Demand $demand)
    {
        $demand->load('customer')
            ->load('tasks')
            ->load('teams');

        return new DemandResource($demand);
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
    public function destroy(Demand $demand)
    {
        $tasks = $demand->tasks;

        foreach ($tasks as $task) {
            $task->users()->detach();
            $demand->tasks()->delete();
        }

        $demand->teams()->detach();
        $demand->delete();
        return response()->noContent();
    }
}
