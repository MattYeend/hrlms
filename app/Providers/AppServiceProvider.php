<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Department;
use App\Models\LearningProvider;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Empty Comment
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'auth' => fn () => $this->authData(),
            'archivedUsers' => fn () => $this->hasArchivedUsers(),
            'archivedDepts' => fn () => $this->hasArchivedDepartments(),
            'archivedJobs' => fn () => $this->hasArchivedJobs(),
            'archivedBlogs' => fn () => $this->hasArchivedBlogs(),
            'deniedBlogs' => fn () => $this->hasDeniedBlogs(),
            'approvedBlogs' => fn() => $this->hasApprovedBlogs(),
            'pendingBlogs' => fn() => $this->hasPendingBlogs(),
            'archivedLearningProviders' => function () {
                return $this->hasArchivedLearningProviders();
            },
            'isCSuiteOrHrStaff' => fn () => $this->isHighLevelOrHrStaff(),
        ]);
    }

    protected function hasArchivedUsers(): bool
    {
        return User::onlyTrashed()->exists();
    }

    protected function hasArchivedDepartments(): bool
    {
        return Department::onlyTrashed()->exists();
    }

    protected function hasArchivedJobs(): bool
    {
        return UserJob::onlyTrashed()->exists();
    }

    protected function hasArchivedBlogs(): bool
    {
        return Blog::onlyTrashed()->exists();
    }

    protected function hasDeniedBlogs(): bool
    {
        return Blog::where('denied', true)->where('approved', false)->exists();
    }

    protected function hasApprovedBlogs(): bool
    {
        return Blog::where('denied', false)->where('approved', true)->exists();
    }

    protected function hasPendingBlogs(): bool
    {
        return Blog::where('denied', false)->where('approved', false)->exists();
    }

    protected function hasArchivedLearningProviders(): bool
    {
        return LearningProvider::onlyTrashed()->exists();
    }

    protected function isHighLevelOrHrStaff(): bool
    {
        /**
         * @var \App\Models\User|null $user
         */
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->isHighLevelStaff() || $user->isHRStaff();
    }

    private function authData(): ?array
    {
        if (! Auth::check()) {
            return null;
        }

        $user = Auth::user();

        return [
            'user' => [
                'id' => $user->id,
                'role_id' => $user->role_id,
                'name' => $user->name,
            ],
        ];
    }
}
