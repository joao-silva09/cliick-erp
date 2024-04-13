<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'installments_quantity',
        'installments_number',
        'installment_value',
        'due_date',
        'payment_date',
        'contract_service_id'
    ];

    public function contractService()
    {
        return $this->belongsTo(ContractService::class);
    }
}
