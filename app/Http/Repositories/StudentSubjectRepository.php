<?php

namespace App\Http\Repositories;

use App\Models\Student;
use App\Models\StudentSubject;

class StudentSubjectRepository
{
    /**
     * @var StudentSubject $model
     */

    protected $model;

    public function __construct(StudentSubject $model)
    {
        $this->model = $model;
    }

    public function updatePoint($studentId, $subjectId, $data){
//        dd($data);
      $studentSubject =$this->model->where('subject_id', $subjectId)->where('student_id', $studentId)->first();
    if ($studentSubject) {
        $studentSubject->update($data);
        return true; // or return the updated model, if needed
    }

    return false;
    }

}
