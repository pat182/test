<?php

namespace Modules\User\Entities\Repositories;

use Modules\User\Entities\User;


class UserRepository extends User
{
    private function getAll($params){
        $query = self::select('*')->where($params);
        return $query;
    }
    private function getUser($user_id){
        return $this->where('user_id',$user_id);
    }
    public function show($user_id){
        return $this->getUser($user_id)->first();
    }
    public function deleteUser($user_id){
        $user = $this->getUser($user_id)->first();
        if($user)
            $user->delete();
        else
            $user = null;
        return $user;
    }
    public function updatePerm($data){
        $user = $this->getUser($data['user_id']);
        if($user->update(['permission_type_id' => $data["permission_type_id"]]))
           $user = $user->first();
        else
            $user = null;
        return $user;
    }
    public function getAllUser($params){
        $query = $this->getAll($params);
        return $query->with([
                            'userProfile:user_id,f_name,l_name,contact_number',
                            'permissionType.permissionGroup.permissionRole:permission_id,action_description,action,method'
                        ])->get();
    }
}