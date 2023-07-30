<?php

namespace App\Http\Repositories;

use App\Models\Faculty;

class FacultyRepository
{
    /**
     * @var $model
     */

    protected $model;

    public function __construct(Faculty $model)
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
       $data = $this->model->find($id);
       return $data->delete();
    }

    public function getById($id){
        return $this->model->find($id);
    }

    public function findById($id){
        return $this->model->findOrFail($id);
    }
    public function update($data,$id){
        $item = $this->model->find($id);
        return $item->update($data);
    }
}
