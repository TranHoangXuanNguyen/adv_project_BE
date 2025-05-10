<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\UserRepositoryInterface;
class StudentController  extends Controller
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function store(Request $request){
    $validated = $request->validate([
        'email' => 'required|email|unique:users,email',
    ]);

    $validated['name'] = 'No Name';
    $validated['password'] ='12345678';

    // Tạo người dùng mới
    $student = $this->userRepository->create($validated);

        return response()->json($student);
    }
}