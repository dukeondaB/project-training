<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Services\SubjectService;
use Illuminate\Http\Request;

class GetListSubjectController extends Controller
{
    protected $courseService;

    public function __construct(SubjectService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(){
        return $this->courseService->showAll();
    }
}
