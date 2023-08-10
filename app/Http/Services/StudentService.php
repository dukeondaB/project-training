<?php

namespace App\Http\Services;

use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\StudentSubjectRepository;
use App\Http\Repositories\SubjectRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\StudentRequest;
use App\Jobs\SendMailForDues;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
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
    public function getForm()
    {
        return view('student.create');
    }

    public function save(StudentRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = Hash::make('000000');

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images/student', $imageName);
                $data['avatar'] = $imageName;
            }

            $user = $this->userRepository->create($data);

            $studentData = Arr::except($data, ['password', 'email', 'name']);
            $studentData['user_id'] = $user->id;

            if (isset($data['avatar'])) {
                $studentData['avatar'] = $data['avatar'];
            }

            $user->student()->create($studentData);

            dispatch(new SendMailForDues($data));

            if ($request->ajax())
            {
                return response()->json(['success' => ['general' => 'success: ']], 200);
            }

            return redirect()->route('students.index')->with('success', __('Student created successfully'));
        } catch (\Exception $e) {
            return response()->json(['error' => ['general' => 'An error occurred: ' . $e->getMessage()]], 422);
        }
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
        $data = $this->studentRepository->findOrFail($id);
        return view('student.edit', ['data' => $data]);
    }

    public function update(StudentRequest $request, $id)
    {
        $record = $this->studentRepository->findOrFail($id);
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
        $this->studentRepository->update($id, $data);

        return redirect()->route('students.index')->with('success', __('Student update successfully'));
    }

    public function filterByDateOfBirthAndPoint($request)
    {
        // truyền array qua lại
        $minAge = $request->minAge;
        $maxAge = $request->maxAge;
        $minPoint = $request->minPoint;
        $maxPoint = $request->maxPoint;
        $data = $this->studentRepository->filterByDateOfBirthAndPoint($minAge, $maxAge, $minPoint, $maxPoint);
        foreach ($data as $item) {
            $item->count = count($item->studentSubjects);
            $faculty = $item->faculty;

            if ($faculty) {
                $item->total_subject = count($faculty->subjects);
            } else {
                $item->total_subject = 0; // Hoặc giá trị mặc định khác nếu cần
            }
        }
//        dd($data);
        return view('student.list', ['data' => $data]);
    }

    public function getPageAddScore($studentId){
        $student = $this->studentRepository->findOrFail($studentId);
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
        $student = $this->studentRepository->findOrFail($studentId);
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
        //đồng bộ tên gọi giữa biến và
        $points = $request->input('point');
        $points = array_filter($points);
//        dd($points);
        // Tiếp tục xử lý khi dữ liệu hợp lệ
        $this->studentRepository->savePoints($studentId, $subjectIds, $points);

        return redirect()->back();
    }
}
