<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class CheckUserEtikKurulMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role==="admin"||Auth::user()->role==="etik_kurul"||Auth::user()->role==="sekreterlik") {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}