<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Auth::user()->role === 'Admin') {

                    return redirect(route('admin.homepage'));

                }elseif (Auth::user()->role === 'Manajemen') {

                    return redirect(route('manajemen.homepage'));
                
                }elseif (Auth::user()->role === 'Ketua') {

                    return redirect(route('ketua.homepage'));

                }elseif (Auth::user()->role === 'Anggota') {

                    return redirect(route('anggota.homepage'));

                }
            }
        }

        return $next($request);
    }
}
