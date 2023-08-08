<?php

namespace App\Http\Services;


use App\Http\Repositories\FacultyRepository;
use App\Http\Repositories\SubjectRepository;
use App\Http\Requests\SubjectRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubjectService
{

    protected $subjectRepository;
    /**
     * @var FacultyRepository
     */
    protected $facultyRepository;

    public function __construct(SubjectRepository $subjectRepository, FacultyRepository $facultyRepository)
    {
        $this->subjectRepository = $subjectRepository;
        $this->facultyRepository = $facultyRepository;
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

    public function save(SubjectRequest $request)
    {
        $data = $request->all();
        $this->subjectRepository->create($data);

        return redirect()->route('subject.index')->with('success', __('Subject created successfully'));
    }

    public function delete($id)
    {
        try {
            $this->subjectRepository->delete($id);

            return redirect()->route('subject.index')->with('success', __('Subject deleted successfully'));
        } catch (\Exception $e) {

            return redirect()->route('subject.index')->with('error', __('An error occurred while deleting'));
        }
    }

    public function getById($id)
    {
        $data = $this->subjectRepository->findOrFail($id);
        return view('subject.edit', ['data' => $data]);
    }

    public function update(SubjectRequest $request, $id)
    {
        $data = $request->all();

        $this->subjectRepository->update($id, $data);

        return redirect()->route('subject.index')->with('success', __('Subject updated successfully'));

    }

    public function register($course_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->student->subjects()->attach($course_id);
        }

        return redirect()->back()->with('success', __('Subject regis successfully'));
    }

}
