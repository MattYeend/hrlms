<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Department;
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
            'isCSuiteOrHrStaff' => fn () => $this->isCSuiteOrHrStaff(),
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

    protected function isCSuiteOrHrStaff(): bool
    {
        /**
         * @var \App\Models\User|null $user
         */
        $user = Auth::user();

        if (!$user) {
            return false;
        }
    
        return $user->isCSuiteStaff() || $user->isHRStaff();
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
