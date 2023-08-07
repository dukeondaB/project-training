<?php

namespace App\Http\Requests\Faculty;

use Illuminate\Foundation\Http\FormRequest;

class CreateFacultyRequest extends FormRequest
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
        // Kiểm tra xem đây có phải là route "students.create" hay không
        $isCreate = $this->routeIs('students.create');

        // Sử dụng conditional validation để chọn rules phù hợp
        if ($isCreate) {
            return [
                'name' => 'required|string|max:155',
                'description' => 'required|string',
            ];
        }
            return [
                'name' => 'string|max:155',
                'description' => 'string',
                // Thêm các rules khác cho trường hợp update tại đây
            ];

    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than :max characters.',
            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a string.',
        ];
    }
}
