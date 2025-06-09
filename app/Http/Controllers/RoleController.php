<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RoleLogger;
use Inertia\Inertia;

class RoleController extends Controller
{
    protected RoleLogger $logger;

    /**
     * Create a new controller instance.
     */
    public function __construct(RoleLogger $logger)
    {
        $this->authorizeResource(Role::class, 'role');
        $this->logger = $logger;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::paginate(10)->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'slug' => $role->slug,
                'description' => $role->description,
                'is_default' => $role->is_default,
            ];
        });

        $this->logger->index(auth()->id());

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

        $this->logger->show($role, auth()->id());

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
