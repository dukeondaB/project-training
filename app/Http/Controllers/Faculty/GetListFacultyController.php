<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Http\Services\FacultyService;
use Illuminate\Http\Request;

class GetListFacultyController extends Controller
{
    protected $facultyService;

    public function __construct(FacultyService $facultyService)
    {
        $this->facultyService = $facultyService;
    }

    public function index(){
        return $this->facultyService->showAll();
    }
}
