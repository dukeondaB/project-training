<?php

namespace App\Http\Repositories;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

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
//        dd($registeredCourses)
        return $this->findById($registeredCourses);
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
