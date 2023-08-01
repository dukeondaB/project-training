<?php

namespace App\Http\Services;

use App\Http\Repositories\FacultyRepository;
use App\Http\Requests\Faculty\CreateFacultyRequest;
use App\Http\Requests\Faculty\UpdateFacultyRequest;
use Illuminate\Support\Facades\Storage;

class FacultyService
{
    /**
     * @var FacultyRepository
     */

    protected $facultyRepository;


    public function __construct(FacultyRepository $facultyRepository)
    {
        $this->facultyRepository = $facultyRepository;
    }

    public function showAll()
    {
        $data = $this->facultyRepository->showAll();
        return view('faculty.index', ['data' => $data]);
    }

    public function getForm()
    {
        return view('faculty.create');
    }

    public function save(CreateFacultyRequest $request)
    {
        $data = $request->all();
        $this->facultyRepository->save($data);
        return redirect()->route('faculty-list')->with('success', __('Faculty created successfully'));
    }

    public function delete($id)
    {
        try {
            $this->facultyRepository->delete($id);

            return redirect()->back()->with('success', __('Faculty deleted successfully'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', __('An error occurred while deleting'));
        }
    }

    public function getById($id)
    {
        $data = $this->facultyRepository->getById($id);
        return view('faculty.edit', ['data' => $data]);
    }

    public function update(UpdateFacultyRequest $request, $id)
    {
        $record = $this->facultyRepository->findById($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Nếu có ảnh mới thay vào, xóa ảnh cũ (nếu có)
            if ($record->image) {
                Storage::delete('public/images/faculty/' . $record->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/faculty', $imageName);
            $data['image'] = $imageName;
        } else {
            // Nếu không có ảnh mới thay vào, giữ nguyên ảnh cũ
            $data['image'] = $record->image;
        }
        $this->facultyRepository->update($data, $id);

        return redirect()->route('faculty-list')->with('success', __('Faculty updated successfully'));
    }

}
