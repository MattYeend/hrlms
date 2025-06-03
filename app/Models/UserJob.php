<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJob extends Model
{
    /** @use HasFactory<\Database\Factories\UserJobsFactory> */
    use HasFactory, SoftDeletes;

    // Constants for C Suite short codes
    public const string CEO_SHORT_CODE = "CEO";
    public const string COO_SHORT_CODE = "COO";
    public const string CFO_SHORT_CODE = "CFO";
    public const string CMO_SHORT_CODE = "CMO";
    public const string CTO_SHORT_CODE = "CTO";
    public const string CIO_SHORT_CODE = "CIO";
    public const string CHRO_SHORT_CODE = "CHRO";
    public const string CPO_SHORT_CODE = "CPO";
    public const string CRO_SHORT_CODE = "CRO";
    public const string CLO_SHORT_CODE = "CLO";
    public const string CCO_SHORT_CODE = "CCO";
    public const string CDO_SHORT_CODE = "CDO";
    public const string CSEO_SHORT_CODE = "CSEO";
    public const string CXO_SHORT_CODE = "CXO";
    public const string CSTO_SHORT_CODE = "CSTO";
    public const string CINO_SHORT_CODE = "CINO";

    // Constants for HR Department short codes
    public const string HRD_SHORT_CODE = "HRD";
    public const string DoP_SHORT_CODE = "DoP";
    public const string HRM_SHORT_CODE = "HRM";
    public const string ERM_SHORT_CODE = "ERM";
    public const string TAM_SHORT_CODE = "TAM";
    public const string HRBP_SHORT_CODE = "HRBP";
    public const string HRG_SHORT_CODE = "HRG";
    public const string HRA_SHORT_CODE = "HRA";

    // Constants for IT Department short codes
    public const string ITD_SHORT_CODE = "ITD";
    public const string ITM_SHORT_CODE = "ITM";
    public const string SA_SHORT_CODE = "SA";
    public const string NE_SHORT_CODE = "NE";
    public const string DBA_SHORT_CODE = "DBA";
    public const string SDEV_SHORT_CODE = "SDEV";
    public const string DA_SHORT_CODE = "DA";

    // Constants for Sales short codes
    public const string SDIR_SHORT_CODE = "SDIR";
    public const string SM_SHORT_CODE = "SM";
    public const string AE_SHORT_CODE = "AE";
    public const string BDM_SHORT_CODE = "BDM";
    public const string SR_SHORT_CODE = "SR";
    public const string SSS_SHORT_CODE = "SSS";

    // Constants for Customer Support short codes
    public const string CSD_SHORT_CODE = "CSD";
    public const string CSERVM_SHORT_CODE = "CSERVM";
    public const string CSS_SHORT_CODE = "CSS";
    public const string TSS_SHORT_CODE = "TSS";
    public const CSUCM_SHORT_CODE = "CSUCM";
    public const string CCM_SHORT_CODE = "CCM";

    // Constants for Finance short codes
    public const string FD_SHORT_CODE = "FD";
    public const string FA_SHORT_CODE = "FA";
    public const string ACC_SHORT_CODE = "ACC";
    public const string PS_SHORT_CODE = "PS";
    public const string TRSM_SHORT_CODE = "TRSM";
    public const string IA_SHORT_CODE = "IA";
    public const string TAXM_SHORT_CODE = "TAXM";

    // Constants for Operations short codes
    public const string OD_SHORT_CODE = "OD";
    public const string OPPM_SHORT_CODE = "OPPM";
    public const string SCM_SHORT_CODE = "SCM";
    public const string LC_SHORT_CODE = "LC";
    public const string QAM_SHORT_CODE = "QAM";
    public const string PM_SHORT_CODE = "PM";

    // Constants for Legal short codes
    public const string LD_SHORT_CODE = "LD";
    public const string CC_SHORT_CODE = "CC";
    public const string CO_SHORT_CODE = "CO";
    public const string PL_SHORT_CODE = "PL";
    public const string CM_SHORT_CODE = "CM";
    public const string IPM_SHORT_CODE = "IPM";

    // Constants for Marketing short codes
    public const string MD_SHORT_CODE = "MD";
    public const string DMM_SHORT_CODE = "DMM";
    public const string CMS_SHORT_CODE = "CMS";
    public const string SMM_SHORT_CODE = "SMM";
    public const string SEO_SHORT_CODE = "SEO";
    public const string BM_SHORT_CODE = "BM";

    // Constants for Administration short codes
    public const string AD_SHORT_CODE = "AD";
    public const string OFFM_SHORT_CODE = "OFFM";
    public const string EA_SHORT_CODE = "EA";
    public const string REC_SHORT_CODE = "REC";
    public const string DEC_SHORT_CODE = "DEC";
    public const string FC_SHORT_CODE = "FC";

    // Constants for Research and Development short codes
    public const string RD_SHORT_CODE = "RD";
    public const string RS_SHORT_CODE = "RS";
    public const string PDM_SHORT_CODE = "PDM";
    public const string QCA_SHORT_CODE = "QCA";
    public const string IM_SHORT_CODE = "IM";
    public const string RAS_SHORT_CODE = "RAS";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_title',
        'slug',
        'short_code',
        'description',
        'is_default',
        'archived',
        'department_id',
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
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
        'archived' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'restored_at' => 'datetime',
        'department_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'restored_by' => 'integer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var list<string>
     */
    protected $hidden = [
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'restored_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $appends = [
        'job_title',
        'slug',
        'short_code',
        'description',
        'department_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'restored_at',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the job title.
     *
     * @return string
     */
    public function getJobTitleAttribute(): string
    {
        return $this->attributes['job_title'] ?? '';
    }

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlugAttribute(): string
    {
        return $this->attributes['slug'] ?? '';
    }

    /**
     * Get the short code.
     *
     * @return string
     */
    public function getShortCodeAttribute(): string
    {
        return $this->attributes['short_code'] ?? '';
    }

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        return $this->attributes['description'] ?? '';
    }

    /**
     * Get the department ID.
     *
     * @return int
     */
    public function getDepartmentIdAttribute(): int
    {
        return (int) ($this->attributes['department_id'] ?? 0);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function restoredBy()
    {
        return $this->belongsTo(User::class, 'restored_by');
    }
    public function scopeActive($query)
    {
        return $query->where('archived', false);
    }
    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    /**
     * Get the list of C-Suite short codes.
     *
     * @return array<string>
     */
    public function C_SUITE_SHORT_CODES(): array
    {
        return [
            self::CEO_SHORT_CODE,
            self::COO_SHORT_CODE,
            self::CFO_SHORT_CODE,
            self::CMO_SHORT_CODE,
            self::CTO_SHORT_CODE,
            self::CIO_SHORT_CODE,
            self::CHRO_SHORT_CODE,
            self::CPO_SHORT_CODE,
            self::CRO_SHORT_CODE,
            self::CLO_SHORT_CODE,
            self::CCO_SHORT_CODE,
            self::CDO_SHORT_CODE,
            self::CSEO_SHORT_CODE,
            self::CXO_SHORT_CODE,
            self::CSTO_SHORT_CODE,
            self::CINO_SHORT_CODE,
        ];
    }
    
    /**
     * Get the list of HR Department short codes.
     *
     * @return array<string>
     */
    public function HR_DEPARTMENT_SHORT_CODES(): array
    {
        return [
            self::HRD_SHORT_CODE,
            self::DoP_SHORT_CODE,
            self::HRM_SHORT_CODE,
            self::ERM_SHORT_CODE,
            self::TAM_SHORT_CODE,
            self::HRBP_SHORT_CODE,
            self::HRG_SHORT_CODE,
            self::HRA_SHORT_CODE,
        ];
    }

    /**
     * Get the list of IT Department short codes.
     *
     * @return array<string>
     */
    public function IT_DEPARTMENT_SHORT_CODES(): array
    {
        return [
            self::ITD_SHORT_CODE,
            self::ITM_SHORT_CODE,
            self::SA_SHORT_CODE,
            self::NE_SHORT_CODE,
            self::DBA_SHORT_CODE,
            self::SDEV_SHORT_CODE,
            self::DA_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Sales short codes.
     * 
     * @return array<string>
     */
    public function SALES_SHORT_CODES(): array
    {
        return [
            self::SDIR_SHORT_CODE,
            self::SM_SHORT_CODE,
            self::AE_SHORT_CODE,
            self::BDM_SHORT_CODE,
            self::SR_SHORT_CODE,
            self::SSS_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Customer Support short codes.
     *
     * @return array<string>
     */
    public function CUSTOMER_SUPPORT_SHORT_CODES(): array
    {
        return [
            self::CSD_SHORT_CODE,
            self::CSERVM_SHORT_CODE,
            self::CSS_SHORT_CODE,
            self::TSS_SHORT_CODE,
            self::CSUCM_SHORT_CODE,
            self::CCM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Finance short codes.
     *
     * @return array<string>
     */
    public function FINANCE_SHORT_CODES(): array
    {
        return [
            self::FD_SHORT_CODE,
            self::FA_SHORT_CODE,
            self::ACC_SHORT_CODE,
            self::PS_SHORT_CODE,
            self::TRSM_SHORT_CODE,
            self::IA_SHORT_CODE,
            self::TAXM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Operations short codes.
     *
     * @return array<string>
     */
    public function OPERATIONS_SHORT_CODES(): array
    {
        return [
            self::OD_SHORT_CODE,
            self::OPPM_SHORT_CODE,
            self::SCM_SHORT_CODE,
            self::LC_SHORT_CODE,
            self::QAM_SHORT_CODE,
            self::PM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Legal short codes.
     *
     * @return array<string>
     */
    public function LEGAL_SHORT_CODES(): array
    {
        return [
            self::LD_SHORT_CODE,
            self::CC_SHORT_CODE,
            self::CO_SHORT_CODE,
            self::PL_SHORT_CODE,
            self::CM_SHORT_CODE,
            self::IPM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Marketing short codes.
     *
     * @return array<string>
     */
    public function MARKETING_SHORT_CODES(): array
    {
        return [
            self::MD_SHORT_CODE,
            self::DMM_SHORT_CODE,
            self::CMS_SHORT_CODE,
            self::SMM_SHORT_CODE,
            self::SEO_SHORT_CODE,
            self::BM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Administration short codes.
     *
     * @return array<string>
     */
    public function ADMINISTRATION_SHORT_CODES(): array
    {
        return [
            self::AD_SHORT_CODE,
            self::OFFM_SHORT_CODE,
            self::EA_SHORT_CODE,
            self::REC_SHORT_CODE,
            self::DEC_SHORT_CODE,
            self::FC_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Research and Development short codes.
     *
     * @return array<string>
     */
    public function RESEARCH_AND_DEVELOPMENT_SHORT_CODES(): array
    {
        return [
            self::RD_SHORT_CODE,
            self::RS_SHORT_CODE,
            self::PDM_SHORT_CODE,
            self::QCA_SHORT_CODE,
            self::IM_SHORT_CODE,
            self::RAS_SHORT_CODE,
        ];
    }

    /**
     * Check if the job is part of the C-Suite roles.
     *
     * @return bool
     */
    public function isCSuite(): bool
    {
        return in_array($this->short_code, $this->C_SUITE_SHORT_CODES());
    }

    /**
     * Check if the job is part of the HR Department roles.
     *
     * @return bool
     */
    public function isHRDepartment(): bool
    {
        return in_array($this->short_code, $this->HR_DEPARTMENT_SHORT_CODES());
    }

    /**
     * Check if the job is part of the IT Department roles.
     *
     * @return bool
     */
    public function isITDepartment(): bool
    {
        return in_array($this->short_code, $this->IT_DEPARTMENT_SHORT_CODES());
    }

    /**
     * Check if the job is part of the Sales roles.
     *
     * @return bool
     */
    public function isSales(): bool
    {
        return in_array($this->short_code, $this->SALES_SHORT_CODES());
    }

    /**
     * Check if the job is part of the Customer Support roles.
     *
     * @return bool
     */
    public function isCustomerSupport(): bool
    {
        return in_array($this->short_code, $this->CUSTOMER_SUPPORT_SHORT_CODES());
    }

    /**
     * Check if the job is part of the Finance roles.
     *
     * @return bool
     */
    public function isFinance(): bool
    {
        return in_array($this->short_code, $this->FINANCE_SHORT_CODES());
    }

    /**
     * Check if the job is part of the Operations roles.
     *
     * @return bool
     */
    public function isOperations(): bool
    {
        return in_array($this->short_code, $this->OPERATIONS_SHORT_CODES());
    }

    /**
     * Check if the job is part of the Legal roles.
     *
     * @return bool
     */
    public function isLegal(): bool
    {
        return in_array($this->short_code, $this->LEGAL_SHORT_CODES());
    }

    /**
     * Check if the job is part of the Marketing roles.
     *
     * @return bool
     */
    public function isMarketing(): bool
    {
        return in_array($this->short_code, $this->MARKETING_SHORT_CODES());
    }

    /**
     * Check if the job is part of the Administration roles.
     *
     * @return bool
     */
    public function isAdministration(): bool
    {
        return in_array($this->short_code, $this->ADMINISTRATION_SHORT_CODES());
    }

    /**
     * Check if the job is part of the Research and Development roles.
     *
     * @return bool
     */
    public function isResearchAndDevelopment(): bool
    {
        return in_array($this->short_code, $this->RESEARCH_AND_DEVELOPMENT_SHORT_CODES());
    }
}
