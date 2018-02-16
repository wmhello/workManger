<?php

namespace App\Http\Middleware;

use App\Models\Permission;
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
        // 1、 获取当前用户的角色
        if (Auth::check()) {
            $user = $request->user();

         // 2、 因为角色有可能是过个组合，分解角色到数组
        $arrRole = explode(',', $user->role);
        if (in_array('admin', $arrRole)) {
            return $next($request);
        } else {
            $route = Route::currentRouteName();
            $permissions = [];
            // 3、 角色数组中取出每一个角色，得到对应的功能id
            $feature = \App\Role::whereIn('name',$arrRole)->pluck('permission');
            $feature = $feature->toArray();
            $strPermission = implode(',', $feature);
            $permissions = explode(',', $strPermission);
            $feature = Permission::whereIn('id',$permissions)->pluck('route_name');
            $feature = $feature->toArray();
            if (in_array($route, $feature)) {
                return $next($request);
            } else {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 401,
                    'message' => '当前用户无权限访问指定的功能'
                ], 401);
            }

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
