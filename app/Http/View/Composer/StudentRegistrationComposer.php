<?php

namespace App\Http\View\Composer;
use Illuminate\View\View;
use App\Models\Subject;
use App\Models\StudentSubject;
use App\Models\Faculty;

class StudentRegistrationComposer
{
    public function compose(View $view)
    {
        $studentSubjectsCount = StudentSubject::where('student_id', $view->item->id)->count();
        $facultySubjectsCount = $view->item->faculty ? $view->item->faculty->subjects()->count() : 0;

        $view->with([
            'studentSubjectsCount' => $studentSubjectsCount,
            'facultySubjectsCount' => $facultySubjectsCount,
        ]);
    }

}
