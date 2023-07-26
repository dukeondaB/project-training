<?php

namespace App\Http\View\Composer;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserComposer
{
    /**
     *
     * @param View $view
     * @return void
     */

    public function compose(View $view)
    {
        $view->with('user', Auth::user());
    }

}
