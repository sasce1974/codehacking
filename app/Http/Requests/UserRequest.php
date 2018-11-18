<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_id'=>'required|max:50',
            'name'=>'required|max:250',
            'email'=>'required|unique:users|email',
            'password'=>'required|between:6,25',
        ];
    }
}
