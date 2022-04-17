<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $userName = $request->name;
        $password = $request->password;

        $userData = User::where('name', $userName)->first();

        if (!$userData || !Hash::check($password, $userData->password)) {
            throw ValidationException::withMessages([
                'name' => ['ユーザー名またはパスワードが違います。'],
            ]);
        }

        $token = $userData->createToken('token')->plainTextToken;
        return response()->json(compact('token'), 200);
    }
}
