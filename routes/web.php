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

Route::group(['prefix' => 'request/familysurvey', 'middleware' => ['throttle:500,1']], function () {
    Route::get('/dashboard/get', [\App\Http\Controllers\Api\DashboardController::class, 'index']);
});

/* permission */
Route::post('/users/updatePermissions', [\App\Http\Controllers\Api\UserController::class, 'updatePermissions']);

Route::group(['middleware' => ['permission:Access-Page-Dashboard']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});

/* User Page */

Route::group(['prefix' => 'user', 'middleware' => ['permission:Access-Page-User', 'throttle:500,1']], function () {

    /* index */
    Route::get('/', function () {
        return Inertia::render('User/Index');
    })->middleware(['auth', 'verified'])->name('user');

    Route::get('/create', function () {
        return Inertia::render('User/Create');
    })->middleware(['auth', 'verified'])->name('user-create');

    /* edit */
    Route::get('/edit/{id}',   [App\Http\Controllers\UserController::class, 'handleEdit'])->middleware(['auth', 'verified'])->name('user-edit');

    /* changepassword */
    Route::get('/change-password/{id}', function () {
        return Inertia::render('User/ChangePassword');
    })->middleware(['auth', 'verified'])->name('user-change-password');

    /* admin reset password */
    Route::get('/reset-password/{id}', function () {
        return Inertia::render('User/ResetPassword');
    })->middleware(['auth', 'verified'])->name('user-reset-password');
});

Route::group(['prefix' => 'users', 'middleware' => ['permission:Access-Page-User', 'throttle:500,1']], function () {
    Route::post('/fetch', [\App\Http\Controllers\Api\UserController::class, 'fetch']);
    Route::post('/export', [\App\Http\Controllers\Api\UserController::class, 'exportdata']);
    Route::delete('/delete/{id}/{user_id}', [\App\Http\Controllers\Api\UserController::class, 'delete_user']);
    Route::get('/{id}', [\App\Http\Controllers\Api\UserController::class, 'index_user']);

    Route::put('/changepassword/{id}', [\App\Http\Controllers\Api\UserController::class, 'change_password']);
    Route::put('/resetpassword/{id}', [\App\Http\Controllers\Api\UserController::class, 'reset_password']);

});

/* User Page */
Route::group(['prefix' => 'logs', 'middleware' => 'throttle:500,1'], function () {
    /* index */
    Route::name('logs')->get('/', function () {
        return Inertia::render('Logs/Index');
    })->middleware(['auth', 'verified']);
});

Route::group(['middleware' => ['permission:Action Settings Roles', 'throttle:500,1']], function () {
    Route::get('/roles', function () {
        return Inertia::render('Roles');
    })->middleware(['auth', 'verified'])->name('roles');
});

Route::group(['prefix' => 'cstm', 'middleware' => 'throttle:500,1'], function () {
    /* roles */
    Route::get('roles', [\App\Http\Controllers\Api\RoleController::class, 'index']);

    /* users */
    Route::get('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'index_user']);

    Route::delete('/users/{id}/{user_id}', [\App\Http\Controllers\Api\UserController::class, 'delete_user']);

    /* dashboard */
    Route::get('/dashboard', [\App\Http\Controllers\Api\DashboardController::class, 'index']);

    /* logs */
    Route::post('/logs/search', [\App\Http\Controllers\Api\LogsController::class, 'search']);
    Route::post('/logs/fetch', [\App\Http\Controllers\Api\LogsController::class, 'fetch']);

    Route::get('/roles', [\App\Http\Controllers\Api\RoleController::class, 'index_edit']);
    Route::get('/roles/user_edit', [\App\Http\Controllers\Api\RoleController::class, 'index_user_edit']);
    Route::post('/roles/update_all', [\App\Http\Controllers\Api\RoleController::class, 'update_all']);
});


/* Msc */
Route::get('phpinfo', function () {
    echo phpinfo();
});


require __DIR__ . '/auth.php';
