<?php

namespace Modules\Permission\Services;

use Modules\Permission\Entities\Repositories\PermissionRepository;
use Modules\Permission\Entities\Repositories\PermissionTypeRepository;
use Modules\Permission\Entities\Repositories\PermissionGroupRepository;

class PermissionService
{
    private $permissionTypeRepo;
    private $permisssionRepo;
    private $permissionGroupRepo;
    protected $status;

    public function __construct(PermissionTypeRepository $permissionTypeRepo,
                                PermissionRepository $permissionRepo,
                                PermissionGroupRepository $permissionGroupRepo){

        $this->permissionTypeRepo = $permissionTypeRepo;
        $this->permissionRepo = $permissionRepo;
        $this->permissionGroupRepo = $permissionGroupRepo;
        // $this->status = [];
    }
    protected function formatStatus($code,$msg,$data = null) : void {
        $this->status["code"] = $code;
        $this->status["msg"] = $msg;
        if($data)
            $this->status["data"] = is_array($data) ? $data : $data->toArray(); 
        else
            $this->status["data"] = [];
        // return $this->status;
    }
    public function addPermType($payload){
        if($this->permissionTypeRepo->addPermission($payload))
            $this->formatStatus(200,config('permission.constants.messages.succ'));
        else
            $this->formatStatus(400,config('permission.constants.messages.fail'));

        return $this->status; 
    }
    public function addPerm($payload){
        if($this->permissionRepo->addPermission($payload))
            $this->formatStatus(200,config('permission.constants.messages.succ'));
        else
            $this->formatStatus(400,config('permission.constants.messages.fail'));

        return $this->status;
    }
    public function addPermGroup($payload){
        if($this->permissionGroupRepo->addGroupPermission($payload))
            $this->formatStatus(200,config('permission.constants.messages.succ'));
        else
            $this->formatStatus(400,config('permission.constants.messages.failII'));
        
        return $this->status;
    }
    public function getPermissionType($id){
        if(!$this->permissionTypeRepo->getPermisssion($id))
            $this->formatStatus(404,"");
        else
            $this->formatStatus(200,"",$this->permissionTypeRepo->getPermisssion($id));
        return $this->status;    
    }
    public function removePerm($payload){
        if($this->permissionGroupRepo->remPerm($payload))
            $this->formatStatus(200,config('permission.constants.messages.succ_rem'));
        else
            $this->formatStatus(400,config('permission.constants.messages.fail'));
        return $this->status; 
    }
    public function roleAuto($payload){
        if($this->permissionTypeRepo->roleAuto($payload))
            $this->formatStatus(200,'',$this->permissionTypeRepo->roleAuto($payload));
        else
            $this->formatStatus(400,'No Records found');
        return $this->status; 
    }
    public function permAuto($payload){
        if($this->permissionRepo->permAuto($payload))
            $this->formatStatus(200,'',$this->permissionRepo->permAuto($payload));
        else
            $this->formatStatus(400,'No Records found');
        return $this->status; 
    }
}