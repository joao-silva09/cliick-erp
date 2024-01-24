<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'deadline', 'demand_id'];

    public function demand(): BelongsTo
    {
        return $this->belongsTo(Demand::class);
    }

    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
