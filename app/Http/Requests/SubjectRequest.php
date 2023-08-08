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
        $isCreate = $this->is('/subject/create'); // dùng is với url routeIs với route name
        if ($isCreate){
            return [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'faculty_id' => 'required|exists:faculties,id',
            ];
        }else{
            return [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'faculty_id' => 'required|exists:faculties,id',
            ];
        }

    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than :max characters.',
            'description.required' => 'Detail is required.',
            'description.string' => 'Detail must be a string.',

        ];
    }
}