<?php

namespace Src\IdentityAndAccess\User\Infrastructure\Controllers;

use App\Http\Requests\UserPostRequest;
use Illuminate\Http\Request;
use Src\IdentityAndAccess\User\Application\UseCase\RegisterUserUseCase;
use Src\IdentityAndAccess\User\Application\UseCase\LoginUserUseCase;
use Src\IdentityAndAccess\User\Application\UseCase\GetUserByIdUseCase;
use Src\IdentityAndAccess\User\Infrastructure\Mappers\UserDto;

class UserController 
{
    public function __construct(
        private RegisterUserUseCase $registerUser,
        private LoginUserUseCase $loginUser,
        private GetUserByIdUseCase $findUserById
    ) {}

    public function register(UserPostRequest $request)
    {
        $validated = $request->validated();

        $result = $this->registerUser->execute($validated['name'], $validated['email'], $validated['password']);

        return response()->json($result, 201);
    }

    public function login(UserPostRequest $request)
    {
        $validated = $request->validated();

        $result = $this->loginUser->execute($validated['email'], $validated['password']);

        return response()->json($result, $result['status'] ?? 200);
    }

    public function show(string $id)
    {
        $user = $this->findUserById->execute($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(UserDto::fromEntity($user));
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
