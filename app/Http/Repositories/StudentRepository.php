<?php

namespace App\Http\Repositories;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentRepository
{
    /**
     * @var Student $model
     */

    protected $model;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(Student $model, UserRepository $userRepository)
    {
        $this->model = $model;
        $this->userRepository = $userRepository;
    }

    public function getList()
    {
        return $this->model->with('user')->paginate(10);
    }

    public function save($data)
    {
        $user = $this->userRepository->save($data);
        $studentData = [
            'address' => $data['address'],
            'gender' => $data['gender'],
            'birth_day' => $data['birth_day'],
            'phone' => $data['phone'],
            'user_id' => $this->userRepository->model->id, // Gán user_id từ người dùng vừa được tạo
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

    public function sortByAge($minAge, $maxAge)
    {
        $query = $this->model->with('user');
//        dd($query);
//        dd($countRegister);
        if ($minAge !== null && $maxAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_day, NOW()) BETWEEN ? AND ?', [$minAge, $maxAge])->paginate(5)->withQueryString();
        } elseif ($minAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_day, NOW()) >= ?', [$minAge])->paginate(5)->withQueryString();
        } elseif ($maxAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_day, NOW()) <= ?', [$maxAge])->paginate(5)->withQueryString();
        } else {
            return $query->paginate(5);
        }
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
        $studentWithSubject = $student->subjects;

        return $studentWithSubject;
    }
}
