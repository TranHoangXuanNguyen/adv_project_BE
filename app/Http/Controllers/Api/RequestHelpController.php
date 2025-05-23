<?php
// app/Http/Controllers/Api/UserController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\RequestHelpService;
class RequestHelpController extends Controller
{
    protected $requestHelpService;
    public function __construct(RequestHelpService $requestHelpService){
        $this-> requestHelpService = $requestHelpService;
    }
    //lay tat ca 
        public function getRequest(){
        $result = $this->requestHelpService->getAllRequest();
        return response()->json($result);
    }
    //luu 
    public function saveRequestHelp(Request $request){
        $result=$this->requestHelpService-> saveRequestHelp($request->all());
        return response()->json($result);
    }
    public function deleteRequestHelp($id){
          $this->requestHelpService-> deleteRequestHelp($id);
            return response()->json(['message' => 'Deleted successfully']);
            }
    public function paginate(Request $request){
        $perpage = $request->input('per_page', 6);
        $result=$this->requestHelpService->paginate($perpage);
        return response ()->json($result);
    }

}
    ?>