<?php

namespace App\Http\Middleware;

use App\Models\MenuRoleModel;
use App\Models\RoleModel;
use Closure;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\URL;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        
        // dd(Auth::user()->admin->role_->id);
        // dd(url()->current());
        // dd(URL::to('/role'));
        
        if (!empty(session('authenticated'))) {
            $request->session()->put('authenticated', time());
            return $next($request);
        }
    
        return redirect('/login');
    }
}