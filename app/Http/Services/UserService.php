<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Jobs\SendMailForDues;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserService
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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

    public function save(UserRequest $request)
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

    public function update(UserRequest $request, $id)
    {
        $record = $this->userRepository->findById($id);
        $data = $request->all();

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
        return redirect()->route('user.index')->with('success', 'Department created successfully');
    }

    public function getUsersByAgeRange($request)
    {
        $minAge = $request->input('minAge');
        $maxAge = $request->input('maxAge');

        // Kiểm tra nếu minAge và maxAge đều được cung cấp
        $data = $this->userRepository->sortByAge($minAge, $maxAge);
//        dd($request, $data);
//        dd($data);
        return view('user.list', ['data' => $data]);
    }

}
