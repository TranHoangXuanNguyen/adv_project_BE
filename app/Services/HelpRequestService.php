<?php

namespace App\Services;

use App\Repositories\Interfaces\IHelpRequestRepository;
use Illuminate\Support\Facades\Auth;

namespace App\Services;

use App\Repositories\Interfaces\IHelpRequestRepository;

class HelpRequestService
{
    protected $helpRequestRepository;

    public function __construct(IHelpRequestRepository $helpRequestRepository)
    {
        $this->helpRequestRepository = $helpRequestRepository;
    }

    public function createHelpRequest(array $data)
    {
        // sender_id đã được controller cung cấp
        return $this->helpRequestRepository->create($data);
    }
}
