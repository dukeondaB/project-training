<?php

use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Department\GetListDepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return redirect(\route('login'));
});

Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//route admin
Route::group(['middleware' => ['auth','locale']], function () {
    Route::get('change-language/{language}',[UserController::class , 'changeLanguage'])->name('user.change-language');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
<<<<<<< Updated upstream
    Route::resource('user', UserController::class)->middleware('can:admin-access');
//    Route::post('user/sort-by-age', [UserController::class,'getUsersByAgeRange'])->name('user-sort-by-age');
    Route::resource('profile', ProfileController::class);
    Route::resource('department', DepartmentController::class)->except('index')->middleware('can:admin-access');
    Route::get('department-list', [GetListDepartmentController::class, 'index'])->name('department-list');
    Route::resource('course',CourseController::class)->middleware('can:admin-access');
    Route::get('course-list', [\App\Http\Controllers\Course\GetListCourseController::class, 'index'])->name('course-list');
    Route::post('course/register/{course_id}',[CourseController::class, 'register'])->name('course-register')->middleware('can:user-access');
    Route::get('user/{user_id}/list-course', [UserController::class, 'getPageAddScore'])->name('list-course-by-user')->middleware('can:admin-access');
    Route::put('update-score/{user_id}/{course_id}', [UserController::class, 'updateScore'])->name('update-score')->middleware('can:admin-access');
=======
    Route::resource('student', StudentController::class);
    Route::resource('profile', ProfileController::class)->only(['index','update']);
    Route::resource('faculty', FacultyController::class)->except('index');
    Route::get('faculty-list', [GetListFacultyController::class, 'index'])->name('faculty-list');
    Route::resource('subject',SubjectController::class);
    Route::get('subject-list', [GetListSubjectController::class, 'index'])->name('subject-list');
    Route::post('subject/register/{subject_id}',[SubjectController::class, 'register'])->name('subject-register');
    Route::get('student/{student_id}/list-subject', [StudentController::class, 'getPageAddScore'])->name('list-subject-by-student');
    Route::put('update-point/{student_id}/{subject_id}', [StudentController::class, 'updatePoint'])->name('update-point');
    Route::post('/subject/import', [SubjectController::class, 'import'])->name('subject-import');

>>>>>>> Stashed changes

});


