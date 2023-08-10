<?php

use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Faculty\FacultyController;
use App\Http\Controllers\Faculty\GetListFacultyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Subject\GetListSubjectController;

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

Auth::routes(['register' => false]);
Route::group(['middleware' => ['auth','locale']], function () {
//    xếp các đối tượng số nhiều, gần nhau group lại
    Route::get('change-language/{language}',[StudentController::class , 'changeLanguage'])->name('student.change-language');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('profiles', ProfileController::class)->only(['index','update']);
    Route::resource('faculty', FacultyController::class)->except('index');
    Route::get('faculties', [GetListFacultyController::class, 'index'])->name('faculty.index');
    Route::resource('subject',SubjectController::class)->except('index');
    Route::get('subjects', [GetListSubjectController::class, 'index'])->name('subject.index');
    Route::post('subject/register/{subject_id}',[SubjectController::class, 'register'])->name('subject.register');
    Route::get('student/{student_id}/list-subject', [StudentController::class, 'getPageAddScore'])->name('student.subject-list');
    Route::put('update-point/{student_id}/{subject_id}', [StudentController::class, 'updatePoint'])->name('student.update-point');
    Route::post('save-points', [StudentController::class, 'savePoints'])->name('student.save-points');
    Route::post('subject/import', [SubjectController::class, 'import'])->name('student-subject.import');
    Route::post('send-notification/{studentId}',[StudentController::class, 'sendEmailNotification'])->name('send-notification');
});
