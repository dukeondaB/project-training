<?php

namespace App\Console\Commands;

use App\Jobs\CalculateAveragePoint;
use App\Models\Student;
use Illuminate\Console\Command;

class CalculateAveragePointCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:average_point';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate average point for students who have registered all subjects';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $students = Student::where('status', 'enrolled')->get();
        foreach ($students as $student) {
            $registeredSubjectsCount = $student->registeredSubjectsCount();
            if ($registeredSubjectsCount == $student->faculty->subjects()->count()) { // Đã đăng ký đủ môn học
                $totalScore = 0;
                $hasMissingScore = false; // Biến kiểm tra xem có môn học nào thiếu điểm không

                foreach ($student->subjects as $subject) {
                    $score = $subject->pivot->point;
                    if ($score === null) {
                        $hasMissingScore = true;
                        break; // Nếu có môn học thiếu điểm, thoát vòng lặp và không tính điểm trung bình
                    }
                    $totalScore += $score;
                }

                if (!$hasMissingScore) {
                    $averageScore = $totalScore / $student->subjects->count();
                    $data = [
                        'total_point' => $averageScore // Mảng dữ liệu để cập nhật điểm trung bình
                    ];
                    $student->update($data); // Cập nhật điểm trung bình cho sinh viên
                }
            }
        }
//        dispatch(new CalculateAveragePoint());
        $this->info('Average points calculated and updated for eligible students.');
    }
}
