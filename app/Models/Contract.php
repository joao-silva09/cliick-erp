<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function contractServices()
    {
        return $this->hasMany(ContractService::class);
    }
}
