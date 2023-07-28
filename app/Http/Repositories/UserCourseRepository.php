<?php

namespace App\Http\Repositories;

use App\Models\UserCourse;

class UserCourseRepository
{
    /**
     * @var UserCourse $model
     */

    protected $model;

    public function __construct(UserCourse $model)
    {
        $this->model = $model;
    }

    public function updateScore($userId, $courseId, $data){
      $userCourse =$this->model->where('user_id', $userId)
                            ->where('course_id', $courseId)
                            ->first();

    if ($userCourse) {
        $userCourse->update($data);
        return true; // or return the updated model, if needed
    }

    return false;
    }

}
