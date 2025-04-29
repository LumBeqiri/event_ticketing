<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->assignRole('user');
        $token = $user->createToken('someSecretTokenTest')->plainTextToken;

        $response = [
            'user' => new UserResource($user),
            'token' => $token,
        ];

        return $this->success($response);
    }
}
