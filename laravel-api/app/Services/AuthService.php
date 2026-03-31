<?php

namespace App\Services;

use App\DTOs\Auth\RegisterUserDTO;
use App\DTOs\Auth\LoginUserDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AuthResource;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{

    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }
    public function register(RegisterUserDTO $data)
    {
        $user = $this->userRepository->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return new AuthResource([
            'user' => $user,
            'token' => $token,
        ]);
    }
    public function login(LoginUserDTO $data)
    {
        $user = $this->userRepository->findByEmail($data->email);

        if (!$user || !Hash::check($data->password, $user->password)) {
            throw new UnauthorizedHttpException('', 'Invalid credentials');
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
        ];
    }
    public function logout(LoginUserDTO $user)
    {

    }
    public function me(User $user)
    {

    }
}