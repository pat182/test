<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\{User,UserProfile};
use Modules\User\Http\Requests\{UserRequest,LogInRequest};
use Modules\User\Services\AuthService;
use Modules\User\Services\UserService;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService) {
        $this->userService = $userService;
        $this->authService = $authService;
    }
    public function register(UserRequest $request){
        $payload = $request->payload();
        DB::beginTransaction();
        $user = User::create(
                        array_merge($payload['user'],
                        ['password' => bcrypt($payload['user']['password'])])
                    );
        if($user->user_id){
            $payload['user_profile']['user_id'] = $user->user_id;
            $profile = UserProfile::create($payload['user_profile']);    
            $this->userService->sendEmailReg($user);
            DB::commit();

        }else{
            DB::rollback();
            return response()->json([
                'message' => 'Something Went Wrong'
            ], 400);
        }
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    public function login(LogInRequest $request){
        $payload = $request->payload();
        $auth = $this->authService->login($payload);
        return $auth;
    }
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
}
