<?php

namespace App\Http\Repositories;

use App\Models\User;

class ProfileRepository extends BaseRepository
{
    protected $studentRepository;

    public function __construct(User $user, StudentRepository $studentRepository)
    {
        parent::__construct($user);
        $this->studentRepository = $studentRepository;
    }
    public function uploadAvatar($request, $id)
    {
        $data = $this->studentRepository->findByUserId($id);

        return $data->update($request);
    }

}
