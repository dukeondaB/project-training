<?php

namespace App\Http\Repositories;

use App\Models\User;

class ProfileRepository extends BaseRepository
{
    protected $studentRepository;

    public function __construct(User $user, StudentRepository $studentRepository)
    {
        parent::__construct($user);
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
        return $this->user->findOrFail($id);
    }

}
