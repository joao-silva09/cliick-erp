<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\Task;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // return new MessageResource::collection()
    }

    /**
     * Display the specified resource.
     */
    public function getByTask(Task $task)
    {
        $messages = Message::where('task_id', $task->id)->get();
        return MessageResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request;
        $user = auth()->user();
        
        $message = Message::create([
            'message' => $input['message'],
            'task_id' => $input['task_id'],
            'message_type' => $input['message_type'] ?? 'default',
            'username' => $user['first_name'] . ' ' . $user['last_name'],
            'sent_by' => $user->id,
        ]);

        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $messages = Message::where('task_id', $task->id)->get();
        return MessageResource::collection($messages);
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
