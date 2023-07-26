<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Services\CourseService;
use Illuminate\Http\Request;

class GetListCourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(){
        return $this->courseService->showAll();
    }
}
