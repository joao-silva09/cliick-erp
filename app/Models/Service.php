<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_value',
        'active'
    ];

    public function contracts()
    {
        return $this->belongsToMany(Contract::class);
    }
}
