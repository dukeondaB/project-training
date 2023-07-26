<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $isAdmin)
    {

//        if (!$request->user() || $request->user()->is_admin !== $isAdmin) {
//            return redirect(RouteServiceProvider::PROFILE);
//        }

        return $next($request);
    }
}
