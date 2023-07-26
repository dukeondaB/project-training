<?php

namespace App\Http\Services;

use App\Http\Repositories\ProfileRepository;

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
}
