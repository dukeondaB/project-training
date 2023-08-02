<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;

class UpdateStudentStatusCommand extends Command
{
    protected $signature = 'update:student_status';
    protected $description = 'Update status of students with total_point < 5';

    public function handle()
    {
        // Lấy danh sách sinh viên có total_point < 5
        $students = Student::where('total_point', '<', 5)->get();

        foreach ($students as $student) {
            if ($student->status === Student::STATUS_ENROLLED) {
                // Nếu trạng thái đang học và điểm < 5, đổi thành buộc thôi học
                $student->status = Student::STATUS_DROPPED;
                $student->save();

                // Gửi email thông báo
                $this->sendNotification($student->user->name, $student->user->email, $student->total_point);
            }
        }

        $this->info('Student status updated for eligible students.');
    }

    private function sendNotification($studentName, $email, $totalPoint)
    {
        // Gửi email thông báo đến sinh viên
        \Mail::to($email)->send(new \App\Mail\SendNotiStatus($studentName, $totalPoint));
    }

}
