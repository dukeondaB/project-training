<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'string|min:5|max:125',
//            'email' => 'required|email|regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            'phone' => 'regex:/^(0[0-9]{9,10})$/',
            'gender' => '',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'student_code' => '',
//            'datebirth' => 'required',
            'faculty_id' => 'exists:faculties,id',

        ];
    }
}
