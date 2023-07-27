<?php

namespace App\Http\Services;

use App\Http\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileService
{

    protected $profileRepository;
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function information(){
        return view('dashboard.profile');
    }

    public function uploadAvatar(Request $request, $id){
        $record = $this->profileRepository->findById($id);
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            // Nếu có ảnh mới thay vào, xóa ảnh cũ (nếu có)
            if ($record->image) {
                Storage::delete('public/images/user/' . $record->image);
            }

            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/user', $imageName);
            $data['avatar'] = $imageName;
        } else {
            // Nếu không có ảnh mới thay vào, giữ nguyên ảnh cũ
            $data['avatar'] = $record->image;
        }
        return $this->profileRepository->uploadAvatar($data, $id);
    }
}
