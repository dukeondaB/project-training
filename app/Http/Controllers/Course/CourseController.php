<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
<<<<<<< Updated upstream:app/Http/Controllers/Course/CourseController.php
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\course\UpdateCourseRequest;
use App\Http\Services\CourseService;
=======
use App\Http\Requests\Subject\CreateSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Services\SubjectService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentPointsImport;

>>>>>>> Stashed changes:app/Http/Controllers/Subject/SubjectController.php

class CourseController extends Controller
{

    protected $courseService;
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->courseService->getForm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCourseRequest $request)
    {
        return $this->courseService->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->courseService->getById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCourseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        return $this->courseService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->courseService->delete($id);
        return redirect()->back();
    }


    /**
     * @param int $subject_id
     * @return \Illuminate\Http\RedirectResponse
     */
<<<<<<< Updated upstream:app/Http/Controllers/Course/CourseController.php
    public function register($course_id)
=======
    public function register(int $subject_id)
>>>>>>> Stashed changes:app/Http/Controllers/Subject/SubjectController.php
    {
        $this->courseService->register($course_id);
        return redirect()->back();
    }

    public function import(Request $request){
        $request->validate([
            'import_file' => 'required|mimes:xls,xlsx,csv'
        ]);
        $file = $request->file('import_file');
        try {
            Excel::import(new StudentPointsImport(), $file);

            return redirect()->route('subject-list')->with('success', 'Import thành công!');
        } catch (\Exception $e) {
            return redirect()->route('subject-list')->with('error', 'Đã xảy ra lỗi trong quá trình import: ' . $e->getMessage());
        }

    }
}
