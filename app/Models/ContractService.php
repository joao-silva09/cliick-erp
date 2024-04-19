<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ContractService extends Pivot
{
    protected $fillable = [
        'contract_id',
        'service_id',
        'agreed_value',
        'recurrence',
        'service_date',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
