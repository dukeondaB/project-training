<?php

namespace App\Http\Services;

use App\Http\Repositories\SubjectRepository;
use App\Http\Requests\Subject\CreateSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubjectService
{

    protected $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function showAll()
    {
        $data = $this->subjectRepository->showAll();
        $user = Auth::user();
        return view('subject.index', ['data' => $data, 'user' => $user, 'subjectRepository' => $this->subjectRepository]);
    }

    public function getForm()
    {
        return view('subject.create');
    }

    public function save(CreateSubjectRequest $request)
    {
        $data = $request->all();
        $this->subjectRepository->save($data);

        return redirect()->route('subject-list')->with('success', 'Subject created successfully');
    }

    public function delete($id)
    {
        try {
            $this->subjectRepository->delete($id);
            return redirect()->route('subject-list')->with('success', 'deleted');
        } catch (\Exception $e) {

            return redirect()->route('subject-list')->with('error', 'An error occurred while deleting faculty.');
        }
    }

    public function getById($id)
    {
        $data = $this->subjectRepository->findById($id);
        return view('subject.edit', ['data' => $data]);
    }

    public function update(UpdateSubjectRequest $request, $id)
    {
        $record = $this->subjectRepository->findById($id);
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

        $this->subjectRepository->update($data, $id);

        return redirect()->route('subject-list')->with('success', 'Subject created successfully');

    }

    public function register($course_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->student->subjects()->attach($course_id);
        }
        return redirect()->back()->with('success', 'Thành công');
    }

}