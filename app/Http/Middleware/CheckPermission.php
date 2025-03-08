<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {

        $routeName = $request->route()->getName();
        $permission = Permission::where('route_name', $routeName)->first();
        //dd($routeName);
        if (!Auth::user()->hasPermission($permission)) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
