<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
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
        $this->auth = auth()->guard('web');
        // dd(auth()->user()->is_admin);
        if(auth()->user()){
            return $next($request);
        } else
        {
              $this->auth->logout();
              return redirect(url('/admin'));
        }

        return redirect('home')->with('error',"You don't have admin access.");
        // return $next($request);
    }
}
