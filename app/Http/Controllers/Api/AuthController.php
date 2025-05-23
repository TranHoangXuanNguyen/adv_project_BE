<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Register a new user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $result = $this->authService->register($request->all());
        if (isset($result['error'])) {
            return response()->json($result['error'], $result['status']);
        }

        return response()->json([
            'message' => $result['message'],
            'token' => $result['token']
        ], $result['status']);
    }
    /**
     * Log the user in and return a JWT.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $result = $this->authService->login($request->only('email', 'password'));
        if (isset($result['error'])) {
            return response()->json($result['error'], $result['status']);
        }
        return response()->json($result);
    }
    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json($this->authService->me());
    }
    /**
     * Log the user out.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $result = $this->authService->logout();
        return response()->json($result);
    }
    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $result = $this->authService->refresh();
        return response()->json($result);
    }

    public function saveFcmToken(Request $request){
        $this->authService->saveFcmToken($request->all());
        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }

    public function sendNotification(Request $request)
    {
        return $this->authService->sendNotification($request->all());
    }

}
