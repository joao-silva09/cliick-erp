<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        return new UserResource(auth()->user());
    }

    public function all()
    {
        $users = User::where('company_id', 1)->get();
        return UserResource::collection($users);
    }

    public function update(MeUpdateRequest $request)
    {
        $input = $request->validated();
        $user = (new UserService())->update(auth()->user(), $input);
        return new UserResource($user);
    }
}
