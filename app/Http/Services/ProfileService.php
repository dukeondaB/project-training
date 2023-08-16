<?php

namespace App\Http\Services;

use App\Http\Repositories\ProfileRepository;
use App\Http\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileService
{

    protected $profileRepository;
    /**
     * @var StudentRepository
     */
    protected $studentRepository;

    public function __construct(ProfileRepository $profileRepository, StudentRepository $studentRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->studentRepository = $studentRepository;
    }

    public function information()
    {
        return view('dashboard.profile');
    }

    public function uploadAvatar(Request $request, $id)
    {
        $record = $this->studentRepository->findByUserId($id);
//        dd($record);
//        dd($request->all());
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            // Nếu có ảnh mới thay vào, xóa ảnh cũ (nếu có)
            if ($record->avatar) {
                Storage::delete('public/images/student/' . $record->avatar);
            }

            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/student', $imageName);
            $data['avatar'] = $imageName;
        } else {
            // Nếu không có ảnh mới thay vào, giữ nguyên ảnh cũ
            $data['avatar'] = $record->image;
        }
        return $this->profileRepository->uploadAvatar($data, $id);
    }
}
