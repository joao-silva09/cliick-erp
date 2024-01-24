<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandRequest;
use App\Http\Resources\DemandResource;
use App\Models\Demand;
use App\Models\Team;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Team $team)
    {
        $demands = Demand::with('customer')->get();
        return DemandResource::collection($demands);
    }

    /**
     * Display a listing of the resource.
     */
    public function getByTeam(Team $team)
    {
        $demands = Demand::whereHas('teams', function ($query) use ($team) {
            $query->where('team_id', $team->id);
        })->get();
        // $demands = Demand::with('customer')->get();
        return DemandResource::collection($demands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DemandRequest $request)
    {
        $input = $request->validated();

        // return dd($input);
        $demand = Demand::create($input);
        $teamsIds = $input['teams_ids'];
        $demand->teams()->sync($teamsIds);
        return new DemandResource($demand);

    }

    /**
     * Display the specified resource.
     */
    public function show(Demand $demand)
    {
        return $demand;
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
        $demand->teams()->detach();
        $demand->delete();
        return response()->noContent();
    }
}
