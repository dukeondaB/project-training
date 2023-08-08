<?php

namespace App\Http\Repositories;

use App\Models\Faculty;

class FacultyRepository extends BaseRepository
{
    public function __construct(Faculty $faculty)
    {
        parent::__construct($faculty);
    }

}
