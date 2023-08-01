<?php

namespace App\Imports;

use App\Models\StudentSubject;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentPointsImport implements ToModel
{
    public function model(array $row)
    {
        $studentId = $row[0]; // Cột 1 chứa student_id
        $subjectId = $row[1]; // Cột 2 chứa subject_id
        $point = $row[2]; // Cột 3 chứa điểm số

        return new StudentSubject([
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'point' => $point,
        ]);
    }

}
