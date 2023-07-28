<?php

namespace App\Http\Services;

use App\Http\Repositories\CourseRepository;
use App\Http\Repositories\UserCourseRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Jobs\SendMailForDues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{

    protected $userRepository;
    protected $courseRepository;
    /**
     * @var UserCourseRepository
     */
    protected $userCourseRepository;

    public function __construct(UserRepository $userRepository, CourseRepository $courseRepository, UserCourseRepository $userCourseRepository)
    {
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->userCourseRepository = $userCourseRepository;
    }

    public function getList()
    {
        $data = $this->userRepository->getList();
//        dd($data);
        return view('user.list', ['data' => $data]);
    }

    public function getForm()
    {
        return view('user.create');
    }

    public function save(CreateUserRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/user', $imageName);
            $data['avatar'] = $imageName;
        }
        $data['student_code'] = 'sv' . rand(0, 10000);
        $data['password'] = Hash::make('000000');
        $this->userRepository->save($data);

        dispatch(new SendMailForDues($data));
//        Mail::to($data['email'])->send(new SendMail($data));

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function delete($id)
    {
        try {
            $this->userRepository->delete($id);

            return redirect()->back()->with('success', 'deleted');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred while deleting user.');
        }
    }

    public function getById($id)
    {
        $data = $this->userRepository->findById($id);
        return view('user.edit', ['data' => $data]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $record = $this->userRepository->findById($id);
        $data = $request->all();
//        dd($data);

        if ($request->hasFile('avatar')) {
            // Nếu có ảnh mới thay vào, xóa ảnh cũ (nếu có)
            if ($record->image) {
                Storage::delete('public/images/user/' . $record->image);
            }

            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/user', $imageName);
            $data['avatar'] = $imageName;
        } else {
            // Nếu không có ảnh mới thay vào, giữ nguyên ảnh cũ
            $data['avatar'] = $record->image;
        }
        $this->userRepository->update($data, $id);
        return redirect()->route('user.index')->with('success', 'User update successfully');
    }

    public function getUsersByAgeRange($request)
    {
        $minAge = $request->input('minAge');
        $maxAge = $request->input('maxAge');

        // Kiểm tra nếu minAge và maxAge đều được cung cấp
        $data = $this->userRepository->sortByAge($minAge, $maxAge);
        return view('user.list', ['data' => $data])->with(['countRegisterCourse' => $this->userRepository]);
    }

    public function getPageAddScore($userId){
        $student = $this->userRepository->findById($userId);
        $data = $this->userRepository->listScoreStudent($userId);
        $courseRepository = $this->courseRepository;
//        dd($data);
        return view('dashboard.addscore',['data' => $data, 'student' => $student, 'courseRepository' => $courseRepository]);
    }

    public function updateScore(Request $request, $userId, $courseId){
        $data['score'] = $request->input('score');
        $this->userCourseRepository->updateScore($userId, $courseId, $data);
        return redirect()->back()->with(['success','Success']);
    }

    public function showStudentIsNotRegister(){

    }


}
