<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'username', 'message_type', 'task_id'];

    public function task() {
        return $this->belongsTo(Task::class);
    }
}
