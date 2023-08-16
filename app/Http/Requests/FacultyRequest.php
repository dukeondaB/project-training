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
        // Kiểm tra xem đây có phải là route "students.create" hay không
        $isCreate = $this->routeIs('faculty.create');
//        check method
        // Sử dụng conditional validation để chọn rules phù hợp
//        if ($isCreate) {
            return [
                'name' => 'required|unique:faculties|string|max:155',
                'description' => 'required|string',
            ];
//        }
//            return [
//                'name' => 'string|max:155',
//                'description' => 'nullable|string',
//            ];
//
    }
}
