<?php 

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CustomFormStoreCrudRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

         return [
            'name' => 'required|min:1|max:191',
        ];
        
    }

}