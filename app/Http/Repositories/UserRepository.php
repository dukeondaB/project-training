<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function createStudent($data){
        return $this->model->student()->create($data);
    }

    public function delete($id){
        $user = $this->model->findOrFail($id);
        return $user->delete();
    }

}
