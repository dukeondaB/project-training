<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the student is authorized to make this request.
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
        $checkMethod = $this->_method;

        if ($checkMethod == 'PUT') {
            return [
                'name' => 'required|string|min:5|max:125',
                'email' => 'required|email|regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
                'phone' => 'required|regex:/^(0[0-9]{9,10})$/',
                'gender' => 'required',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'birth_day' => 'nullable',
                'faculty_id' => 'required',
            ];
        } else {
            return [
                'name' => 'required|string|min:5|max:125',
                'email' => 'required|email|unique:users|regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
                'phone' => 'required|regex:/^(0[0-9]{9,10})$/|unique:students',
                'gender' => 'required',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'birth_day' => 'required',
                'faculty_id' => 'required',
            ];
        }
    }
}
