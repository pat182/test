<?php

namespace Modules\Permission\Entities\Repositories;

use Modules\Permission\Entities\Permission;

class PermissionRepository extends Permission
{
	/**
    * @return string
    */
    public function addPermission($data){
        $permission = self::create($data);
        return $permission->permission_id;
    }
}