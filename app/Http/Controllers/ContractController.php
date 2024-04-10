<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::all();
        return ContractResource::collection($contracts->load('customer')->load('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $contract = Contract::create([
            'start_date' => $input['start_date'],
            'end_date' => $input['end_date'],
            'status' => $input['status'],
            'customer_id' => $input['customer_id']
        ]);


    // Estrutura esperada para $servicesIdsAndPrices: 
    // [
    //     service_id => ['agreed_price' => price],
    //     another_service_id => ['agreed_price' => another_price],
    //     ...
    // ]
    // $servicesIdsAndPrices = [];
    // foreach ($input['services'] as $service) {
    //     $servicesIdsAndPrices[$service['id']] = ['agreed_price' => $service['agreed_price']];
    //     $servicesIdsAndPrices[$service['id']] = ['service_date' => $service['service_date']];
    // }

    // $contract->services()->sync($servicesIdsAndPrices);

    foreach ($input['services'] as $service) {
        // Aqui, você usa 'attach' para adicionar cada serviço individualmente, passando o 'id' do serviço
        // e um array com os campos extras ('agreed_price' neste caso).
        $contract->services()->attach($service['id'], ['agreed_price' => $service['agreed_price'], 'service_date' => $service['service_date']]);
    }


        // $servicesIds = $input['services_ids'];
        // $contract->services()->sync($servicesIds);

        return new ContractResource($contract->load('services'));
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
    public function destroy(string $id)
    {
        //
    }
}
