<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::get();
        
        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $request->validate([
            'customer_logo' => 'required|image|max:2048', // Limita o arquivo a 2MB e deve ser uma imagem
        ]);

        $customer = Customer::create($request->all());

        // Faz o upload da nova logo e retorna o caminho
        $path = $request->file('customer_logo')->store('customer_logos', 'public');

        // Atualiza o caminho da foto de perfil no banco de dados
        $customer->customer_logo = $path;
        $customer->save();
  
        // Gera a URL pública para a imagem
        // $photoUrl = Storage::url($customer->logo);

        return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
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
