<?php

namespace App\Http\Repositories;

use App\Models\Faculty;

class FacultyRepository extends BaseRepository
{
    public function __construct(Faculty $faculty)
    {
        parent::__construct($faculty);
    }

    public function showAll(){
        return $this->model->paginate(10);
    }

    public function getAll(){
        return $this->model->all();
    }

    public function save($data){
        return $this->model->create($data);
    }

    public function delete($id){
       $data = $this->model->find($id);
       return $data->delete();
    }

    public function find($id){
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
