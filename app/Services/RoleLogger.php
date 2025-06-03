<?php

namespace App\Services;

use App\Models\Log;
use App\Models\Role;

class RoleLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Index method to log viewing all roles.
     */
    public function index(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_ROLES,
            [
                'Viewed all roles',
            ],
            $userId,
        );
    }

    /**
     * Log showing a specific role.
     */
    public function show(Role $role, int $userId): array
    {
        return $this->log(
            Log::ACTION_SHOW_ROLE,
            [
                'id' => $role->id,
                'name' => $role->name,
                'slug' => $role->slug,
            ],
            $userId,
        );
    }

    /**
     * Helper method to log actions.
     */
    private function log(string $action, array $data, int $userId): array
    {
        $log = Log::log($action, $data, $userId);
        return is_array($log) ? $log : [];
    }
}
