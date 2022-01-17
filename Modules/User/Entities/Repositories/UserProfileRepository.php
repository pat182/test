<?php

namespace Modules\User\Entities\Repositories;

// use Modules\User\Entities\User;
use Modules\User\Entities\UserProfile;
use Modules\User\Entities\Repositories\UserRepository;

class UserProfileRepository extends UserProfile
{
    private function getUpdatable($id){
        return $this->where('id',$id)->first();
    }
    public function updateProfile($payload){
        $user = $this->getUpdatable($payload['user_id']);
        if($user)
            $user->update($payload);  
        return $user;
    }
    public function deleteProfile($user){
        if($user){
            $profile = $user->userProfile;
            if($profile)
                $profile->delete();
        }else
            $profile = null;
        
        
        return $profile;
    }

}