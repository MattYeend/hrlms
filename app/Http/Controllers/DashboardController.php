<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LearningProvider;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $departmentCount = Department::withoutTrashed()->count();
        $learningProviderCount = LearningProvider::withoutTrashed()->count();
        $userCount = User::withoutTrashed()->count();
        $archivedDepartmentCount = Department::onlyTrashed()->count();
        $archivedLearningProviderCount = LearningProvider::onlyTrashed()->count();
        $archivedUserCount = User::onlyTrashed()->count();

        $data = [
            'departmentCount' => $departmentCount,
            'learningProviderCount' => $learningProviderCount,
            'userCount' => $userCount,
            'archivedDepartmentCount' => $archivedDepartmentCount,
            'archivedLearningProviderCount' => $archivedLearningProviderCount,
            'archivedUserCount' => $archivedUserCount,
        ];

        return Inertia::render('Dashboard', [
            'data' => $data,
            'authUser' => User::where(
                'id',
                auth()->id()
            )->with('role:id,name')->first(),
        ]);
    }
}
