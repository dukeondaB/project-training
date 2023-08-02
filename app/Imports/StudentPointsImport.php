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

        // Trả về null nếu dòng dữ liệu không hợp lệ
        if (empty($studentId) || empty($subjectId) || empty($point)) {
            return null;
        }

        // Cập nhật hoặc tạo mới bản ghi trong bảng student_subject
        $studentSubject = StudentSubject::updateOrCreate(
            ['student_id' => $studentId, 'subject_id' => $subjectId],
            ['point' => $point]
        );

        // Trả về null nếu không muốn lưu bản ghi vào mảng dữ liệu
        return $studentSubject;
    }

}
