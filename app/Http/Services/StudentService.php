<?php

namespace App\Http\Services;

use App\Enums\PerPage;
use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\StudentRequest;
use App\Jobs\SendMailForDues;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentService
{

    protected $studentRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(StudentRepository $studentRepository, UserRepository $userRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }

    public function getForm()
    {
        return view('student.form');
    }

    public function save(StudentRequest $request)
    {
        try {
            $data = $request->all();
//                setAttribute
            $data['password'] = Hash::make('000000');
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images/student', $imageName);
                $data['avatar'] = $imageName;
            }

            $user = $this->userRepository->create($data);
            $studentData['user_id'] = $user->id;

            if (isset($data['avatar'])) {
                $studentData['avatar'] = $data['avatar'];
            }

            $user->student()->create($studentData);

            dispatch(new SendMailForDues($data));

            if ($request->ajax()) {
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
        $student = $this->studentRepository->findOrFail($id);
        return view('student.form', compact('student'));
    }

    public function update(StudentRequest $request, $id)
    {
        $student = $this->studentRepository->findOrFail($id);
        $data = $request->all();
        unset($data['avatar']);
        if ($request->hasFile('avatar')) {
            if ($student->image) {
                Storage::delete('public/images/student/' . $student->image);
            }

            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/student', $imageName);
            $data['avatar'] = $imageName;
        }
        $this->studentRepository->update($id, $data);

        return redirect()->route('students.index')->with('success', __('Student update successfully'));
    }

    public function filter($request)
    {
//        $array = $request->all();
//        $minAge = $request->minAge;
//        $maxAge = $request->maxAge;
//        $minPoint = $request->minPoint;
//        $maxPoint = $request->maxPoint;
//        dùng array triuyee
        $data = $this->studentRepository->filter($request->all())
            ->with(['studentSubjects', 'faculty.subjects', 'user'])
            ->paginate(PerPage::TEN)
            ->withQueryString();
        $this->getAvgPointAndTotalSubject($data);

        return view('student.list', ['data' => $data]);
    }

    public function getAvgPointAndTotalSubject($data)
    {
        $avgPointPerStudent = [];

        foreach ($data as $studentData) {
            $studentId = $studentData->id;
            $totalPoints = 0;
            $numSubjects = 0;

            foreach ($studentData->subjects as $subject) {
                $point = $subject->pivot->point;
                if ($point !== null) {
                    $totalPoints += $point;
                    $numSubjects++;
                }
            }

            if ($numSubjects > 0) {
                $averagePoint = $totalPoints / $numSubjects;
                $avgPointPerStudent[$studentId] = $averagePoint;
            }
        }

        foreach ($data as $item) {
            if (isset($avgPointPerStudent[$item->id])) {
                $item->avg_point = $avgPointPerStudent[$item->id];
            } else {
                $item->avg_point = null;
            }

            $item->count = count($item->studentSubjects);

            if ($item->faculty) {
                $item->total_subject = count($item->faculty->subjects);
            } else {
                $item->total_subject = 0;
            }
        }

        return $data;
    }

    public function getPageAddScore($studentId)
    {
        $student = $this->studentRepository->findOrFail($studentId);
        $registeredSubjects = $student->subjects()->pluck('subjects.id')->toArray();
        $subject = Subject::whereIn('id', $registeredSubjects)->get();
        $data = $this->studentRepository->listScoreStudent($studentId);
        $subjectPoints = [];

        foreach ($data as $point) {
            $subjectPoints[$point->id] = $point->pivot->point;
        }

        return view('dashboard.addScore', ['data' => $data, 'subject' => $subject, 'student' => $student, 'subjectPoint' => $subjectPoints]);
    }

    public function points($studentId)
    {
        $student = $this->studentRepository->findOrFail($studentId);
        $registeredSubjects = $student->subjects()->pluck('subjects.id')->toArray();
        $subject = Subject::whereIn('id', $registeredSubjects)->get();
//        dd($subject, $student->studentSubjects);
        return view('student.addPoints', ['subject' => $subject, 'student' => $student]);
    }

    public function updatePoint(Request $request, $studentId, $subjectId)
    {
        $data['point'] = $request->input('point');
        $this->studentRepository->updatePoint($studentId, $subjectId, $data);
        return redirect()->back()->with(['success', 'Success']);
    }

    public function sendEmailNotification($studentId)
    {
        $student = $this->studentRepository->findOrFail($studentId);
        $count = $this->studentRepository->countRegisterCourse($studentId);
//        dùng pivot

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
        $rules = [
            'student_id' => 'required|exists:students,id',
            'subject_id.*' => 'required|exists:subjects,id',
            'point.*' => 'required|numeric|min:0|max:10', // Tùy chỉnh min và max theo yêu cầu của bạn
        ];

        $messages = [
            'student_id.required' => 'The student ID field is required.',
            'student_id.exists' => 'The selected student ID is invalid.',
            'subject_id.*.required' => 'The subject field is required.',
            'subject_id.*.exists' => 'The selected subject is invalid.',
            'point.*.required' => 'The point field is required.',
            'point.*.numeric' => 'The point must be a number.',
            'point.*.min' => 'The point must be at least :min.',
            'point.*.max' => 'The point may not be greater than :max.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $subjectIds = $request->input('subject_id');
        $studentId = $request->input('student_id');
        $points = $request->input('point');

        $student = $this->studentRepository->findOrFail($studentId);
        $data = [];

        foreach ($subjectIds as $index => $subjectId) {
            $data[$subjectId] = [
                'point' => $points[$index],
                'faculty_id' => $student->faculty_id,
                'updated_at' => now(),
            ];
        }

        $this->studentRepository->savePoints($student, $data);

        return redirect()->back();
    }
}
