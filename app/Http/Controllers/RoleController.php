<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Role;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::all()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'slug' => $role->slug,
                'description' => $role->description,
                'is_default' => $role->is_default,
            ];
        });

        Log::log(Log::ACTION_VIEW_ROLES, ['Viewed all roles'], auth()->id());

        return Inertia::render('roles/Index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);

        Log::log(Log::ACTION_SHOW_ROLE, [
            'id' => $role->id,
            'name' => $role->name,
            'slug' => $role->slug,
            'description' => $role->description,
        ], auth()->id());

        return Inertia::render('roles/Show', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'slug' => $role->slug,
                'description' => $role->description,
                'is_default' => $role->is_default,
            ],
        ]);
    }
}
