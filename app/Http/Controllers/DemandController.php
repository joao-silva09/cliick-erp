<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandRequest;
use App\Http\Resources\DemandResource;
use App\Models\Demand;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demands = Demand::with('customer')->get();
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
        $teamsIds = $request->input('teams_ids');
        $demand->teams()->sync($teamsIds);
        return new DemandResource($demand);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
