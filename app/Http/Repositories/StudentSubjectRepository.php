<?php

namespace App\Http\Repositories;

use App\Models\Student;
use App\Models\StudentSubject;

class StudentSubjectRepository extends BaseRepository
{
    public function __construct(StudentSubject $studentSubject)
    {
        parent::__construct($studentSubject);
    }

    public function updatePoint($studentId, $subjectId, $data){
      $studentSubject =$this->model->where('subject_id', $subjectId)->where('student_id', $studentId)->first();
    if ($studentSubject) {
        $studentSubject->update($data);
        return true; // or return the updated model, if needed
    }

    return false;
    }

}
