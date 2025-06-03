<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'name',
        'email',
        'password',
        'slug',
        'first_line',
        'second_line',
        'town',
        'city',
        'county',
        'country',
        'post_code',
        'full_time',
        'part_time',
        'role_id',
        'department_id',
        'job_id',
        'archived',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'restored_by',
        'restored_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Check to see if the user is a super admin.
     * This method checks if the user's role ID matches the super admin role ID.
     *
     * @return bool
     *
     * @see Role for the list of roles and their IDs
     * @see Role::SUPER_ADMIN for the super admin role ID
     */
    public function isSuperAdmin(): bool
    {
        return $this->role_id === Role::SUPER_ADMIN;
    }

    /**
     * Check to see if the user is an admin.
     * This method checks if the user's role ID matches the admin role ID.
     *
     * @return bool
     *
     * @see Role for the list of roles and their IDs
     * @see Role::ADMIN for the admin role ID
     */
    public function isAdmin(): bool
    {
        return $this->role_id === Role::ADMIN;
    }

    /**
     * Check to see if the user is a user.
     * This method checks if the user's role ID matches the user role ID.
     *
     * @return bool
     *
     * @see Role for the list of roles and their IDs
     * @see Role::USER for the user role ID
     */
    public function isUser()
    {
        return $this->role_id === Role::USER;
    }

    /**
     * Get the role that the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Role>
     *
     * @see Role for the list of roles
     * @see Role::class for the Role model
     * @see User::role_id for the foreign key in the users table
     * @see User::belongsTo for the relationship method
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the department that the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Department>
     *
     * @see Department for the list of departments
     * @see Department::class for the Department model
     * @see User::department_id for the foreign key in the users table
     * @see User::belongsTo for the relationship method
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the job that the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<UserJob>
     *
     * @see UserJob for the list of jobs
     * @see UserJob::class for the UserJob model
     * @see User::job_id for the foreign key in the users table
     * @see User::belongsTo for the relationship method
     */
    public function job()
    {
        return $this->belongsTo(UserJob::class, 'job_id');
    }

    /**
     * Get the unique identifier for the user.
     * This method is used by route model binding to
     * retrieve the user by their slug.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Check if the user is part of the C-Suite staff.
     * This includes roles such as CEO, COO, CFO, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of C-Suite roles
     * @see UserJob::cSuiteShortCodes for C-Suite short codes
     */
    public function isCSuiteStaff()
    {
        return $this->job?->isCSuite() ?? false;
    }

    /**
     * Check if the user is part of the HR staff.
     * This includes roles such as HRD, DoP, HRM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of HR roles
     * @see UserJob::hRShortCodes for HR short codes
     */
    public function isHRStaff()
    {
        return $this->job?->isHRDepartment() ?? false;
    }

    /**
     * Check if the user is part of the Finance staff.
     * This includes roles such as FD, DoF, FM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Finance roles
     * @see UserJob::financeShortCodes for Finance short codes
     */
    public function isFinanceStaff()
    {
        return $this->job?->isFinance() ?? false;
    }

    /**
     * Check if the user is part of the IT staff.
     * This includes roles such as ITD, DoIT, ITM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of IT roles
     * @see UserJob::iTShortCodes for IT short codes
     */
    public function isITStaff()
    {
        return $this->job?->isITDepartment() ?? false;
    }

    /**
     * Check if the user is part of the Marketing staff.
     * This includes roles such as MD, DoM, MM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Marketing roles
     * @see UserJob::marketingShortCodes for Marketing short codes
     */
    public function isMarketingStaff()
    {
        return $this->job?->isMarketing() ?? false;
    }

    /**
     * Check if the user is part of the Sales staff.
     * This includes roles such as SD, DoS, SM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Sales roles
     * @see UserJob::salesShortCodes for Sales short codes
     */
    public function isSalesStaff()
    {
        return $this->job?->isSales() ?? false;
    }

    /**
     * Check if the user is part of the Operations staff.
     * This includes roles such as OD, DoO, OM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Operations roles
     * @see UserJob::operationsShortCodes for Operations short codes
     */
    public function isOperationsStaff()
    {
        return $this->job?->isOperations() ?? false;
    }

    /**
     * Check if the user is part of the Customer Service staff.
     * This includes roles such as CSD, DoCS, CM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Customer Service roles
     * @see UserJob::customerServiceShortCodes for Customer Service short codes
     */
    public function isCustomerServiceStaff()
    {
        return $this->job?->isCustomerSupport() ?? false;
    }

    /**
     * Check if the user is part of the Legal staff.
     * This includes roles such as LD, DoL, LM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Legal roles
     * @see UserJob::legalShortCodes Legal short codes
     */
    public function isLegalStaff()
    {
        return $this->job?->isLegal() ?? false;
    }

    /**
     * Check if the user is part of the Administration staff.
     * This includes roles such as AD, DoA, AM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Administration roles
     * @see UserJob::administrationShortCodes for Administration short codes
     */
    public function isAdministrationStaff()
    {
        return $this->job?->isAdministration() ?? false;
    }

    /**
     * Check if the user is part of the Research and Development staff.
     * This includes roles such as RD, DoR, RM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Research and Development roles
     * @see UserJob::researchAndDevelopmentShortCodes
     * for Research and Development short codes
     */
    public function isResearchAndDevelopmentStaff()
    {
        return $this->job?->isResearchAndDevelopment() ?? false;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
