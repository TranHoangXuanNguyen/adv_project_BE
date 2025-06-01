<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Achievement;
class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'img' => 'required|url|max:2048',
        ]);

        try {
            $achievement = Achievement::create($request->only(['user_id' ,'title','description', 'img']));
            return response()->json([
                'message' => 'Image saved successfully',
                'data' => $achievement
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

            $achievements = Achievement::query()
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'message' => 'Images retrieved successfully',
                'data' => $achievements
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
            $achievement = Achievement::findOrFail($id);
            $achievement->delete();
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
