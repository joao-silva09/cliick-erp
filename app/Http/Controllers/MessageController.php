<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\Task;
use App\Models\User;
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
        return MessageResource::collection($messages->load('sent_by'));
    }

    /**
     * Display the specified resource.
     */
    public function getByUser()
    {
        $user = auth()->user();
        $messages = Message::where("sent_by", $user->id)->orderBy('created_at', 'desc')->get();
        return MessageResource::collection($messages->load('task'));
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

        return new MessageResource($message->load('sent_by'));
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
