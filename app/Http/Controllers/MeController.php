<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|max:2048', // Limita o arquivo a 2MB e deve ser uma imagem
        ]);

        $user = Auth::user(); // Obtem o usuário autenticado

        // Faz o upload da nova foto de perfil e retorna o caminho
        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        // Atualiza o caminho da foto de perfil no banco de dados
        $user->profile_photo = $path;
        $user->save();
  
        // Gera a URL pública para a imagem
        $photoUrl = Storage::url($user->profile_photo);

        // return response()->json(['message' => 'Profile photo updated successfully.']);
        return response()->json(['message' => 'Profile photo updated successfully.', 'photo_url' => $photoUrl]);

    }
}
