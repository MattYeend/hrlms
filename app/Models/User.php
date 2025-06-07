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
        'is_archived',
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
    public function isUser(): bool
    {
        return $this->role_id === Role::USER;
    }

    /**
     * Check to see if the user is Admin or higher.
     *
     * @return bool
     *
     * @see Role for the list of roles and their IDs
     * @see User::isSuperAdmin and User::isAdmin
     */
    public function isAtleastAdmin(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
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
     * Check if the user is part of the Directors staff.
     * This includes roles such as Director of Operations, Director
     * of Finance, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of Director roles
     * @see UserJob::directorShortCodes for Director short codes
     */
    public function isDirectorStaff()
    {
        return $this->job?->isDirector() ?? false;
    }

    /**
     * Check if the user is high level staff.
     * This incluces CSuite and Dircetor staff.
     *
     * @return bool
     *
     * @see User for links to jobs
     * @see User::isCSuiteStaff and User::isDirectorStaff
     */
    public function isHighLevelStaff()
    {
        return $this->isCSuiteStaff() || $this->isDirectorStaff();
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
     * Check to see if the user is part of the procurement staff.
     * This includes roles such as PO, VM, SCA, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of procurement roles
     * @see UserJob::procurementShortCodes for procurement short codes
     */
    public function isProcurementStaff()
    {
        return $this->job?->isProcurement() ?? false;
    }

    /**
     * Check if the user is part of the quality assurance staff.
     * This includes roles such as QAE, QAC, QCI, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of quality assurance roles
     * @see UserJob::qualityAssuranceShortCodes for quality
     * assurance short codes
     */
    public function isQualityAssuranceStaff()
    {
        return $this->job?->isQualityAssurance() ?? false;
    }

    /**
     * Check if the user is part of the training and development staff.
     * This includes roles such as TRM, LDS, CR, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of training and development roles
     * @see UserJob::trainingAndDevelopmentShortCodes for training and
     * development short codes
     */
    public function isTrainingAndDevelopmentStaff()
    {
        return $this->job?->isTrainingAndDevelopment() ?? false;
    }

    /**
     * Check if the user is part of the public relations staff.
     * This includes roles such as PRM, MRS, COF, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of public relations roles
     * @see UserJob::publicRelationsShortCodes for public relations short codes
     */
    public function isPublicRelationsStaff()
    {
        return $this->job?->isPublicRelations() ?? false;
    }

    /**
     * Check if the user is part of the facilities management staff.
     * This includes roles such as FM, MS, CSC, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of facilities management roles
     * @see UserJob::facilitiesManagementShortCodes for facilities management
     * short codes
     */
    public function isFacilitiesManagementStaff()
    {
        return $this->job?->isFacilitiesManagement() ?? false;
    }

    /**
     * Check if the user is part of the compliance staff.
     * This includes roles such as RCO, CPA, CPC, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of compliance roles
     * @see UserJob::complianceShortCodes for compliance short codes
     */
    public function isComplianceStaff()
    {
        return $this->job?->isCompliance() ?? false;
    }

    /**
     * Check if the user is part of the security staff.
     * This includes roles such as SECMM, CSECA, SO, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of security roles
     * @see UserJob::securityShortCodes for security short codes
     */
    public function isSecurityStaff()
    {
        return $this->job?->isSecurity() ?? false;
    }

    /**
     * Check if the user is part of the product management staff.
     * This includes roles such as PMGR, TPM, POW, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of product management roles
     * @see UserJob::productManagementShortCodes for product
     * management short codes
     */
    public function isProductManagementStaff()
    {
        return $this->job?->isProductManagement() ?? false;
    }

    /**
     * Check if the user is part of the data analysis staff.
     * This includes roles such as DS, BID, DENG, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of data analysis roles
     * @see UserJob::dataAnalysisShortCodes for data analysis short codes
     */
    public function isDataAnalysisStaff()
    {
        return $this->job?->isDataAnalysis() ?? false;
    }

    /**
     * Check if the user is part of the strategic planning staff.
     * This includes roles such as STP, BS, MRA, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of strategic planning roles
     * @see UserJob::strategicPlanningShortCodes for strategic
     * planning short codes
     */
    public function isStrategicPlanningStaff()
    {
        return $this->job?->isStrategicPlanning() ?? false;
    }

    /**
     * Check if the user is part of the business development staff.
     * This includes roles such as BIACT, BIM, DWM, etc.
     *
     * @return bool
     *
     * @see UserJob for the list of business development roles
     * @see UserJob::businessDevelopmentShortCodes for business
     * development short codes
     */
    public function isBusinessDevelopmentStaff()
    {
        return $this->job?->isBusinessDevelopment() ?? false;
    }

    /**
     * Scope a query to only include active jobs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    /**
     * Scope a query to only include archived jobs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
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
