<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskGroupsController;
use App\Http\Controllers\TaskLabelsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TaskStatusesController;
use App\Http\Controllers\UsersController;
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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {


        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'auth'])->name('auth');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');


        Route::middleware('auth')->group(function () {

            Route::get('/', [HomeController::class, 'index'])->name('home.index');

            Route::name('users.')->prefix('users')->group(
                function () {
                    //Route::post('/register', [UsersController::class, 'register'])->name('register');
                    Route::get('/{user}', [UsersController::class, 'view'])->name('view');
                    Route::delete('/{user}', [UsersController::class, 'delete'])->name('delete');
                }
            );

            Route::resource('tasks', TasksController::class);
            Route::resource('task-groups', TaskGroupsController::class);
            Route::resource('task-labels', TaskLabelsController::class);

            Route::resource('task-statuses', TaskStatusesController::class);

        });


    }
);
