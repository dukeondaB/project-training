<?php

namespace App\Http\Services;

use App\Http\Repositories\DepartmentRepository;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\Storage;

class DepartmentService
{
    /**
     * @var DepartmentRepository
     */

    protected $DepartmentRepository;


    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->DepartmentRepository = $departmentRepository;
    }

    public function showAll()
    {
        $data = $this->DepartmentRepository->showAll();
        return view('department.index', ['data' => $data]);
    }

    public function getForm()
    {
        return view('department.create');
    }

    public function save(DepartmentRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/department', $imageName);
            $data['image'] = $imageName;
        };
        $this->DepartmentRepository->save($data);
        return redirect()->route('department-list')->with('success', 'Department created successfully');
    }

    public function delete($id)
    {
        try {
            $this->DepartmentRepository->delete($id);

            return redirect()->back()->with('success', 'deleted');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred while deleting department.');
        }
    }

    public function getById($id)
    {
        $data = $this->DepartmentRepository->getById($id);
        return view('department.edit', ['data' => $data]);
    }

    public function update(DepartmentRequest $request, $id)
    {
        $record = $this->DepartmentRepository->findById($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Nếu có ảnh mới thay vào, xóa ảnh cũ (nếu có)
            if ($record->image) {
                Storage::delete('public/images/department/' . $record->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/department', $imageName);
            $data['image'] = $imageName;
        } else {
            // Nếu không có ảnh mới thay vào, giữ nguyên ảnh cũ
            $data['image'] = $record->image;
        }
        $this->DepartmentRepository->update($data, $id);
        return redirect()->route('department-list')->with('success', 'Department created successfully');
    }

}
