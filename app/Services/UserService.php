<?php

namespace App\Services;

use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService
{
    //service hande bussiness logic
    protected IUserRepository $userRepository;
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Create a new user
     *
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function createUser(array $data)
    {
        $this->validateUserData($data);
        $userData = $this->prepareUserData($data);
        return $this->userRepository->create($userData);
    }
    /**
     * Validate user creation data
     */
    protected function validateUserData(array $data): void
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
    /**
     * Prepare user data with email-derived username
     */
    protected function prepareUserData(array $data): array
    {
        return [
            'email' => $data['email'],
            'role' => $data['role'] ?? 'student',
            'name' => $this->extractUsernameFromEmail($data['email']),
            'password' => Hash::make($data['password'] ?? '12345678'),
        ];
    }

    /**
     * Extract username from email (text before @)
     */
    protected function extractUsernameFromEmail(string $email): string
    {
        return explode('@', $email)[0];
    }
}
