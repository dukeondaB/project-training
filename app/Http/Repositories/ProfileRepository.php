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

}
