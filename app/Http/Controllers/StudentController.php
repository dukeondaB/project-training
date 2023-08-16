<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->studentService->filterByDateOfBirthAndPoint($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->studentService->getForm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        return $this->studentService->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->studentService->getById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudentRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        return $this->studentService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->studentService->delete($id);
    }

//    public function getUsersByAgeRange(Request $request)
//    {
////        dd($request);
//        return $this->userService->getUsersByAgeRange($request);
//    }

    public function changeLanguage($language)
    {
        \Session::put('website_language', $language);

        return redirect()->back()->with(['success', 'Change language successfully']);
    }

    public function getPageAddScore($studentId)
    {
        return $this->studentService->getPageAddScore($studentId);
    }

    public function updatePoint(Request $request, $studentId, $subjectId)
    {
        return $this->studentService->updatePoint($request, $studentId, $subjectId);
    }

    public function sendEmailNotification($studentId)
    {
        return $this->studentService->sendEmailNotification($studentId);
    }

    public function getPageSavePoints($studentId)
    {
        return $this->studentService->getPageAddPoint($studentId);
    }

    public function savePoints(Request $request)
    {
        return $this->studentService->savePoints($request);
    }
}
