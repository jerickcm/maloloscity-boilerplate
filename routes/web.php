<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::group(['prefix' => 'dashboard', 'middleware' => ['permission:Access-Page-Dashboard']], function () {
    
    Route::name('dashboard')->get('/', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified']);

    /* api */
    Route::name('dashboard-data')->get('/get', [\App\Http\Controllers\Api\DashboardController::class, 'index']);
});

/* User Page */
Route::group(['prefix' => 'users', 'middleware' => ['permission:Access-Page-User', 'throttle:500,1']], function () {

    /* index */
    Route::name('user')->get('/', function () {
        return Inertia::render('User/Index');
    })->middleware(['auth', 'verified']);

    Route::name('user-create')->get('/create', function () {
        return Inertia::render('User/Create');
    })->middleware(['auth', 'verified']);

    /* edit */
    Route::name('user-edit')->get('/edit/{id}', [App\Http\Controllers\UserController::class, 'handleEdit'])->middleware(['auth', 'verified']);

    /* changepassword */
    Route::name('user-change-password')->get('/change-password/{id}', function () {
        return Inertia::render('User/ChangePassword');
    })->middleware(['auth', 'verified']);

    /* admin reset password */
    Route::name('user-reset-password')->get('/reset-password/{id}', function () {
        return Inertia::render('User/ResetPassword');
    })->middleware(['auth', 'verified']);

    /* api */
    Route::post('/fetch', [\App\Http\Controllers\Api\UserController::class, 'fetch']);
    Route::post('/export', [\App\Http\Controllers\Api\UserController::class, 'exportdata']);
    Route::delete('/delete/{id}/{user_id}', [\App\Http\Controllers\Api\UserController::class, 'delete_user']);
    Route::get('/{id}', [\App\Http\Controllers\Api\UserController::class, 'index_user']);
    Route::put('/changepassword/{id}', [\App\Http\Controllers\Api\UserController::class, 'change_password']);
    Route::put('/resetpassword/{id}', [\App\Http\Controllers\Api\UserController::class, 'reset_password']);
    Route::post('/updatePermissions', [\App\Http\Controllers\Api\UserController::class, 'updatePermissions']);
});

Route::group(['prefix' => 'logs', 'middleware' => 'throttle:500,1'], function () {

    Route::name('logs')->get('/', function () {
        return Inertia::render('Logs/Index');
    })->middleware(['auth', 'verified']);

    /* api */
    Route::post('/search', [\App\Http\Controllers\Api\LogsController::class, 'search']);
    Route::post('/fetch', [\App\Http\Controllers\Api\LogsController::class, 'fetch']);
});

Route::group(['prefix' => 'roles', 'middleware' => ['permission:Action Settings Roles', 'throttle:500,1']], function () {

    Route::get('/', function () {
        return Inertia::render('Roles');
    })->middleware(['auth', 'verified'])->name('roles');

    /* api */
    Route::get('/index', [\App\Http\Controllers\Api\RoleController::class, 'index']);
    Route::get('/edit', [\App\Http\Controllers\Api\RoleController::class, 'index_edit']);
    Route::get('/user_edit', [\App\Http\Controllers\Api\RoleController::class, 'index_user_edit']);
    Route::post('/update_all', [\App\Http\Controllers\Api\RoleController::class, 'update_all']);
});

Route::group(['prefix' => 'cstm', 'middleware' => 'throttle:500,1'], function () {
    Route::delete('/users/{id}/{user_id}', [\App\Http\Controllers\Api\UserController::class, 'delete_user']);
});

/* Msc */
Route::get('phpinfo', function () {
    echo phpinfo();
});


require __DIR__ . '/auth.php';
