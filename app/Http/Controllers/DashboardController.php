<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Department;
use App\Models\LearningProvider;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view with all entity statistics.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $data = array_merge(
            $this->blogCounts(),
            $this->departmentCounts(),
            $this->learningPrividerCounts(),
            $this->userCounts()
        );

        return Inertia::render('Dashboard', [
            'data' => $data,
            'authUser' => User::where(
                'id',
                auth()->id()
            )->with('role:id,name')->first(),
        ]);
    }

    /**
     * Get blog-related statistics.
     *
     * @return array
     */
    private function blogCounts()
    {
        $blogCount = Blog::withoutTrashed()->count();
        $archivedBlogCount = Blog::onlyTrashed()->count();
        $approvedBlogCount = Blog::where('denied', false)
            ->where('approved', true)
            ->count();
        $deniedBlogCount = Blog::where('denied', true)
            ->where('approved', false)
            ->count();
        $pendingBlogCount = Blog::where('denied', false)
            ->where('approved', false)
            ->count();

        return [
            'blogCount' => $blogCount,
            'archivedBlogCount' => $archivedBlogCount,
            'approvedBlogCount' => $approvedBlogCount,
            'deniedBlogCount' => $deniedBlogCount,
            'pendingBlogCount' => $pendingBlogCount,
        ];
    }

    /**
     * Get department-related statistics.
     *
     * @return array
     */
    private function departmentCounts()
    {
        $departmentCount = Department::withoutTrashed()->count();
        $archivedDepartmentCount = Department::onlyTrashed()->count();

        return [
            'departmentCount' => $departmentCount,
            'archivedDepartmentCount' => $archivedDepartmentCount,
        ];
    }

    /**
     * Get learning provider-related statistics.
     *
     * @return array
     */
    private function learningPrividerCounts()
    {
        $learningProviderCount = LearningProvider::withoutTrashed()
            ->count();
        $archivedLearningProviderCount = LearningProvider::onlyTrashed()
            ->count();

        return [
            'learningProviderCount' => $learningProviderCount,
            'archivedLearningProviderCount' => $archivedLearningProviderCount,
        ];
    }

    /**
     * Get user-related statistics.
     *
     * @return array
     */
    private function userCounts()
    {
        $userCount = User::withoutTrashed()->count();
        $archivedUserCount = User::onlyTrashed()->count();

        return [
            'userCount' => $userCount,
            'archivedUserCount' => $archivedUserCount,
        ];
    }
}
