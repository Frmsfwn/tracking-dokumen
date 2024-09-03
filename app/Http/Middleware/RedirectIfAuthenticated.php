<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Auth::user()->role === 'SuperAdmin') {

                    return redirect(route('superAdmin.homepage'));
                    
                }elseif (Auth::user()->role === 'Admin') {
    
                    return redirect(route('admin.homepage'));
    
                }elseif (Auth::user()->role === 'PIC') {
    
                    return redirect(route('pic.homepage'));
                    
                }
            }
        }

        return $next($request);
    }
}
