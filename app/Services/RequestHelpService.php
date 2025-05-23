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
                    'erros'=>$validator->errors()
                ];
        }
        return $this->repository->saveRequestHelp($validator->validated());
    }

    }

        

