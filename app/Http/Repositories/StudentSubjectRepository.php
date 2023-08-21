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

}
