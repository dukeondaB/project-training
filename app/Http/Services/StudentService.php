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
use App\Mail\SendNotification;
use App\Models\Student;
use App\Models\StudentSubject;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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

        dispatch(new SendMailForDues($data));

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

        if ($request->hasFile('avatar')) {
            if ($record->image) {
                Storage::delete('public/images/student/' . $record->image);
            }

            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/student', $imageName);
            $data['avatar'] = $imageName;
        } else {
            $data['avatar'] = $record->image;
        }
        $this->studentRepository->update($data, $id);

        return redirect()->route('student.index')->with('success', __('Student update successfully'));
    }

    public function getUsersByAgeRange($request)
    {
        $minAge = $request->input('minAge');
        $maxAge = $request->input('maxAge');

        $data = $this->studentRepository->sortByAge($minAge, $maxAge);

        return view('student.list', ['data' => $data])->with(['studentRepository' => $this->studentRepository]);
    }

    public function getPageAddScore($studentId){
        $student = $this->studentRepository->findById($studentId);
        $registeredSubjects = $student->subjects()->pluck('subjects.id')->toArray();
        $subject = Subject::whereIn('id', $registeredSubjects)->get();
        $data = $this->studentRepository->listScoreStudent($studentId);
        $subjectRepository = $this->subjectRepository;
        return view('dashboard.addscore',['data' => $data, 'subject' => $subject , 'student' => $student, 'subjectRepository' => $subjectRepository]);
    }

    public function updatePoint(Request $request, $studentId, $subjectId){
        $data['point'] = $request->input('point');
        $this->userCourseRepository->updatePoint($studentId, $subjectId, $data);
        return redirect()->back()->with(['success','Success']);
    }

    public function sendEmailNotification($studentId)
    {
        $student = $this->studentRepository->findById($studentId);
        $count = $this->studentRepository->countRegisterCourse($studentId);

        // Kiểm tra và gửi email nếu cần
        if ($student && $count !== null && $count < $student->faculty->subjects()->count()) {
            $registeredSubjects = $student->subjects()->pluck('subjects.id')->toArray();
            $notRegisteredSubjects = $student->faculty->subjects()->whereNotIn('subjects.id', $registeredSubjects)->get();

            dispatch(new \App\Jobs\SendNotification($student->user->email, $student->user->name, $count, $notRegisteredSubjects));

            return redirect()->back()->with(['success', 'Send email notification successfully']);
        }

        return redirect()->back()->with(['error', 'Send email notification error']);
    }

    public function savePoints(Request $request)
    {
        $subjectIds = $request->input('subject_id');
        $subjectIds = array_filter($subjectIds);
        $studentId = $request->input('student_id');

        $points = $request->input('point');
        $points = array_filter($points);

        $this->studentRepository->savePoints($studentId, $subjectIds, $points);

        return redirect()->back();
    }

}
