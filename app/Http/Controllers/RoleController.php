<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RoleLogger;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Declare a protected propert to hold the
     * RoleLogger instance.
     */
    protected RoleLogger $logger;

    /**
     * Constructor for the controller
     *
     * @param RoleLogger $logger
     * An instance of the RoleLogger used for logging
     * user-related activities
     */
    public function __construct(RoleLogger $logger)
    {
        $this->authorizeResource(Role::class, 'role');
        $this->logger = $logger;
    }

    /**
     * Display a list of all roles.
     *
     * @return \Inertia\Response
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

        $this->logger->index(auth()->id());

        return Inertia::render('roles/Index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Display a single role's details.
     *
     * @param Role $role
     *
     * @return \Inertia\Response
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
