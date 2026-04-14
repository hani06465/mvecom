<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('admin')->check()) //this line asks if  the user is not logged in using admin guard
        // admin middleware checks if the request is authenticated with the admin guard.
        {
            return redirect('/admin/login'); // if yes
        }
        return $next($request); // if no (lets the request continue to the controller.)
    }
}
