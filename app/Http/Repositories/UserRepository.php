<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @var User $model
     */

    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getList()
    {
        return $this->model->where('is_admin', '!=', 'admin')->paginate(10);
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
        $query = $this->model->where('is_admin', 'user');
//        dd($query);
        if ($minAge !== null && $maxAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, datebirth, NOW()) BETWEEN ? AND ?', [$minAge, $maxAge])->paginate(10);
        } elseif ($minAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, datebirth, NOW()) >= ?', [$minAge])->paginate(10);
        } elseif ($maxAge !== null) {
            return $query->whereRaw('TIMESTAMPDIFF(YEAR, datebirth, NOW()) <= ?', [$maxAge])->paginate(10);
        } else {
            return $query->paginate(10);
        }
    }
}
