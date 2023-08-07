<?php

namespace App\Http\Repositories;

use App\Models\Student;
use App\Models\StudentSubject;
use Illuminate\Support\Facades\Auth;
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

    public function getList()
    {
        return $this->model->with('user')->paginate(10);
    }

    public function save($data)
    {
        // gọi từ userRepo từ service
        $user = $this->userRepository->save($data);
        $studentData = [
            'address' => $data['address'],
            'gender' => $data['gender'],
            'birth_day' => $data['birth_day'],
            'phone' => $data['phone'],
            'avatar' => $data['avatar'],
            'user_id' => $user->id, // Gán user_id từ người dùng vừa được tạo
        ];

        if (isset($data['avatar'])) {
            $studentData['avatar'] = $data['avatar'];
        }

        return $user->student()->create($studentData);;
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByUserId($id){
        return $this->model->where('user_id',$id)->first();
    }

    public function delete($id)
    {
        $data = $this->findById($id);
        return $data->delete();
    }

    public function update($data, $id)
    {
        $item = $this->findById($id);
        return $item->update($data);
    }

    public function filterByDateOfBirthAndPoint($minAge, $maxAge, $minPoint, $maxPoint)
    {
        $query = $this->model->with('user');

        // Chuyển minAge và maxAge thành ngày tháng năm sinh
        $now = now(); // Lấy ngày giờ hiện tại
        $minBirthDate = $now->subYears($maxAge)->format('Y-m-d');
        $maxBirthDate = $now->subYears($minAge)->format('Y-m-d');

        // Kiểm tra và áp dụng điều kiện ngày sinh
        if ($minAge !== null && $maxAge !== null) {
            $query->whereBetween('birth_day', [$minBirthDate, $maxBirthDate]);
        } elseif ($minAge !== null) {
            $query->where('birth_day', '<=', $minBirthDate);
        } elseif ($maxAge !== null) {
            $query->where('birth_day', '>=', $maxBirthDate);
        }

        // Kiểm tra và áp dụng điều kiện điểm số
        if ($minPoint !== null && $maxPoint !== null) {
            $query->whereBetween('total_point', [$minPoint, $maxPoint]);
        } elseif ($minPoint !== null) {
            $query->where('total_point', '>=', $minPoint);
        } elseif ($maxPoint !== null) {
            $query->where('total_point', '<=', $maxPoint);
        }

        return $query->paginate(5)->withQueryString();
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
        $student = $this->findById($userId);
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
        $student = $this->findById($studentId);
        $data = [];
        foreach ($subjectIds as $index => $subjectId) {
            $data[] = [
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'point' => $points[$index],
                'faculty_id' => $student->faculty_id,
                'updated_at' => now(),
            ];
        }
        // sync
        foreach ($data as $record) {
            StudentSubject::updateOrCreate(
                [
                    'student_id' => $record['student_id'],
                    'subject_id' => $record['subject_id'],
                ],
                [
                    'faculty_id' => $record['faculty_id'],
                    'point' => $record['point'],
                    'updated_at' => $record['updated_at'],
                ]
            );
        }
    }

}
