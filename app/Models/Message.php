<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'username', 'message_type', 'task_id', 'sent_by'];

    public function task() {
        return $this->belongsTo(Task::class);
    }

    // public function user() {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
