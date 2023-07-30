<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Http\Services\FacultyService;
use Illuminate\Http\Request;

class GetListFacultyController extends Controller
{
    protected $departmentService;

    public function __construct(FacultyService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(){
        return $this->departmentService->showAll();
    }
}
