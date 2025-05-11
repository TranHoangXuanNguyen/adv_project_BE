<?php

namespace App\Services;

use App\Repositories\Interfaces\IAuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected $userRepository;

    public function __construct(IAuthRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user
     *
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,teacher,student',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors(), 'status' => 400];
        }

        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'message' => 'User registered successfully',
            'status' => 201,
            'token' => $token
        ];
    }

    /**
     * Authenticate a user and return token
     *
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): array
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return ['error' => 'Unauthorized', 'status' => 401];
        }

        return $this->createTokenResponse($token);
    }

    /**
     * Get the authenticated user
     *
     * @return mixed
     */
    public function me()
    {
        return JWTAuth::user();
    }

    /**
     * Logout the user
     *
     * @return array
     */
    public function logout(): array
    {
        JWTAuth::invalidate();
        return ['message' => 'Successfully logged out'];
    }

    /**
     * Refresh the token
     *
     * @return array
     */
    public function refresh(): array
    {
        return $this->createTokenResponse(JWTAuth::refresh());
    }

    /**
     * Create token response structure
     *
     * @param string $token
     * @return array
     */
    protected function createTokenResponse(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ];
    }
}
