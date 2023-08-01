<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
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
            'name' => 'required|string|max:255',
<<<<<<< Updated upstream:app/Http/Requests/Course/CreateCourseRequest.php
            'detail' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
=======
            'description' => 'required|string',
            'faculty_id' => 'required|exists:faculties,id',
>>>>>>> Stashed changes:app/Http/Requests/Subject/CreateSubjectRequest.php
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than :max characters.',
            'detail.required' => 'Detail is required.',
            'detail.string' => 'Detail must be a string.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: :values.',
            'image.max' => 'The image may not be greater than :max kilobytes.',
        ];
    }
}
