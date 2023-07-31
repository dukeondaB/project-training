<?php

use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Faculty\FacultyController;
use App\Http\Controllers\Faculty\GetListFacultyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(\route('login'));
});

Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//route admin
Route::group(['middleware' => ['auth','locale']], function () {
    Route::get('change-language/{language}',[StudentController::class , 'changeLanguage'])->name('student.change-language');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('student', StudentController::class);
//    Route::post('student/sort-by-age', [StudentController::class,'getUsersByAgeRange'])->name('student-sort-by-age');
    Route::resource('profile', ProfileController::class);
    Route::resource('faculty', FacultyController::class)->except('index');
    Route::get('faculty-list', [GetListFacultyController::class, 'index'])->name('faculty-list');
    Route::resource('subject',SubjectController::class);
    Route::get('subject-list', [\App\Http\Controllers\Subject\GetListSubjectController::class, 'index'])->name('subject-list');
    Route::post('subject/register/{subject_id}',[SubjectController::class, 'register'])->name('subject-register');
    Route::get('student/{student_id}/list-subject', [StudentController::class, 'getPageAddScore'])->name('list-subject-by-student');
    Route::put('update-point/{student_id}/{subject_id}', [StudentController::class, 'updatePoint'])->name('update-point');

});


