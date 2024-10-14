<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CronjobPermissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/get-data-role', [RoleController::class, 'data'])->name('role.data');

Route::prefix('cronjob')->group(function () {
    Route::get('/template-permission', [CronjobPermissionController::class, 'templateTambahPermissionKeRole']);
    Route::get('/assign-all-role-superadmin', [CronjobPermissionController::class, 'updatePermissionSuperadmin']);
});

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('frontend.auth.login');
    });
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login-post', [AuthController::class, 'login'])->name('login.post');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('setting')->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('role', RoleController::class);
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.aktivitas.index');
    });


    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-password', [ProfileController::class, 'update'])->name('profile.updatePassword');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});