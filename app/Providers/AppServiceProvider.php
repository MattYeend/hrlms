<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
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
            'auth' => function () {
                return [
                    'user' => Auth::user() ? [
                        'id' => Auth::id(),
                        'role_id' => Auth::user()->role_id,
                        'name' => Auth::user()->name,
                    ] : null,
                ];
            },
            'hasArchivedUsers' => function () {
                // Check if there's at least one archived user
                return User::onlyTrashed()->exists();
            },
            'hasArchivedDepartments' => function () {
                // Check if there's at least one archived department
                return Department::onlyTrashed()->exists();
            },
            'hasArchivedCompanies' => function () {
                // Check if there's at least one archived company
                return Company::onlyTrashed()->exists();
            },
        ]);
    }
}
