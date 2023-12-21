<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Company;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Expense::with('company')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        $expense = new Expense($request->validated());
        $expense->save();

        $company = Company::find($expense['company_id']);

        if ($company) {
            $company->balance -= $expense->value;
            $company->save();
        }

        return response($expense->with('company')->get());
        // $company = Company::find($request->company_id);
        // return response(Expense::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return $expense->with('company')->first();
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
