<?php

namespace App\Http\Middleware;

// app/Http/Middleware/CheckAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('api')->user(); // get user from BE, but, after login => have token => can read data from token
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'You are not a Admin'], 403);
        }
        return $next($request);
    }
}
