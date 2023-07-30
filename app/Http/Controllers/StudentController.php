<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateStudentRequest;
use App\Http\Requests\Student\UpdateStudenttRequest;
use App\Http\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    protected $userService;

    public function __construct(StudentService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->userService->getUsersByAgeRange($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->userService->getForm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStudentRequest $request)
    {
        return $this->userService->save($request);
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
        return $this->userService->getById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStudenttRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudenttRequest $request, $id)
    {
        $this->userService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->userService->delete($id);
    }

//    public function getUsersByAgeRange(Request $request)
//    {
////        dd($request);
//        return $this->userService->getUsersByAgeRange($request);
//    }

    public function changeLanguage($language){
        \Session::put('website_language', $language);

        return redirect()->back();
    }

    public function getPageAddScore($userId){
        return $this->userService->getPageAddScore($userId);
    }

    public function updateScore(Request $request, $userId, $courseId)
    {
        return $this->userService->updateScore($request,$userId,$courseId);
    }
}
