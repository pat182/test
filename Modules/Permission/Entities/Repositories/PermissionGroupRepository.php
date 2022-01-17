<?php

namespace Modules\Permission\Entities\Repositories;

use Modules\Permission\Entities\PermissionGroup;


class PermissionGroupRepository extends PermissionGroup
{
	/**
    * @return string
    */
    private function getGroup($data){
        return $this->where("permission_type_id",$data["permission_type_id"])
                        ->where("permission_id",$data["permission_id"]);
    }
    public function addGroupPermission($data){
        $permission = self::updateOrCreate($data);
        if(!$permission->wasRecentlyCreated && !$permission->wasChanged())
            return 0;
        else
            return $permission->permission_type_id;
    }
    public function remPerm($data){
        $permission = $this->getGroup($data);
        if($permission->first())
            $permission = $permission->delete();
        else
            $permission = null;
        return $permission;
    }
}