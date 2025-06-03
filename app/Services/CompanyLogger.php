<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Log;

class CompanyLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Index method to log viewing all companies.
     */
    public function index(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_COMPANIES,
            [
                'Viewed all companies',
            ],
            $userId,
        );
    }

    /**
     * Log showing a specific company.
     */
    public function show(Company $company, int $userId): array
    {
        return $this->log(
            Log::ACTION_SHOW_COMPANY,
            [
                'id' => $company->id,
                'name' => $company->name,
                'slug' => $company->slug,
            ],
            $userId,
        );
    }

    /**
     * Log creating a new company.
     */
    public function create(Company $company, int $userId): array
    {
        return $this->log(
            Log::ACTION_CREATE_COMPANY,
            [
                'id' => $company->id,
                'name' => $company->name,
                'slug' => $company->slug,
                'created_by' => $company->created_by,
                'created_at' => $company->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing company.
     */
    public function update(Company $company, int $userId): array
    {
        return $this->log(
            Log::ACTION_UPDATE_COMPANY,
            [
                'id' => $company->id,
                'name' => $company->name,
                'slug' => $company->slug,
                'updated_by' => $company->updated_by,
                'updated_at' => $company->updated_at,
            ],
            $userId,
        );
    }

    /**
     * Log deleting a company.
     */
    public function delete(Company $company, int $userId): array
    {
        return $this->log(
            Log::ACTION_DELETE_COMPANY,
            [
                'id' => $company->id,
                'name' => $company->name,
                'slug' => $company->slug,
                'deleted_by' => $company->deleted_by,
                'deleted_at' => $company->deleted_at,
            ],
            $userId,
        );
    }

    /**
     * Log restoring a company.
     */
    public function restore(Company $company, int $userId): array
    {
        return $this->log(
            Log::ACTION_REINSTATE_COMPANY,
            [
                'id' => $company->id,
                'name' => $company->name,
                'slug' => $company->slug,
                'is_archived' => $company->is_archived,
                'restored_by' => $company->restored_by,
                'restored_at' => $company->restored_at,
            ],
            $userId,
        );
    }

    /**
     * Log viewing archived companies.
     */
    public function archived(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_ARCHIVED_COMPANIES,
            [
                'Viewed archived companies',
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
