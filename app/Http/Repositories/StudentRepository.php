<?php

namespace App\Http\Repositories;

use App\Enums\PerPage;
use App\Models\Student;
use App\Models\StudentSubject;
use Illuminate\Support\Facades\DB;

class StudentRepository extends BaseRepository
{

    public function __construct(Student $student)
    {
        parent::__construct($student);
    }

    public function findByUserId($id)
    {
        return $this->model->where('user_id', $id)->first();
    }

    public function filter($array)
    {
        $maxAge = isset($array['max-age']);
//        $minAge = $array['min-age'];
        $query = $this->model;
        $now = now();
        $minBirthDate = $now->subYears($maxAge)->format('Y-m-d');
//        $maxBirthDate = $now->subYears($minAge)->format('Y-m-d');

//      check min, max
//        when check theo data minbirthdate
//        point tương tự sorting điểm theo whereHas

//        $query->when($minAge && !$maxAge, function ($q) use ($minBirthDate) {
//            return $q->where('birth_day', '<=', $minBirthDate);
//        })->when(!$minAge && $maxAge, function ($q) use ($maxBirthDate) {
//            return $q->where('birth_day', '>=', $maxBirthDate);
//        });
//
//        $query->when($minPoint && $maxPoint, function ($q) use ($minPoint, $maxPoint) {
//            return $q->whereBetween('total_point', [$minPoint, $maxPoint]);
//        })->when($minPoint && !$maxPoint, function ($q) use ($minPoint) {
//            return $q->where('total_point', '>=', $minPoint);
//        })->when(!$minPoint && $maxPoint, function ($q) use ($maxPoint) {
//            return $q->where('total_point', '<=', $maxPoint);
//        });

        return $query;
    }

    public function countRegisterCourse($userId)
    {
        $count = DB::table('student_subject')->where('student_id', $userId)->count();
        if ($count) {
            return $count;
        }

        return null;
    }

    public function listScoreStudent($userId)
    {
        $student = $this->findOrFail($userId);
        return $student->subjects;
    }

    public function savePoints(Student $student, array $data)
    {
        return $student->subjects()->sync($data);
    }

    public function updatePoint($studentId, $subjectId, $data)
    {
        $student = $this->findOrFail($studentId);
        return $student->subjects()->where('subject_id', $subjectId)->update($data);
    }

}
