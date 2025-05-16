<?php
// app/Http/Controllers/Api/UserController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Store a newly created user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // handle res and req
        try {
            // => does not contain bussiness login
            $user = $this->userService->createUser($request->all());
            return response()->json($user, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function getByRole(string $role): JsonResponse
    {
        try {
            $listUser = $this->userService->getByRole($role);
            return response()->json($listUser, 201);
        }catch (\Throwable $th){
            return response()->json($th->getMessage(),401);
        }
    }
}
