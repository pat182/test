<?php
namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionGroupRequest extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
    	return [
            "permission_type_id" => 'required|integer|min:1|exists:permission_type,permission_type_id',
            "permission_id" => 'required|integer|min:1|exists:permission,permission_id'
    	]; 
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return true;
    // }
   	public function payload()
    {
        return $this->only([
            "permission_type_id",
            "permission_id"
        ]);
    }
}