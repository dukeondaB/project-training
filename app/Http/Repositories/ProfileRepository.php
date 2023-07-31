<?php

namespace App\Http\Repositories;

use App\Models\User;

class ProfileRepository
{
    /**
     * @var User $model
     */

    protected $model;
    /**
     * @var StudentRepository
     */
    protected $studentRepository;

    public function __construct(User $model, StudentRepository $studentRepository)
    {
        $this->model = $model;
        $this->studentRepository = $studentRepository;
    }

    public function information(){
//        return $this->model->where('id',$id)->get();
    }

    public function uploadAvatar($request, $id){
//        dd($request, $id);
        $data = $this->studentRepository->findByUserId($id);

//        $data = $this->findById($studentId);
        return $data->update($request);
    }

    public function findById($id){
        return $this->model->findOrFail($id);
    }

}
