<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FacultyRequest extends FormRequest
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
                'name' => 'string|max:155',
                'description' => 'nullable|string',
            ];
        } else {
            return [
                'name' => 'required|unique:faculties|string|max:155',
                'description' => 'required|string',
            ];
        }
    }
}
