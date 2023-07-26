<?php

namespace App\Http\Repositories;

use App\Models\Course;

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

}
