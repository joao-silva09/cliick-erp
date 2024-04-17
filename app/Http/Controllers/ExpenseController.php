<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ExpenseResource;
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
        $expenses = Expense::where('company_id', 1)->get();
        $firstExpense = $expenses->first();
        $companyResource = $firstExpense ? new CompanyResource($firstExpense->company) : null;
        return [
            'expenses' => ExpenseResource::collection($expenses),
            'company' => $companyResource,
            'totalExpense' => $expenses->sum('value') ?? 0
        ];
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

        $expenses = Expense::where('company_id', 1)->get();

        return [
            'expense' => new ExpenseResource($expense),
            'company' => new CompanyResource($expense->company),
            'totalExpense' => $expenses->sum('value')
        ];
        // $company = Company::find($request->company_id);
        // return response(Expense::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return $expense->with('company')->get();
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
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return ['msg' => 'ok'];
    }
}
