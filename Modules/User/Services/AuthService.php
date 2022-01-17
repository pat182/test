<?php

namespace Modules\User\Services;

use JWTAuth;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\Repositories\UserRepository;


class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($request)
    {
        // to invalidate the concurrent user
        if (!JWTAuth::attempt($request))
            return response()->json(['error'=>'Unauthorized'],401);
        

        $user = $this->userRepository->show(Auth::id());

        return $this->createToken($user);
    }
    private function createToken($user){
        $token = auth()->setTTL(50000000)->login($user);
        $ttl = auth('api')->factory()->getTTL() * 60;
        return [
            'user' => $user->username,
            'permission_type' => $user->permissionType->permission,
            'token' => $token,
            'expires_in' => $ttl,
            'expires_at' => Carbon::now()->addMinutes(intval($ttl))->toDateTimeString()
        ];
    }
}
