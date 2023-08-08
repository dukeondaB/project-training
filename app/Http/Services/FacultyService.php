<?php

namespace App\Http\Services;

use App\Http\Repositories\FacultyRepository;
use App\Http\Requests\FacultyRequest;
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
        $data = $this->facultyRepository->paginate();
        return view('faculty.index', ['data' => $data]);
    }

    public function getForm()
    {
        return view('faculty.create');
    }

    public function save(FacultyRequest $request)
    {
        $data = $request->all();
        $this->facultyRepository->create($data);
        return redirect()->route('faculty.index')->with('success', __('Faculty created successfully'));
    }

    public function delete($id)
    {
        try {
            $this->facultyRepository->delete($id);

            return redirect()->route('faculty.index')->with('success', __('Faculty deleted successfully'));
        } catch (\Exception $e) {

            return redirect()->route('faculty.index')->with('error', __('An error occurred while deleting'));
        }
    }

    public function find($id)
    {
        $data = $this->facultyRepository->find($id);
        return view('faculty.edit', ['data' => $data]);
    }

    public function update(FacultyRequest $request, $id)
    {
        $data = $request->all();
        $this->facultyRepository->update($id, $data);

        return redirect()->route('faculty.index')->with('success', __('Faculty updated successfully'));
    }

}
