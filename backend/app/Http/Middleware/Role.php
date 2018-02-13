<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = $request->user();
        $role = explode(',', $user->role);
        if (in_array('admin', $role)) {
            return $next($request);
        } else {
           $path = $request->path();
           $method = $request->method();
            $name = Route::currentRouteName();
           dump($name);
           if (preg_match('/^api\/admin\/\d+$/', $path)) {
               return $next($request);
           }
            foreach($role as $item) {
            }
           return response()->json([
               'status' => 'error',
               'status_code' => 401,
               'message' => '当前用户无权限访问指定的功能'
           ], 401);
        }

        } else {
            return $next($request);
        }

//        $user = $request->user();
//        $role = explode(',', $user->role);
//        if (in_array('admin', $role)) {
//            echo '管理员';
//            return $next($request);
//        } else {
//           echo '非管理员';
//           $url = $request->url();
//           echo $url;
//        }
    }
}
