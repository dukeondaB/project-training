<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @var $model
     */

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function save($data)
    {
        return $this->model->create($data);
    }

    public function createStudent($data){
        return $this->model->student()->create($data);
    }

    public function delete($id){
        $user = $this->model->findOrFail($id);
        return $user->delete();
    }

}
