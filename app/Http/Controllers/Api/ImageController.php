<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
        ]);

        try {
            $image = Image::create($request->only(['name', 'url']));
            return response()->json([
                'message' => 'Image saved successfully',
                'data' => $image
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to save image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $page = $request->query('page', 1);

            $images = Image::query()
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'message' => 'Images retrieved successfully',
                'data' => $images
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve images',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $image = Image::findOrFail($id);

            $image->delete();

            return response()->json([
                'message' => 'Image deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
