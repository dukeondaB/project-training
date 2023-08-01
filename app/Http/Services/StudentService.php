<?php

namespace App\Http\Services;

use App\Http\Repositories\SubjectRepository;
use App\Http\Repositories\StudentSubjectRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\Student\CreateStudentRequest;
use App\Http\Requests\Student\UpdateStudenttRequest;
use App\Jobs\SendMailForDues;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StudentService
{

    protected $studentRepository;
    protected $subjectRepository;
    /**
     * @var StudentSubjectRepository
     */
    protected $userCourseRepository;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(StudentRepository $studentRepository, SubjectRepository $subjectRepository, StudentSubjectRepository $userCourseRepository, UserRepository $userRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->userCourseRepository = $userCourseRepository;
        $this->userRepository = $userRepository;
    }

    public function getList()
    {
        $data = $this->studentRepository->getList();
        dd($data);
        return view('student.list', ['data' => $data]);
    }

    public function getForm()
    {
        return view('student.create');
    }

    public function save(CreateStudentRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make('000000');
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/student', $imageName);
            $data['avatar'] = $imageName;
        }
        $this->studentRepository->save($data);

//        dispatch(new SendMailForDues($data));
        Mail::to($data['email'])->send(new SendMail($data));

        return redirect()->route('student.index')->with('success', __('Student created successfully'));
    }

    public function delete($id)
    {
        try {
            $this->studentRepository->delete($id);
            $userId = $this->studentRepository->findByUserId($id);
            $this->userRepository->delete($userId);
            return redirect()->back()->with('success', __('Student deleted successfully'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', __('An error occurred while deleting'));
        }
    }

    public function getById($id)
    {
        $data = $this->studentRepository->findById($id);
        return view('student.edit', ['data' => $data]);
    }

    public function update(UpdateStudenttRequest $request, $id)
    {
        $record = $this->studentRepository->findById($id);
        $data = $request->all();
//        dd($data);

        if ($request->hasFile('avatar')) {
            // Nếu có ảnh mới thay vào, xóa ảnh cũ (nếu có)
            if ($record->image) {
                Storage::delete('public/images/student/' . $record->image);
            }

            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/student', $imageName);
            $data['avatar'] = $imageName;
        } else {
            // Nếu không có ảnh mới thay vào, giữ nguyên ảnh cũ
            $data['avatar'] = $record->image;
        }
        $this->studentRepository->update($data, $id);

        return redirect()->route('student.index')->with('success', __('Student update successfully'));
    }

    public function getUsersByAgeRange($request)
    {
        $minAge = $request->input('minAge');
        $maxAge = $request->input('maxAge');

        // Kiểm tra nếu minAge và maxAge đều được cung cấp
        $data = $this->studentRepository->sortByAge($minAge, $maxAge);
//        dd($data);
        return view('student.list', ['data' => $data])->with(['countRegisterCourse' => $this->studentRepository]);
    }

    public function getPageAddScore($studentId){
        $student = $this->studentRepository->findById($studentId);
        $data = $this->studentRepository->listScoreStudent($studentId);
        $subjectRepository = $this->subjectRepository;
//        dd($data, $student);
        return view('dashboard.addscore',['data' => $data, 'student' => $student, 'subjectRepository' => $subjectRepository]);
    }

    public function updatePoint(Request $request, $studentId, $subjectId){
        $data['point'] = $request->input('point');
        $this->userCourseRepository->updatePoint($studentId, $subjectId, $data);
        return redirect()->back()->with(['success','Success']);
    }

    public function showStudentIsNotRegister(){

    }


}
