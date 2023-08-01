<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\CreateSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Services\SubjectService;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentPointsImport;


class SubjectController extends Controller
{

    protected $subjectService;
    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->subjectService->getForm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSubjectRequest $request)
    {
        return $this->subjectService->save($request);
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
        return $this->subjectService->getById($id);
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
        return $this->subjectService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->subjectService->delete($id);
        return redirect()->back();
    }


    /**
     * @param int $subject_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(int $subject_id)
    {
        $this->subjectService->register($subject_id);
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