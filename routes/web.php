<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FullCalenderController;
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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// ( ! auth()->check() )

Route::group(['middleware' => ['auth']], function () {

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('notifications', NotificationController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('comments', CommentController::class);

    Route::resource('tests', TestController::class);

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'update_avatar']);

    Route::get('/configurations', [FunctionController::class, 'ConfigIndex']);
    Route::get('/configurations/edit', [FunctionController::class, 'configEdit']);
    Route::post('/configurations/update', [FunctionController::class, 'configUpdate']);

    Route::get('/users/log/{id}', [UserController::class, 'logUser'])->name('users.log');
    Route::post('/users/trlog/{id}', [UserController::class, 'storelog'])->name('users.stlog');

    Route::post('/tasks/{id}/save', [TaskController::class, 'taskStore']); //->name('tasks.create')
    Route::post('/tasks/{id}/edit', [TaskController::class, 'taskUpdate']);
    Route::post('/tasks/{id}/submit', [TaskController::class, 'taskSubmit']);
    Route::get('/tasksupdate/[{taskid}/{status}', [TaskController::class, 'updateStatus'])->name('taskstatus.update');
    Route::get('/task/details/[{taskid}/{statusTask}]',[TaskController::class, 'detailTask'])->name('task.detail');
    Route::get('/taskdelete/{taskid}', [TaskController::class, 'deleteTask'])->name('taskstatus.delete');

    /** Xử lý người dùng thường */
    Route::get('/home/checkin/{id}', [FunctionController::class, 'logiCheckin']);

    Route::get('/home/checkout/{id}', [FunctionController::class, 'logiCheckout']);

    Route::get('/mark-as-read/{id}', [FunctionController::class, 'markNotification'])->name('markNotification');

    // Route::get('/calendar1', function () {
    //     return view('calendar');
    // });
    Route::get('/calendar', [FullCalenderController::class, 'index']);
    Route::post('/calenderAjax', [FullCalenderController::class, 'ajax']);

    Route::get('/apps-chat', function () {
        return view('apps-chat');
    });

    Route::get('/inbox', function () {
        return view('inbox');
    });
});
