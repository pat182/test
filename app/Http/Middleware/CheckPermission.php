<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
// use Modules\User\Entities\Repositories\UserRepository;

class CheckPermission
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
        $end_point = rtrim(preg_replace('/\d/', '',$request->path()),'/');
        $user = JWTAuth::parseToken()->authenticate();
        // preg_replace('/\d/', '', "api/user/delete/22")
        $roles = $user->filterRoles()->first()->toArray()['permission_type']['permission_group'];
        if(!$has_perm = collect($roles)->where('permission_role.end_point',$end_point)->first())
            return response()->json(
                                    ['message' => 'User has no permission'],
                                    422
                                );
        return $next($request);
    }
}
