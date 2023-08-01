<?php

namespace App\Http\View\Composer;

use App\Models\Faculty;
use Illuminate\View\View;

class FacultyComposer
{
    /**
     *
     * @param View $view
     * @return void
     */

    public function compose(View $view)
    {
        $view->with('faculties', Faculty::all());
    }

}
