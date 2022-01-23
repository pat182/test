<?php

namespace Modules\Permission\Entities\Repositories;

use Modules\Permission\Entities\PermissionType;

class PermissionTypeRepository extends PermissionType
{
	/**
    * @return string
    */
    private function findType(array $col){
        return self::select($col);
    }
    public function addPermission($data){
        $permission = self::create($data);
        return $permission->permission_type_id;
    }
    public function getPermisssion($id){
        $permission_type = $this->findType(['*'])->where('permission_type_id',$id);
        $permission = $permission_type->with('permissionGroup.permissionRole')->first();
        if($permission)
            $permission = $this->formatData($permission->toArray());
        return $permission;
    }
    public function roleAuto($string){
        $query = $this->findType(['*'])->where('permission','LIKE',  $string . '%')
        ->orderBy('permission_type_id','Asc')
        ->get();
        if(count($query))
            $data = $query;
        else
            $data = null;
        return $data;
    }
    private function formatData(array $data) : array
    {
        return [
            "permission_type_id" => $data['permission_type_id'],
            "permission" => $data["permission"],
            "permission_group" => array_map(function($item){
                return [
                    "permission_id" => $item['permission_id'], 
                    "permission_role" => [
                        "action_description" => $item['permission_role']["action_description"],
                        "action" => $item['permission_role']["action"],
                        "'method" => $item['permission_role']["method"]
                    ]
                ];
            },$data['permission_group'])
        ];
    }
}