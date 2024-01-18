<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\UserHasBeenTakenException;

class AuthService
{
    public function login(string $email, string $password)
    {
        $login = [
            'email' => $email,
            'password' => $password,
        ];
        if (!$token = auth()->attempt($login)) {
            // alternativa mensagem de erro personalizada
            // throw new LoginInvalidException('teste erro');
            throw new LoginInvalidException();
        }

        return [
            'access_token' => $token,
            'token_type' =>'Bearer',
        ];
    }

    public function register(string $firstName, string $lastName, string $email, string $password, string $companyId)
    {
        $user = User::where('email', $email)->exists();
        if (!empty($user)) {
            throw new UserHasBeenTakenException();
        }
        
        $userPassword = bcrypt($password ?? Str::random(10));
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'company_id' => $companyId,
            'password' => $userPassword,
            'confirmation_token' => Str::random(60),
        ]);
        return $user;
    }
}
