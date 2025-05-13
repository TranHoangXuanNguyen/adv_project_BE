<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassMate;

class ClassMateController extends Controller
{
    public function getStudents($id)
    {
        $class = ClassMate::with('students')->find($id);

        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        return response()->json([
            'class_id' => $class->id,
            'students' => $class->students
        ]);
    }
}
