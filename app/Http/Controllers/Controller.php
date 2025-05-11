<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests {
        authorize as protected baseAuthorize;
    }

    use ValidatesRequests {
        validate as protected baseValidate;
    }

    // All your controllers now automatically have:
    // - Middleware registration
    // - Authorization helpers
    // - Validation helpers
    // - Response helpers
    // - Session handling
    // - Etc...
}
