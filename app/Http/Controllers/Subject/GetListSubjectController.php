<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Services\SubjectService;
use Illuminate\Http\Request;

class GetListSubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function index(){
        return $this->subjectService->showAll();
    }
}
