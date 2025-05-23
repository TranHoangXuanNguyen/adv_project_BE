<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RequestHelp;
use App\Services\HelpRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HelpRequestController extends Controller
{
    protected $helpRequestService;

    public function __construct(HelpRequestService $helpRequestService)
    {
        $this->helpRequestService = $helpRequestService;
    }

    public function store(Request $request)
    {
        // Validate các trường
        $validator = Validator::make($request->all(), [
            'sender_id' => 'required|integer|exists:users,user_id',
            'receiver_id' => 'required|integer|exists:users,user_id', // Thêm validate receiver_id nếu là bắt buộc
            'content' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $helpRequest = $this->helpRequestService->createHelpRequest([
                'sender_id' => $request->input('sender_id'),
                'receiver_id' => $request->input('receiver_id'),
                'content' => $request->input('content'),
            ]);

            return response()->json([
                'message' => 'Help request submitted successfully',
                'data' => $helpRequest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to submit help request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $helpRequests = RequestHelp::where('sender_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json([
                'data' => $helpRequests
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch help requests',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
