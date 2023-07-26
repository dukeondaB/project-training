<?php

use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Department\GetListDepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    Route::get('change-language/{language}',[UserController::class , 'changeLanguage'])->name('user.change-language');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class)->middleware('can:admin-access');
    Route::post('user/sort-by-age', [UserController::class,'getUsersByAgeRange'])->name('user-sort-by-age');
    Route::resource('profile', ProfileController::class);
    Route::resource('department', DepartmentController::class)->except('index')->middleware('can:admin-access');
    Route::get('department-list', [GetListDepartmentController::class, 'index'])->name('department-list');
    Route::resource('course',CourseController::class)->middleware('can:admin-access');
    Route::get('course-list', [\App\Http\Controllers\Course\GetListCourseController::class, 'index'])->name('course-list');
});


