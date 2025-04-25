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
        $user = Auth::guard('api')->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Bạn không phải admin.'], 403);
        }

        return $next($request);
    }
}
