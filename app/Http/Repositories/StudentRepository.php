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

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function getList()
    {
        return $this->model->paginate(10);
    }

    public function save($data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
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
        $query = $this->model;

//        dd($countRegister);
        if ($minAge !== null && $maxAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, datebirth, NOW()) BETWEEN ? AND ?', [$minAge, $maxAge])->paginate(1)->withQueryString();
        } elseif ($minAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, datebirth, NOW()) >= ?', [$minAge])->paginate(1)->withQueryString();
        } elseif ($maxAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, datebirth, NOW()) <= ?', [$maxAge])->paginate(1)->withQueryString();
        } else {
            return $query->paginate(10);
        }
    }

    public function countRegisterCourse($userId)
    {
        $count = DB::table('user_course')->where('user_id', $userId)->count();
        if ($count){
            return $count;
        }

        return null;
    }

    public function listScoreStudent($userId){
//        $user = $this->findById($userId);
        $userWithCourses = $this->model->with('courses')->where('id',$userId)->get();
        $user = $this->findById($userId);
        $courses = $user->courses;
        return $courses;
    }
}
