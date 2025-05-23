<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\IRequestHelpRepository;

use App\Models\RequestHelp;

class RequestHelpRepository implements IRequestHelpRepository
{
    public function getAll()
    {
        return RequestHelp::with([ 'sender', 'receiver'])
        ->orderBy('created_at', 'desc')
        ->get();         
    }
    public function saveRequestHelp(array $data)
    {
        return RequestHelp::create($data);
    }
    public function deleteRequestHelp($id){
       return RequestHelp::find($id);    
    }
    public function paginate($perpage){
            return RequestHelp::with(['sender','receiver'])
                        ->orderBy('created_at','desc')
                        ->paginate($perpage);
    }
    }
      
