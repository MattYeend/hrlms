<?php

use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogLikeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LearningProviderController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserJobController;
use App\Models\Blog;
use App\Models\BusinessType;
use App\Models\Department;
use App\Models\LearningProvider;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::bind('blog', function ($value) {
    return Blog::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::bind('businessType', function ($value) {
    return BusinessType::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::bind('department', function ($value) {
    return Department::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::bind('learningProvider', function ($value) {
    return LearningProvider::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::bind('quiz', function ($value) {
    return Quiz::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::bind('job', function ($value) {
    return UserJob::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::bind('user', function ($value) {
    return User::withTrashed()
        ->where('slug', $value)
        ->firstOrFail();
});

Route::get('/', function () {
    // return Inertia::render('Welcome');
    return redirect()->route('login');
})->name('home');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/errors/403', fn () => Inertia::render('errors/403'));
Route::get('/errors/404', fn () => Inertia::render('errors/404'));
Route::get('/errors/419', fn () => Inertia::render('errors/419'));
Route::get('/errors/429', fn () => Inertia::render('errors/429'));
Route::get('/errors/500', fn () => Inertia::render('errors/500'));
Route::get('/errors/503', fn () => Inertia::render('errors/503'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Role routes
    Route::resource('roles', RoleController::class)->only(['index', 'show']);

    // Department routes
    Route::get(
        '/departments/archived',
        [DepartmentController::class, 'archived']
    )->name('departments.archived');
    Route::resource('departments', DepartmentController::class);
    Route::post(
        'departments/{department}/restore',
        [DepartmentController::class, 'restore']
    )->name('departments.restore')
        ->middleware('auth')
        ->scopeBindings();

    // User routes
    Route::get(
        '/users/archived',
        [UserController::class, 'archived']
    )->name('users.archived');
    Route::resource('users', UserController::class);
    Route::post(
        'users/{user}/restore',
        [UserController::class, 'restore']
    )->name('users.restore');

    // Job routes
    Route::get(
        '/jobs/archived',
        [UserJobController::class, 'archived']
    )->name('jobs.archived');
    Route::resource('jobs', UserJobController::class)->parameters([
        'jobs' => 'job',
    ]);
    Route::post(
        'jobs/{job}/restore',
        [UserJobController::class, 'restore']
    )->name('jobs.restore');

    // Blog routes
    Route::post(
        '/blogs/{blog}/like',
        [BlogLikeController::class, 'store']
    )->name('blog-likes.store');
    Route::delete(
        '/blog-likes/{blogLike}',
        [BlogLikeController::class, 'destroy']
    )->name('blog-likes.destroy');
    Route::post(
        '/blogs/{blog}/like-toggle',
        [BlogLikeController::class, 'toggle']
    )->name('blog-likes.toggle');

    Route::get(
        '/blogs/archived',
        [BlogController::class, 'archived']
    )->name('blogs.archived');
    Route::get(
        '/blogs/denied',
        [BlogController::class, 'denied']
    )->name('blogs.denied');
    Route::resource('blogs', BlogController::class);
    Route::post(
        '/blogs/{blog}/approve',
        [BlogController::class, 'approve']
    )->name('blogs.approve');
    Route::post(
        '/blogs/{blog}/deny',
        [BlogController::class, 'deny']
    )->name('blogs.deny');
    Route::post(
        'blogs/{blog}/restore',
        [BlogController::class, 'restore']
    )->name('blogs.restore');

    Route::resource('blogComments', BlogCommentController::class)->only([
        'store', 'update', 'destroy',
    ]);

    // Learning Provider routes
    Route::get(
        '/learningProviders/archived',
        [LearningProviderController::class, 'archived']
    )->name('learningProviders.archived');
    Route::resource('learningProviders', LearningProviderController::class);
    Route::post(
        'learningProviders/{learningProvider}/restore',
        [LearningProviderController::class, 'restore']
    )->name('learningProviders.restore');

    // Quiz routes
    Route::get(
        '/quizzes/archived',
        [QuizController::class, 'archived']
    )->name('quizzes.archived');
    Route::post(
        '/quizzes/{quiz}/complete',
        [QuizController::class, 'complete']
    )->name('quizzes.complete');
    Route::resource('quizzes', QuizController::class);
    Route::post(
        'quizzes/{quiz}/restore',
        [QuizController::class, 'restore']
    )->name('quizzes.restore');
});
