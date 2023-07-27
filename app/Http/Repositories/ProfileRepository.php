<?php

namespace App\Http\Repositories;

use App\Models\User;

class ProfileRepository
{
    /**
     * @var User $model
     */

    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function information(){
//        return $this->model->where('id',$id)->get();
    }

    public function uploadAvatar($request, $id){
//        dd($request, $id);
        $data = $this->findById($id);
        return $data->update($request);
    }

    public function findById($id){
        return $this->model->findOrFail($id);
    }

}
