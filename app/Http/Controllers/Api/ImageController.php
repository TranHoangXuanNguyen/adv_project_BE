<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'url' => 'required|url',
        ]);

        $image = Image::create([
            'name' => $request->name,
            'url' => $request->url,
        ]);

        return response()->json(['message' => 'Image saved', 'data' => $image], 201);
    }
}
