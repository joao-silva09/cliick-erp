<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description', 
        'company_id'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    
    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
