<?php

namespace App\Jobs;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateAveragePoint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $students = Student::all();

        foreach ($students as $student) {
            $registeredSubjectsCount = $student->countRegisteredSubjects();

            if ($registeredSubjectsCount == $student->faculty->subjects()->count()) {
                $totalScore = 0;
                foreach ($student->subjects as $subject) {
                    $totalScore += $subject->pivot->point;
                }
                $averageScore = $totalScore / $student->subjects->count();

                $student->total_point = $averageScore; // Cập nhật điểm trung bình cho sinh viên
                $student->save();
            }
        }
    }

}
