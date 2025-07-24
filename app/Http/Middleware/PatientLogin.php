<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;

class PatientLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         //  For Patient Login
         if (empty(Session::get('result.name'))) {
            return redirect('/patient-login');
        }
        return $next($request);
    }
}
