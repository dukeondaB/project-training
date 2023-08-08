<?php

namespace App\Http\Repositories;

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

    public function showAll(){
        if (Auth::user()->student){
        $studentFacultyId = Auth::user()->student->faculty->id;

        $subjects = $this->model->whereHas('faculty', function ($query) use ($studentFacultyId) {
            $query->where('id', $studentFacultyId);
        })->paginate(10);
            return $subjects;
        }
        return $this->model->paginate(10);
//        $user = Auth::user();
//        if ($user->student) {
//            $studentFacultyId = $user->student->faculty->id;
//
//            $subjects = $this->model
//                ->leftJoin('student_subject', function ($join) use ($user) {
//                    $join->on('subjects.id', '=', 'student_subject.subject_id')
//                        ->where('student_subject.student_id', '=', $user->student->id);
//                })
//                ->where('student_subject.faculty_id', $studentFacultyId)
//                ->select('subjects.*', 'student_subject.point as student_point')
//                ->paginate(10);
//
////            dd($subjects);
//            return $subjects;

        }
//
//        return $this->model->paginate(10);
//    }
    public function getStudentPointInSubject($subjectId)
    {
        $student = $this->student->where('user_id', Auth::id())->first();
        if ($student) {
            $studentPoint = $student->studentSubjects
                ->where('subject_id', $subjectId)
                ->first();
            if ($studentPoint && isset($studentPoint->point)) {
                return $studentPoint->point;
            }
        }

        return null;

    }

    public function getStudentPoint($studentId,$subjectId)
    {
        $studentPoint = $this->studentSubject->where('student_id', $studentId)->where('subject_id', $subjectId)->first();

        if ($studentPoint){
            return $studentPoint->point;
        }

        return null;
    }

    public function CourseRegister($course_id){
        return $this->model->users()->attach($course_id);
    }

}
