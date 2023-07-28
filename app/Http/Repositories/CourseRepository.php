<?php

namespace App\Http\Repositories;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseRepository
{
    /**
     * @var $model
     */

    protected $model;
    public function __construct(Course $model)
    {
        $this->model = $model;
    }

    public function showAll(){
        return $this->model->paginate(10);
    }

    public function isRegister(){
        $user = Auth::user();
        $registeredCourses = $user->courses->pluck('id')->toArray();
        return $this->findById($registeredCourses);
    }

    public function getUserScoreInCourse($courseId)
    {
        $user = Auth::user();
        $userCourse = DB::table('user_course')->where('user_id', Auth::id())->where('course_id', $courseId)->first();
//        dd($userCourse);
        if ($userCourse) {
            return $userCourse->score;
        }
//
        return null;
    }

    public function getUerScore($userId,$courseId)
    {
        $userCourse = DB::table('user_course')->where('user_id', $userId)->where('course_id', $courseId)->first();

        if ($userCourse) {
            return $userCourse;
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
