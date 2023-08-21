<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'faculty_id' => 'required|exists:faculties,id',
            ];
        } else {
            return [
                'name' => 'required|string|max:255|unique:subjects',
                'description' => 'required|string',
                'faculty_id' => 'required|exists:faculties,id',
            ];
        }
    }
}
