<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::with('users')->get();

        return TeamResource::collection($teams);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        $input = $request;

        $team = Team::create([
            'name' => $input['name'],
            'description' => $input['description'],
            'company_id' => 1,
        ]);

        $usersIds = $input['users_ids'];
        $team->users()->sync($usersIds);

        return new TeamResource($team->load('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addUsers(Team $team, Request $request)
    {
        $usersIds = $request['users_ids'];

        $usersIds = array_unique($usersIds);

        $usersInTeam = DB::table('team_user')
            ->whereIn('user_id', $usersIds)
            ->where('team_id', $team->id)
            ->pluck('user_id')
            ->toArray();

        $usersToAdd = array_diff($usersIds, $usersInTeam);
                
        $team->users()->attach($usersToAdd);

        return new TeamResource($team->load('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return $team;
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
    public function destroy(Team $team)
    {
        $team->users()->detach();
        $team->demands()->detach();
        $team->delete();

        return response()->noContent();
    }
}
