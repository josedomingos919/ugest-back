<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Pessoa;
use App\Models\Nivelacesso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'pessoa_id' => 'required|string',
            'nivelAcesso_id' => 'required|string',
        ]);

        $userResponse = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'pessoa_id' => $fields['pessoa_id'],
            'nivelAcesso_id' => $fields['nivelAcesso_id'],
        ]);

        $token = $userResponse->createToken('apptoken')->plainTextToken;
        $pessoa = Pessoa::where('pes_id', $fields['pessoa_id'])->first();

        $response = [
            'user' => $userResponse,
            'token' => $token,
            'pessoa' => $pessoa,
        ];

        return response($response, 201);
    }

    public function logOutAll()
    {
        $user = new User();

        return [
            'tokens' => $user->tokens()->delete(),
            'message' => 'Logged all out!',
        ];
    }

    public function logOut($tokenId)
    {
        $user = new User();

        return [
            'tokens' => $user
                ->tokens()
                ->where('id', $tokenId)
                ->delete(),
            'message' => 'Logged out!',
        ];
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'invalid'], 401);
        }

        $pessoa = Pessoa::where('pes_id', $user->pessoa_id)->first();
        $acesso = Nivelacesso::where('niv_id', $user->nivelAcesso_id)->first();
        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'acesso' => $acesso,
            'pessoa' => $pessoa,
        ];

        return response($response, 201);
    }
}
