<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
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
    /* create */
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


/* User Page */
Route::group(['prefix' => 'logs', 'middleware' => 'throttle:500,1'], function () {
    /* index */
    Route::get('/', function () {
        return Inertia::render('Logs/Index');
    })->middleware(['auth', 'verified'])->name('logs');
});

Route::group(['middleware' => ['permission:Action Settings Roles', 'throttle:500,1']], function () {
    Route::get('/roles', function () {
        return Inertia::render('Roles');
    })->middleware(['auth', 'verified'])->name('roles');
});
/* Msc */
Route::get('phpinfo', function () {
    echo phpinfo();
});

Route::group(['prefix' => 'cstm', 'middleware' => 'throttle:500,1'], function () {
    /* roles */
    Route::get('roles', [\App\Http\Controllers\Api\RoleController::class, 'index']);
    /* checklist */
    Route::get('/checklists', [\App\Http\Controllers\Api\ChecklistController::class, 'fetch']);
    Route::post('/checklists/all', [\App\Http\Controllers\Api\ChecklistController::class, 'update_checkist']);
    /* itineraries */
    Route::post('/itineraries', [\App\Http\Controllers\Api\ItineraryController::class, 'store']);
    Route::post('/itineraries/add_business', [\App\Http\Controllers\Api\ItineraryController::class, 'add_business']);
    Route::post('/itineraries/fetch/{id}', [\App\Http\Controllers\Api\ItineraryController::class, 'fetch']);

    /* users */
    Route::get('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'index_user']);
    Route::put('/users/changepassword/{id}', [\App\Http\Controllers\Api\UserController::class, 'change_password']);
    Route::put('/users/resetpassword/{id}', [\App\Http\Controllers\Api\UserController::class, 'reset_password']);
    Route::delete('/users/{id}/{user_id}', [\App\Http\Controllers\Api\UserController::class, 'delete_user']);
    Route::post('/users/fetch', [\App\Http\Controllers\Api\UserController::class, 'fetch']);

    /* dashboard */
    Route::get('/dashboard', [\App\Http\Controllers\Api\DashboardController::class, 'index']);
    Route::post('/user/export', [\App\Http\Controllers\Api\UserController::class, 'exportdata']);

    /* logs */
    Route::post('/logs/search', [\App\Http\Controllers\Api\LogsController::class, 'search']);
    Route::post('/logs/fetch', [\App\Http\Controllers\Api\LogsController::class, 'fetch']);

    Route::get('/roles', [\App\Http\Controllers\Api\RoleController::class, 'index_edit']);
    Route::get('/roles/user_edit', [\App\Http\Controllers\Api\RoleController::class, 'index_user_edit']);
    Route::post('/roles/update_all', [\App\Http\Controllers\Api\RoleController::class, 'update_all']);
});

require __DIR__ . '/auth.php';
