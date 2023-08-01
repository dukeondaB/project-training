<?php

namespace App\Http\Repositories;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectRepository
{
    /**
     * @var $model
     */

    protected $model;
    public function __construct(Subject $model)
    {
        $this->model = $model;
    }

    public function showAll(){
        $studentFacultyId = Auth::user()->student->faculty->id;
//        dd($studentFacultyId);
        $subjects = Subject::whereHas('faculty', function ($query) use ($studentFacultyId) {
            $query->where('id', $studentFacultyId);
        })->paginate(10);
        return $subjects;
    }

    public function isRegister(){
//        $user = Auth::user();
        $student = $this->model->students()->where('user_id', Auth::id());
        $registeredCourses = $student->courses->pluck('id')->toArray();
        return $this->findById($registeredCourses);
    }

    public function getStudentPointInSubject($subjectId)
    {
        $student = Student::where('user_id', Auth::id())->first();

        if ($student) {
            $studentPoint = DB::table('student_subject')
                ->where('student_id', $student->id)
                ->where('subject_id', $subjectId)
                ->first();

            if ($studentPoint && isset($studentPoint->point)) {
                return $studentPoint->point;
            }

            // Hoặc sử dụng ?? để trả về giá trị mặc định (ví dụ: 0) nếu không có điểm
            // return $studentPoint->point ?? 0;

            // Hoặc trả về null nếu không có điểm
            // return $studentPoint ? $studentPoint->point : null;
        }

        return null;

    }

    public function getStudentPoint($studentId,$subjectId)
    {
        $userCourse = DB::table('student_subject')->where('student_id', $studentId)->where('subject_id', $subjectId)->first();
//        $studentSubject = $this->model->students();
//        dd($studentSubject);
        if ($userCourse->point) {
            return $userCourse->point;
        }
//
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
