<?php

namespace App\Http\Repositories;

use App\Models\Student;
use App\Models\StudentSubject;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectRepository
{
    /**
     * @var $model
     */

    protected $model;
    /**
     * @var StudentSubject
     */
    protected $studentSubject;
    /**
     * @var Student
     */
    protected $student;

    public function __construct(Subject $model, StudentSubject $studentSubject, Student $student)
    {
        $this->model = $model;
        $this->studentSubject = $studentSubject;
        $this->student = $student;
    }

    public function showAll(){
        $studentFacultyId = Auth::user()->student->faculty->id;
        $subjects = Subject::whereHas('faculty', function ($query) use ($studentFacultyId) {
            $query->where('id', $studentFacultyId);
        })->paginate(10);
        return $subjects;
    }

//    public function isRegister(){
//        $student = $this->model->students()->where('user_id', Auth::id());
//        $registeredCourses = $student->courses->pluck('id')->toArray();
//        return $this->findById($registeredCourses);
//    }

    public function getStudentPointInSubject($subjectId)
    {
        $student = $this->student->where('user_id', Auth::id())->first();

        if ($student) {
            $studentPoint = DB::table('student_subject')
                ->where('student_id', $student->id)
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

    public function save($data){
        return $this->model->create($data);
    }

    public function delete($id){
        $data = $this->findById($id);
        return $data->delete();
    }

    public function findById($id){
        return $this->model->findOrFail($id);
    }

    public function update($data, $id){
        $item = $this->model->find($id);
        return $item->update($data);
    }

    public function CourseRegister($course_id){
        return $this->model->users()->attach($course_id);
    }

}
