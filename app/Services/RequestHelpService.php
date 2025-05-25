<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\IRequestHelpRepository;


class RequestHelpService
{
    protected $repository;

    public function __construct(IRequestHelpRepository $repository)
    {
        $this->repository = $repository;
    }
//get tat ca request
    public function getAllRequest()
    {
        return $this->repository->getAll();
    }
    // Luu request moi
        public function saveRequestHelp(array $data)
    {
        $validator = Validator::make($data, [
                    'sender_id'=> 'nullable|integer',
                    'receiver_id'=> 'nullable|integer',
                    'content'=>'required|string',
        ]);
        if($validator->fails()){
                return [
                    'status'=>false,
                    'errors'=>$validator->errors()
                ];
        }
        return $this->repository->saveRequestHelp($validator->validated());
    }
     public function deleteRequestHelp($id){
             $deleted = $this->repository->deleteRequestHelp($id);

        if (!$deleted) {
            return [
                'status' => false,
                'message' => 'Không tìm thấy yêu cầu để xóa',
            ];
        }
         $deleted->delete();
        return [
            'status' => true,
            'message' => 'Xóa thành công',
        ];
    }
     public function paginate($perpage){
             return $this->repository->paginate($perpage);
}

}

