<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['layouts.dashboard','dashboard.profile'],'App\Http\View\Composer\UserComposer'
        );
<<<<<<< Updated upstream
//        View::share('user', Auth::user());
=======
        View::composer(
            ['subject.create','subject.edit','student.create','student.edit'], 'App\Http\View\Composer\FacultyComposer'
        );
//        View::share('student', Auth::student());
>>>>>>> Stashed changes
    }
}
