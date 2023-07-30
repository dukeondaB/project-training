<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\CreateSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Services\SubjectService;

class SubjectController extends Controller
{

    protected $courseService;
    public function __construct(SubjectService $courseService)
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
    public function store(CreateSubjectRequest $request)
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
     * @param  UpdateSubjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, $id)
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
     * @param int $course_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register($course_id)
    {
        $this->courseService->register($course_id);
        return redirect()->back();
    }
}
