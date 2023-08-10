<?php

namespace App\Http\Repositories;

use App\Enums\PerPage;
use App\Models\Student;
use App\Models\StudentSubject;
use Illuminate\Support\Facades\DB;

class StudentRepository extends BaseRepository
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(Student $student, UserRepository $userRepository)
    {
        parent::__construct($student);
        $this->userRepository = $userRepository;
    }

    public function findByUserId($id){
        return $this->model->where('user_id',$id)->first();
    }

    public function filterByDateOfBirthAndPoint($minAge, $maxAge, $minPoint, $maxPoint)
    {
        $query = $this->model->with('user');
        // Chuyển minAge và maxAge thành ngày tháng năm sinh
        $now = now(); // Lấy ngày giờ hiện tại
        $minBirthDate = $now->subYears($maxAge)->format('Y-m-d');
        $maxBirthDate = $now->subYears($minAge)->format('Y-m-d');

        $query->when($minAge && $maxAge, function ($q) use ($minBirthDate, $maxBirthDate) {
            return $q->whereBetween('birth_day', [$minBirthDate, $maxBirthDate]);
        })->when($minAge && !$maxAge, function ($q) use ($minBirthDate) {
            return $q->where('birth_day', '<=', $minBirthDate);
        })->when(!$minAge && $maxAge, function ($q) use ($maxBirthDate) {
            return $q->where('birth_day', '>=', $maxBirthDate);
        });

        $query->when($minPoint && $maxPoint, function ($q) use ($minPoint, $maxPoint) {
            return $q->whereBetween('total_point', [$minPoint, $maxPoint]);
        })->when($minPoint && !$maxPoint, function ($q) use ($minPoint) {
            return $q->where('total_point', '>=', $minPoint);
        })->when(!$minPoint && $maxPoint, function ($q) use ($maxPoint) {
            return $q->where('total_point', '<=', $maxPoint);
        });

        return $query->paginate(PerPage::TEN)->withQueryString();
    }


    public function countRegisterCourse($userId)
    {
        $count = DB::table('student_subject')->where('student_id', $userId)->count();
        if ($count){
            return $count;
        }

        return null;
    }

    public function listScoreStudent($userId){
        $student = $this->findOrFail($userId);
        return $student->subjects;
    }

    public function isRegistrationComplete($studentId)
    {
        $student = $this->model->findOrFail($studentId);
        $count = $this->countRegisterCourse($studentId);
        $totalSubjectsInFaculty = $student->faculty->subjects()->count();

        return $count !== null && $count >= $totalSubjectsInFaculty;
    }

    public function savePoints($studentId, $subjectIds, $points){
        $student = $this->findOrFail($studentId);
        $data = [];

        foreach ($subjectIds as $index => $subjectId) {
            $data[$subjectId] = [
                'point' => $points[$index],
                'faculty_id' => $student->faculty_id,
                'updated_at' => now(),
            ];
        }

        // Sử dụng sync để đồng bộ dữ liệu
        $student->subjects()->syncWithoutDetaching($data);
    }

}
