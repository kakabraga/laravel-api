<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\DTOs\Auth\RegisterUserDTO;
use App\DTOs\Auth\LoginUserDTO;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $authService)
    {
        $UserDTO = new RegisterUserDTO(
            name: $request->name,
            email: $request->email,
            password: $request->password,
        );

        return $authService->register($UserDTO);
    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        $dto = new LoginUserDTO(
            email: $request->email,
            password: $request->password,
        );

        return new AuthResource(
            $authService->login($dto)
        );
    }

    public function logout(Request $request, AuthService $authService)
    {
        $authService->logout($request->user());
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}