<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    Route::post('companies/{company}/restore', [CompanyController::class, 'restore'])
        ->name('companies.restore');
});
