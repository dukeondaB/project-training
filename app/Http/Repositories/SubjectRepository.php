<?php

namespace App\Http\Repositories;

use App\Enums\PerPage;
use App\Models\Student;
use App\Models\StudentSubject;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class SubjectRepository extends BaseRepository
{
    /**
     * @var StudentSubject
     */
    protected $studentSubject;
    /**
     * @var Student
     */
    protected $student;

    public function __construct(Subject $subject, StudentSubject $studentSubject, Student $student)
    {
        parent::__construct($subject);
        $this->studentSubject = $studentSubject;
        $this->student = $student;
    }

    public function showAll()
    {
        $query = $this->model->with('faculty');

        if (Auth::user()->student) {
            $studentFacultyId = Auth::user()->student->faculty->id;

            $query->whereHas('faculty', function ($query) use ($studentFacultyId) {
                $query->where('id', $studentFacultyId);
            });
        }

        $subjects = $query->paginate(PerPage::TEN);

        // Sử dụng collection để gán điểm cho từng môn học nếu là sinh viên
        if (Auth::user()->student) {
            $student = Auth::user()->student;
            $studentPoints = $this->getStudentPoints($student);
            $subjects->each(function ($subject) use ($studentPoints) {
                $subjectId = $subject->id;
                $subject->studentPoint = isset($studentPoints[$subjectId]) ? $studentPoints[$subjectId] : null;
            });
        }

        return $subjects;
    }

    protected function getStudentPoints($student)
    {
        $studentPoints = [];

        foreach ($student->subjects as $item) {
            $studentPoints[$item->pivot->subject_id] = $item->pivot->point;
        }

        return $studentPoints;
    }

}
