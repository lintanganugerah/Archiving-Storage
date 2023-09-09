<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminCabang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'Admin Cabang') {
            return $next($request);
        }

        if (Auth::user()) {
            return response()->view('404', ['error' => 'Opps, Kamu bukan seorang Admin Cabang', 'msg' => 'Silahkan login sebagai Admin Cabang']);
        } else {
            return redirect('/');
        }
    }
}
