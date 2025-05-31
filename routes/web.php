<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::bind('user', function ($value) {
    return User::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::bind('company', function ($value) {
    return Company::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::bind('department', function ($value) {
    return Department::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::get('/', function () {
    // return Inertia::render('Welcome');
    return redirect()->route('login');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/errors/403', fn () => Inertia::render('errors/403'));
Route::get('/errors/404', fn () => Inertia::render('errors/404'));
Route::get('/errors/419', fn () => Inertia::render('errors/419'));
Route::get('/errors/429', fn () => Inertia::render('errors/429'));
Route::get('/errors/500', fn () => Inertia::render('errors/500'));
Route::get('/errors/503', fn () => Inertia::render('errors/503'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('roles', RoleController::class)->only(['index', 'show']);

    Route::resource('companies', CompanyController::class);
    Route::post(
        'companies/{company}/restore',
        [CompanyController::class, 'restore']
    )->name('companies.restore');

    Route::resource('departments', DepartmentController::class);
    Route::post(
        'departments/{department}/restore',
        [DepartmentController::class, 'restore']
    )->name('departments.restore')
        ->middleware('auth')
        ->scopeBindings();

    Route::get('/users/archived', [UserController::class, 'archived'])->name('users.archived');
    Route::resource('users', UserController::class);
    Route::post(
        'users/{user}/restore',
        [UserController::class, 'restore']
    )->name('users.restore');
});
