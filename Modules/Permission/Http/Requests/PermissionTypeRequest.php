<?php
namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionTypeRequest extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
    	return [
    		"permission" => 'required|unique:permission_type|string|max:45|regex:/^[A-Za-z]+$/'
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
            "permission"
        ]);
    }
}