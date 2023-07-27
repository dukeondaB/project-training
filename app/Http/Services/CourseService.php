<?php

namespace App\Http\Services;

use App\Http\Repositories\CourseRepository;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\course\UpdateCourseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseService
{

    protected $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function showAll()
    {
        $data = $this->courseRepository->showAll();
        $isRegister = $this->courseRepository->isRegister();
    return view('course.index', ['data' => $data, 'isRegister' => $isRegister])
        ->with('courseRepository', $this->courseRepository);
    }

    public function getForm()
    {
        return view('course.create');
    }

    public function save(CreateCourseRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/courses', $imageName);
            $data['image'] = $imageName;
        }

        $this->courseRepository->save($data);

        return redirect()->route('course-list')->with('success', 'Course created successfully');
    }

    public function delete($id)
    {
        try {
            $this->courseRepository->delete($id);
            return redirect()->route('course-list')->with('success', 'deleted');
        } catch (\Exception $e) {

            return redirect()->route('course-list')->with('error', 'An error occurred while deleting department.');
        }
    }

    public function getById($id)
    {
        $data = $this->courseRepository->findById($id);
        return view('course.edit', ['data' => $data]);
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        $record = $this->courseRepository->findById($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Nếu có ảnh mới thay vào, xóa ảnh cũ (nếu có)
            if ($record->image) {
                Storage::delete('public/images/courses/' . $record->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/courses', $imageName);
            $data['image'] = $imageName;
        } else {
            // Nếu không có ảnh mới thay vào, giữ nguyên ảnh cũ
            $data['image'] = $record->image;
        }

        $this->courseRepository->update($data, $id);

        return redirect()->route('course-list')->with('success', 'Course created successfully');

    }

    public function register($course_id)
    {
        if (Auth::check()) {
            // Lấy thông tin người dùng hiện tại
            $user = Auth::user();

            $user->courses()->attach($course_id);
        }
        return redirect()->back()->with('success', 'Thành công');
    }

}
