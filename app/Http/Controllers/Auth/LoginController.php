<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->error('Wrong credentials', 401);
        }

        $token = $user->createToken('someSecretTokenTest')->plainTextToken;

        $response = [
            'user' => new UserResource($user),
            'token' => $token,
        ];

        return $this->success($response);
    }
}
