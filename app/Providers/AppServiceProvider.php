<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Role;
use App\Models\User;
use App\Policies\CoursePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\JobTitlePolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Registration of Policies.
     */
    protected $policies = [
        Course::class => CoursePolicy::class,
        Department::class => DepartmentPolicy::class,
        JobTitle::class => JobTitlePolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
    ];
}
