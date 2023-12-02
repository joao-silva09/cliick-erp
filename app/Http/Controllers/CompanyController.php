<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::with('customers')->with('teams')->paginate(2);
        return $companies;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response(Company::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return Company::find($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $company->update($request->all());

        return $company;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json([], 204);
    }
}
