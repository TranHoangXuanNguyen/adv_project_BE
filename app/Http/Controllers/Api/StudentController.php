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
        $validated=  $request->validate([
            'email' => 'required|email|unique:users,email'
        ]);
        $student =$this->userRepository-> createStudent($validated);
        return response()->json($student);
    }
}