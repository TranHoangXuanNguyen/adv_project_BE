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

}
    ?>