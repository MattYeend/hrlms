<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Models\User;

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
                return \App\Models\Department::onlyTrashed()->exists();
            },
            'hasArchivedCompanies' => function () {
                // Check if there's at least one archived company
                return \App\Models\Company::onlyTrashed()->exists();
            },
        ]);
    }
}
