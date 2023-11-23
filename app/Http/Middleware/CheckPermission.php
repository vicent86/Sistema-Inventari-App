<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CheckPermission
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $role_id = Auth::user()->role_id;
            $nameRoute = Route::currentRouteName();
            $current_url_chek = DB::table('menus')->select('menu_url')->where('menu_url', $nameRoute)->get()->toArray();
            if($nameRoute)
            {
                if($current_url_chek)
                {
                    $permisionCheck = DB::table('menus')
                        ->join('permissions', 'permissions.menu_id', '=', 'menus.id')
                        ->where('role_id', $role_id)
                        ->where('menu_url', $nameRoute)
                        ->get()->toArray();
                    if (empty($permisionCheck) || count($permisionCheck) <= 0)
                    {
                        return response()->view('errors.404', [], 404);
                    }
                }
            }

        }
        return $next($request);
    }
}

