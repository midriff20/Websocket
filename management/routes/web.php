<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AjaxController;

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
Route::get('date',function(){
    return view('date');
});
Route::get('/', function () {
    return view('welcome');
});

// ----Registration
Route::get('login',[TaskController::class,'index']);
Route::post('register',[TaskController::class,'store'])->name('post.register');
// --User login
Route::get('user-login',[TaskController::class,'login'])->name('user.login');
Route::post('check-login/',[TaskController::class,'loginForm'])->name('post.login');
// ---Forgot password
Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password/', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// --------------task
Route::get('/taskurl',[TaskController::class,'TaskUrl'])->name("taskurl");
Route::get('task',[TaskController::class,'task'])->name('task');
Route::post('task-post',[TaskController::class,'taskStore'])->name('task.store');
Route::get('delete/{id}',[TaskController::class,'delete'])->name('delete');
Route::get('edit/{id}',[TaskController::class,'edit'])->name('edit');
Route::post('update/{id}',[TaskController::class,'update'])->name('update');


// ------------Ajax routes--------------
Route::get('employee', function () {
    return view('ajax');
});
Route::post('employee-add', [AjaxController::class, 'employee_add']);
Route::get('employee-view', [AjaxController::class, 'employee_view']);
Route::get('employee-delete', [AjaxController::class, 'employee_delete']);
Route::post('employee-edit', [AjaxController::class, 'employee_edit']);
Route::get('employee-list', [AjaxController::class, 'employee_list']);


// ------------------------admn
Route::get('showall',[TaskController::class,'showAll'])->name('showall');
Route::post('admin-post',[TaskController::class,'adminStore'])->name('admin.store');
Route::get('admindel/{id}',[TaskController::class,'adminDel'])->name('admindel');
Route::get('adminedit/{id}',[TaskController::class,'adminEdit'])->name('adminedit');
Route::post('adminupdate/{id}',[TaskController::class,'adminUpdate'])->name('adminupdate');

// --------------status active - inactive----------------
Route::post('/status/{id}',[TaskController::class,'status'])->name('status');