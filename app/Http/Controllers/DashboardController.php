<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $companyCount = Company::withoutTrashed()->count();
        $departmentCount = Department::withoutTrashed()->count();
        $userCount = User::withoutTrashed()->count();
        $archivedCompanyCount = Company::onlyTrashed()->count();
        $archivedDepartmentCount = Department::onlyTrashed()->count();
        $archivedUserCount = User::onlyTrashed()->count();

        $data = [
            'companyCount' => $companyCount,
            'departmentCount' => $departmentCount,
            'userCount' => $userCount,
            'archivedCompanyCount' => $archivedCompanyCount,
            'archivedDepartmentCount' => $archivedDepartmentCount,
            'archivedUserCount' => $archivedUserCount,
        ];

        return Inertia::render('Dashboard', [
            'data' => $data,
        ]);
    }
}
