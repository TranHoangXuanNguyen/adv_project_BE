<?php
// app/Http/Controllers/Api/UserController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use JsonException;
use Psr\Http\Message\ResponseInterface;

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
public function getPaginatedByRole(Request $request, string $role): JsonResponse{
        try{
            $perpage=$request->query('per_page',5);
            $users=$this->userService->paginatedByRole($role, $perpage);
            return response()->json([
                'success'=>true,
                'data'=>$users,
            ]);
        }catch(\Throwable $th){
          return response()->json(['success' => false, 'message' => $th->getMessage()], 500);

        }

    }
public function destroy(int $id): JsonResponse{
        try{
            $this->userService->deleteUser($id);
            return response()->json([
                 'success'=>true,
                'message'=>'User deleted successfully',
            ]);          
        }catch(\Throwable $th){
          return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
