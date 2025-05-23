<?php

namespace App\Repositories\Eloquent;

use App\Models\RequestHelp;
use App\Repositories\Interfaces\IHelpRequestRepository;

class HelpRequestRepository implements IHelpRequestRepository
{
    public function create(array $data)
    {
        return RequestHelp::create($data);
    }
}