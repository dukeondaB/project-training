<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
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
//        dd(request()->all());
        return [
            'full_name' => 'required|string|min:5|max:125',
            'email' => 'required|email|regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            'phone' => 'required|regex:/^(0[0-9]{9,10})$/',
            'gender' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'student_code' => '',
            'datebirth' => 'required',
        ];
    }
    public function messages()
    {
        return [
          'phone.regex' => 'Số điện thoại gồm 10-11 số và bắt đầu bằng số 0'
        ];
    }
}
