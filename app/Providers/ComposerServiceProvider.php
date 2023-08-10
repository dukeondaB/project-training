<?php

namespace App\Providers;

use App\Http\View\Composer\StudentRegistrationComposer;
use App\Models\StudentSubject;
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
            ['subject.create','subject.edit','student.create','student.edit','student.list'], 'App\Http\View\Composer\FacultyComposer'
        );
    }
}
