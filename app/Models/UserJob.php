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
    public const string CEO_SHORT_CODE = 'CEO';
    public const string COO_SHORT_CODE = 'COO';
    public const string CFO_SHORT_CODE = 'CFO';
    public const string CMO_SHORT_CODE = 'CMO';
    public const string CTO_SHORT_CODE = 'CTO';
    public const string CIO_SHORT_CODE = 'CIO';
    public const string CHRO_SHORT_CODE = 'CHRO';
    public const string CPRODO_SHORT_CODE = 'CPRODO';
    public const string CRO_SHORT_CODE = 'CRO';
    public const string CLO_SHORT_CODE = 'CLO';
    public const string CCOMPO_SHORT_CODE = 'CCOMPO';
    public const string CDATAO_SHORT_CODE = 'CDATAO';
    public const string CSEO_SHORT_CODE = 'CSEO';
    public const string CXO_SHORT_CODE = 'CXO';
    public const string CSTO_SHORT_CODE = 'CSTO';
    public const string CINO_SHORT_CODE = 'CINO';
    public const string CDIVO_SHORT_CODE = 'CDIVO';
    public const string CSO_SHORT_CODE = 'CSO';
    public const string CAO_SHORT_CODE = 'CAO';
    public const string CRISKO_SHORT_CODE = 'CRISKO';
    public const string CINVO_SHORT_CODE = 'CINVO';
    public const string CLEARNO_SHORT_CODE = 'CLEARNO';
    public const string CCOMMSO_SHORT_CODE = 'CCOMMSO';
    public const string CPO_SHORT_CODE = 'CPO';
    public const string CBDO_SHORT_CODE = 'CBDO';
    public const string CFRAO_SHORT_CODE = 'CFRAO';
    public const string CIRO_SHORT_CODE = 'CIRO';
    public const string CETHICSO_SHORT_CODE = 'CETHICSO';
    public const string CDIGITO_SHORT_CODE = 'CDIGITO';
    public const string CBO_SHORT_CODE = 'CBO';
    public const string CCUSTO_SHORT_CODE = 'CCUSTO';
    public const string CGO_SHORT_CODE = 'CGO';
    public const string CFDO_SHORT_CODE = 'CFDO';
    public const string CCDO_SHORT_CODE = 'CCDO';
    public const string CTRANO_SHORT_CODE = 'CTRANO';
    public const string CPEOPLEO_SHORT_CODE = 'CPEOPLEO';
    public const string CITO_SHORT_CODE = 'CITO';
    public const string CGMO_SHORT_CODE = 'CGMO';
    public const string CDMO_SHORT_CODE = 'CDMO';
    public const string CCAO_SHORT_CODE = 'CCAO';

    // Constants for Directorship short codes
    public const string DIR_SHORT_CODE = 'DIR';
    public const string MD_SHORT_CODE = 'MD';
    public const string ED_SHORT_CODE = 'ED';
    public const string SDIR_SHORT_CODE = 'SDIR';
    public const string ASSOCDIR_SHORT_CODE = 'ASSOCDIR';
    public const string REGDIR_SHORT_CODE = 'REGDIR';
    public const string PDIR_SHORT_CODE = 'PDIR';
    public const string PJDIR_SHORT_CODE = 'PJDIR';
    public const string ODIR_SHORT_CODE = 'ODIR';
    public const string BDDIR_SHORT_CODE = 'BDDIR';
    public const string SALESDIR_SHORT_CODE = 'SALESDIR';
    public const string MDIR_SHORT_CODE = 'MDIR';
    public const string FINDIR_SHORT_CODE = 'FINDIR';
    public const string HRDIR_SHORT_CODE = 'HRDIR';
    public const string ITDIR_SHORT_CODE = 'ITDIR';
    public const string LDIR_SHORT_CODE = 'LDIR';
    public const string CDIR_SHORT_CODE = 'CDIR';
    public const string PRODDIR_SHORT_CODE = 'PRODDIR';
    public const string CUSTEXDIR_SHORT_CODE = 'CUSTEXDIR';
    public const string IDIR_SHORT_CODE = 'IDIR';
    public const string CADIR_SHORT_CODE = 'CADIR';
    public const string SUSDIR_SHORT_CODE = 'SUSDIR';
    public const string DADIR_SHORT_CODE = 'DADIR';
    public const string RMDIR_SHORT_CODE = 'RMDIR';
    public const string IRDIR_SHORT_CODE = 'IRDIR';
    public const string TDDIR_SHORT_CODE = 'TDDIR';
    public const string FACDIR_SHORT_CODE = 'FACDIR';
    public const string SECDIR_SHORT_CODE = 'SECDIR';
    public const string PROCDIR_SHORT_CODE = 'PROCDIR';
    public const string QADIR_SHORT_CODE = 'QADIR';
    public const string PRDIR_SHORT_CODE = 'PRDIR';
    public const string COMMSENGDIR_SHORT_CODE = 'COMMSENGDIR';
    public const string CORPSTRDIR_SHORT_CODE = 'CORPSTRDIR';
    public const string DTDIR_SHORT_CODE = 'DTDIR';
    public const string GODIR_SHORT_CODE = 'GODIR';
    public const string FRDIR_SHORT_CODE = 'FRDIR';
    public const string CDDIR_SHORT_CODE = 'CDDIR';
    public const string CUSTSUPPDIR_SHORT_CODE = 'CUSTSUPPDIR';
    public const string ADMINDIR_SHORT_CODE = 'ADMINDIR';
    public const string RDIR_SHORT_CODE = 'RDIR';

    // Constants for Human Resources short codes
    public const string DOP_SHORT_CODE = 'DOP';
    public const string HRM_SHORT_CODE = 'HRM';
    public const string ERM_SHORT_CODE = 'ERM';
    public const string TAM_SHORT_CODE = 'TAM';
    public const string HRBP_SHORT_CODE = 'HRBP';
    public const string HRG_SHORT_CODE = 'HRG';
    public const string HRA_SHORT_CODE = 'HRA';

    // Constants for IT Department short codes
    public const string ITM_SHORT_CODE = 'ITM';
    public const string SA_SHORT_CODE = 'SA';
    public const string NE_SHORT_CODE = 'NE';
    public const string DBA_SHORT_CODE = 'DBA';
    public const string SDEV_SHORT_CODE = 'SDEV';
    public const string DA_SHORT_CODE = 'DA';
    public const string CS_SHORT_CODE = 'CS';
    public const string HDT_SHORT_CODE = 'HDT';
    public const string CSA_SHORT_CODE = 'CSA';
    public const string ITS_SHORT_CODE = 'ITS';
    public const string DE_SHORT_CODE = 'DE';
    public const string SECA_SHORT_CODE = 'SECA';
    public const string BIA_SHORT_CODE = 'BIA';
    public const string ITPM_SHORT_CODE = 'ITPM';
    public const string ITCO_SHORT_CODE = 'ITCO';
    public const string ITT_SHORT_CODE = 'ITT';
    public const string ITPS_SHORT_CODE = 'ITPS';
    public const string ITOM_SHORT_CODE = 'ITOM';
    public const string ITA_SHORT_CODE = 'ITA';
    public const string ITBA_SHORT_CODE = 'ITBA';
    public const string WD_SHORT_CODE = 'WD';
    public const string MAD_SHORT_CODE = 'MAD';
    public const string ISA_SHORT_CODE = 'ISA';
    public const string ITSM_SHORT_CODE = 'ITSM';
    public const string ITVM_SHORT_CODE = 'ITVM';
    public const string CHANGEM_SHORT_CODE = 'CHANGEM';
    public const string ITAM_SHORT_CODE = 'ITAM';
    public const string ITDRS_SHORT_CODE = 'ITDRS';
    public const string ITNA_SHORT_CODE = 'ITNA';
    public const string ITSE_SHORT_CODE = 'ITSE';
    public const string ITBCM_SHORT_CODE = 'ITBCM';
    public const string ITQAA_SHORT_CODE = 'ITQAA';
    public const string ITRM_SHORT_CODE = 'ITRM';
    public const string CONFIGM_SHORT_CODE = 'CONFIGM';
    public const string ITPA_SHORT_CODE = 'ITPA';

    // Constants for Sales short codes
    public const string SM_SHORT_CODE = 'SM';
    public const string AE_SHORT_CODE = 'AE';
    public const string BDM_SHORT_CODE = 'BDM';
    public const string SR_SHORT_CODE = 'SR';
    public const string SSS_SHORT_CODE = 'SSS';

    // Constants for Customer Support short codes
    public const string CSERVM_SHORT_CODE = 'CSERVM';
    public const string CSS_SHORT_CODE = 'CSS';
    public const string TSS_SHORT_CODE = 'TSS';
    public const string CSUCM_SHORT_CODE = 'CSUCM';
    public const string CCM_SHORT_CODE = 'CCM';
    public const string HDM_SHORT_CODE = 'HDM';
    public const string CEM_SHORT_CODE = 'CEM';

    // Constants for Finance short codes
    public const string FA_SHORT_CODE = 'FA';
    public const string ACC_SHORT_CODE = 'ACC';
    public const string PS_SHORT_CODE = 'PS';
    public const string TRSM_SHORT_CODE = 'TRSM';
    public const string IA_SHORT_CODE = 'IA';
    public const string TAXM_SHORT_CODE = 'TAXM';

    // Constants for Operations short codes
    public const string OPPM_SHORT_CODE = 'OPPM';
    public const string SCM_SHORT_CODE = 'SCM';
    public const string LC_SHORT_CODE = 'LC';
    public const string QAM_SHORT_CODE = 'QAM';
    public const string PM_SHORT_CODE = 'PM';

    // Constants for Legal short codes
    public const string CC_SHORT_CODE = 'CC';
    public const string CO_SHORT_CODE = 'CO';
    public const string PL_SHORT_CODE = 'PL';
    public const string COM_SHORT_CODE = 'COM';
    public const string IPM_SHORT_CODE = 'IPM';
    public const string LS_SHORT_CODE = 'LS';
    public const string LA_SHORT_CODE = 'LA';

    // Constants for Marketing short codes
    public const string DMM_SHORT_CODE = 'DMM';
    public const string CMS_SHORT_CODE = 'CMS';
    public const string SMM_SHORT_CODE = 'SMM';
    public const string SEO_SHORT_CODE = 'SEO';
    public const string BM_SHORT_CODE = 'BM';

    // Constants for Administration short codes
    public const string OFFM_SHORT_CODE = 'OFFM';
    public const string EA_SHORT_CODE = 'EA';
    public const string REC_SHORT_CODE = 'REC';
    public const string DEC_SHORT_CODE = 'DEC';
    public const string FC_SHORT_CODE = 'FC';

    // Constants for R&D short codes
    public const string RS_SHORT_CODE = 'RS';
    public const string PDM_SHORT_CODE = 'PDM';
    public const string QCA_SHORT_CODE = 'QCA';
    public const string IM_SHORT_CODE = 'IM';
    public const string RAS_SHORT_CODE = 'RAS';

    // Constants for Procurement short codes
    public const string PROCM_SHORT_CODE = 'PROCM';
    public const string PO_SHORT_CODE = 'PO';
    public const string VM_SHORT_CODE = 'VM';
    public const string SCA_SHORT_CODE = 'SCA';
    public const string CM_SHORT_CODE = 'CM';
    public const string CONS_SHORT_CODE = 'ConS';

    // Constants for Quality Assurance short codes
    public const string QAE_SHORT_CODE = 'QAE';
    public const string QAC_SHORT_CODE = 'QAC';
    public const string QCI_SHORT_CODE = 'QCI';
    public const string QAA_SHORT_CODE = 'QAA';
    public const string QAT_SHORT_CODE = 'QAT';

    // Constants for Training and Development short codes
    public const string TRM_SHORT_CODE = 'TRM';
    public const string LDS_SHORT_CODE = 'LDS';
    public const string TRC_SHORT_CODE = 'TRC';
    public const string INSTDES_SHORT_CODE = 'INSTDES';
    public const string CT_SHORT_CODE = 'CT';
    public const string ELS_SHORT_CODE = 'ELS';

    // Constants for Public Relations short codes
    public const string PRM_SHORT_CODE = 'PRM';
    public const string MRS_SHORT_CODE = 'MRS';
    public const string COF_SHORT_CODE = 'COF';
    public const string PAM_SHORT_CODE = 'PAM';
    public const string CCOMM_SHORT_CODE = 'CCOMM';
    public const string EC_SHORT_CODE = 'EC';

    // Constants for Facilities short codes
    public const string FM_SHORT_CODE = 'FM';
    public const string MS_SHORT_CODE = 'MS';
    public const string CSC_SHORT_CODE = 'CSC';
    public const string BOM_SHORT_CODE = 'BOM';
    public const string SOF_SHORT_CODE = 'SOF';
    public const string SP_SHORT_CODE = 'SP';

    // Constants for Compliance short codes
    public const string RCO_SHORT_CODE = 'RCO';
    public const string CPA_SHORT_CODE = 'CPA';
    public const string CPC_SHORT_CODE = 'CPC';
    public const string DPO_SHORT_CODE = 'DPO';
    public const string EO_SHORT_CODE = 'EO';

    // Constants for Security short codes
    public const string SECMM_SHORT_CODE = 'SECMM';
    public const string CSECA_SHORT_CODE = 'CSECA';
    public const string SO_SHORT_CODE = 'SO';
    public const string ISM_SHORT_CODE = 'ISM';
    public const string PSS_SHORT_CODE = 'PSS';
    public const string SSA_SHORT_CODE = 'SSA';

    // Constants for Product Management short codes
    public const string PMGR_SHORT_CODE = 'PMGR';
    public const string TPM_SHORT_CODE = 'TPM';
    public const string POW_SHORT_CODE = 'POW';
    public const string PMM_SHORT_CODE = 'PMM';
    public const string UXR_SHORT_CODE = 'UXR';
    public const string PDS_SHORT_CODE = 'PDS';

    // Constants for Data Analytics short codes
    public const string DS_SHORT_CODE = 'DS';
    public const string BID_SHORT_CODE = 'BID';
    public const string DENG_SHORT_CODE = 'DENG';
    public const string DVS_SHORT_CODE = 'DVS';
    public const string QA_SHORT_CODE = 'QA';
    public const string DGM_SHORT_CODE = 'DGM';

    // Constants for Strategic Planning short codes
    public const string STP_SHORT_CODE = 'STP';
    public const string BS_SHORT_CODE = 'BS';
    public const string MRA_SHORT_CODE = 'MRA';
    public const string CDM_SHORT_CODE = 'CDM';
    public const string CIA_SHORT_CODE = 'CIA';

    // Constants for Business Intelligence short codes
    public const string BIAANALYST_SHORT_CODE = 'BIAANALYST';
    public const string BIACT_SHORT_CODE = 'BIACT';
    public const string BIM_SHORT_CODE = 'BIM';
    public const string DWM_SHORT_CODE = 'DWM';
    public const string BIC_SHORT_CODE = 'BIC';

    // Constants for Innovation short codes
    public const string INS_SHORT_CODE = 'INS';
    public const string ILM_SHORT_CODE = 'ILM';
    public const string DAI_SHORT_CODE = 'DAI';
    public const string INC_SHORT_CODE = 'INC';
    public const string RDIS_SHORT_CODE = 'RDIS';
    public const string OIM_SHORT_CODE = 'OIM';

    // Constants for Sustainability short codes
    public const string SUM_SHORT_CODE = 'SUM';
    public const string ENVSP_SHORT_CODE = 'ENVSP';
    public const string CSRC_SHORT_CODE = 'CSRC';
    public const string SANA_SHORT_CODE = 'SANA';
    public const string SUCO_SHORT_CODE = 'SUCO';
    public const string GBS_SHORT_CODE = 'GBS';

    // Constants for Investor Relations short codes
    public const string IRM_SHORT_CODE = 'IRM';
    public const string SRO_SHORT_CODE = 'SRO';
    public const string FCS_SHORT_CODE = 'FCS';
    public const string IRA_SHORT_CODE = 'IRA';
    public const string CAPMARKS_SHORT_CODE = 'CAPMARKS';
    public const string ERA_SHORT_CODE = 'ERA';

    // Constants for UX/UI Design short codes
    public const string UXD_SHORT_CODE = 'UXD';
    public const string UID_SHORT_CODE = 'UID';
    public const string DL_SHORT_CODE = 'DL';
    public const string ISTDESIGN_SHORT_CODE = 'ISTDESIGN';
    public const string VD_SHORT_CODE = 'VD';
    public const string UR_SHORT_CODE = 'UR';

    // Constants for Content Strategy short codes
    public const string CST_SHORT_CODE = 'CST';
    public const string CW_SHORT_CODE = 'CW';
    public const string EDM_SHORT_CODE = 'EDM';
    public const string CMM_SHORT_CODE = 'CMM';
    public const string SEOCS_SHORT_CODE = 'SEOCS';
    public const string SMCM_SHORT_CODE = 'SMCM';

    // Constants for Community Engagement short codes
    public const string COMAN_SHORT_CODE = 'COMAN';
    public const string PCO_SHORT_CODE = 'PCO';
    public const string ORS_SHORT_CODE = 'ORS';
    public const string VCO_SHORT_CODE = 'VCO';
    public const string CSRM_SHORT_CODE = 'CSRM';
    public const string CRS_SHORT_CODE = 'CRS';

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
        'is_archived',
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
        'is_archived' => 'boolean',
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

    /**
     * Get the route key name for model binding.
     *
     * @return string
     */
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

    /**
     * Get the department that the job belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Department>
     *
     * @see Department for the list of departments
     * @see Department::class for the Department model
     * @see UserJob::department_id for the foreign key in the user_jobs table
     * @see UserJob::belongsTo for the relationship method
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the user who created the job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     *
     * @see User for the list of users
     * @see User::class for the User model
     * @see UserJob::created_by for the foreign key in the user_jobs table
     * @see UserJob::belongsTo for the relationship method
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     *
     * @see User for the list of users
     * @see User::class for the User model
     * @see UserJob::updated_by for the foreign key in the user_jobs table
     * @see UserJob::belongsTo for the relationship method
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted the job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     *
     * @see User for the list of users
     * @see User::class for the User model
     * @see UserJob::deleted_by for the foreign key in the user_jobs table
     * @see UserJob::belongsTo for the relationship method
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Get the user who restored the job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     *
     * @see User for the list of users
     * @see User::class for the User model
     * @see UserJob::restored_by for the foreign key in the user_jobs table
     * @see UserJob::belongsTo for the relationship method
     */
    public function restoredBy()
    {
        return $this->belongsTo(User::class, 'restored_by');
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
     * Get the list of C-Suite short codes.
     *
     * @return array<string>
     */
    public function cSuiteShortCodes(): array
    {
        return array_merge(
            $this->chiefExecutiveShortCodes(),
            $this->chiefOperationsShortCodes(),
            $this->chiefGrowthShortCodes()
        );
    }

    /**
     * Get the list of Directorship short codes.
     *
     * @return array<string>
     */
    public function directorshipShortCodes(): array
    {
        return array_merge(
            $this->generalDirectorShortCodes(),
            $this->functionalDirectorShortCodes(),
            $this->specializedDirectorShortCodes()
        );
    }

    /**
     * Get the list of HR Department short codes.
     *
     * @return array<string>
     */
    public function hRShortCodes(): array
    {
        return [
            self::DOP_SHORT_CODE,
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
    public function iTShortCodes(): array
    {
        return array_merge(
            $this->itManagementShortCodes(),
            $this->itDevelopmentShortCodes(),
            $this->itOperationsShortCodes(),
            $this->itSupportShortCodes()
        );
    }

    /**
     * Get the list of Sales short codes.
     *
     * @return array<string>
     */
    public function salesShortCodes(): array
    {
        return [
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
    public function customerSupportShortCodes(): array
    {
        return [
            self::CSERVM_SHORT_CODE,
            self::CSS_SHORT_CODE,
            self::TSS_SHORT_CODE,
            self::CSUCM_SHORT_CODE,
            self::CCM_SHORT_CODE,
            self::HDM_SHORT_CODE,
            self::CEM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Finance short codes.
     *
     * @return array<string>
     */
    public function financeShortCodes(): array
    {
        return [
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
    public function operationsShortCodes(): array
    {
        return [
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
    public function legalShortCodes(): array
    {
        return [
            self::CC_SHORT_CODE,
            self::CO_SHORT_CODE,
            self::PL_SHORT_CODE,
            self::COM_SHORT_CODE,
            self::IPM_SHORT_CODE,
            self::LS_SHORT_CODE,
            self::LA_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Marketing short codes.
     *
     * @return array<string>
     */
    public function marketingShortCodes(): array
    {
        return [
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
    public function administrationShortCodes(): array
    {
        return [
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
    public function researchAndDevelopmentShortCodes(): array
    {
        return [
            self::RS_SHORT_CODE,
            self::PDM_SHORT_CODE,
            self::QCA_SHORT_CODE,
            self::IM_SHORT_CODE,
            self::RAS_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Procurement short codes.
     *
     * @return array<string>
     */
    public function procurementShortCodes(): array
    {
        return [
            self::PROCM_SHORT_CODE,
            self::PO_SHORT_CODE,
            self::VM_SHORT_CODE,
            self::SCA_SHORT_CODE,
            self::CM_SHORT_CODE,
            self::CONS_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Quality Assurance short codes.
     *
     * @return array<string>
     */
    public function qualityAssuranceShortCodes(): array
    {
        return [
            self::QAE_SHORT_CODE,
            self::QAC_SHORT_CODE,
            self::QCI_SHORT_CODE,
            self::QAA_SHORT_CODE,
            self::QAT_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Training and Development short codes.
     *
     * @return array<string>
     */
    public function trainingAndDevelopmentShortCodes(): array
    {
        return [
            self::TRM_SHORT_CODE,
            self::LDS_SHORT_CODE,
            self::TRC_SHORT_CODE,
            self::INSTDES_SHORT_CODE,
            self::CT_SHORT_CODE,
            self::ELS_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Public Relations short codes.
     *
     * @return array<string>
     */
    public function publicRelationsShortCodes(): array
    {
        return [
            self::PRM_SHORT_CODE,
            self::MRS_SHORT_CODE,
            self::COF_SHORT_CODE,
            self::PAM_SHORT_CODE,
            self::CCOMM_SHORT_CODE,
            self::EC_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Facilities short codes.
     *
     * @return array<string>
     */
    public function facilitiesShortCodes(): array
    {
        return [
            self::FM_SHORT_CODE,
            self::MS_SHORT_CODE,
            self::CSC_SHORT_CODE,
            self::BOM_SHORT_CODE,
            self::SOF_SHORT_CODE,
            self::SP_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Compliance short codes.
     *
     * @return array<string>
     */
    public function complianceShortCodes(): array
    {
        return [
            self::RCO_SHORT_CODE,
            self::CPA_SHORT_CODE,
            self::CPC_SHORT_CODE,
            self::DPO_SHORT_CODE,
            self::EO_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Security short codes.
     *
     * @return array<string>
     */
    public function securityShortCodes(): array
    {
        return [
            self::SECMM_SHORT_CODE,
            self::CSECA_SHORT_CODE,
            self::SO_SHORT_CODE,
            self::ISM_SHORT_CODE,
            self::PSS_SHORT_CODE,
            self::SSA_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Product Management short codes.
     *
     * @return array<string>
     */
    public function productManagementShortCodes(): array
    {
        return [
            self::PMGR_SHORT_CODE,
            self::TPM_SHORT_CODE,
            self::POW_SHORT_CODE,
            self::PMM_SHORT_CODE,
            self::UXR_SHORT_CODE,
            self::PDS_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Data Analytics short codes.
     *
     * @return array<string>
     */
    public function dataAnalyticsShortCodes(): array
    {
        return [
            self::DS_SHORT_CODE,
            self::BID_SHORT_CODE,
            self::DENG_SHORT_CODE,
            self::DVS_SHORT_CODE,
            self::QA_SHORT_CODE,
            self::DGM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Strategic Planning short codes.
     *
     * @return array<string>
     */
    public function strategicPlanningShortCodes(): array
    {
        return [
            self::STP_SHORT_CODE,
            self::BS_SHORT_CODE,
            self::MRA_SHORT_CODE,
            self::CDM_SHORT_CODE,
            self::CIA_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Business Intelligence short codes.
     *
     * @return array<string>
     */
    public function businessIntelligenceShortCodes(): array
    {
        return [
            self::BIAANALYST_SHORT_CODE,
            self::BIACT_SHORT_CODE,
            self::BIM_SHORT_CODE,
            self::DWM_SHORT_CODE,
            self::BIC_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Innovation short codes.
     *
     * @return array<string>
     */
    public function innovationShortCodes(): array
    {
        return [
            self::INS_SHORT_CODE,
            self::ILM_SHORT_CODE,
            self::DAI_SHORT_CODE,
            self::INC_SHORT_CODE,
            self::RDIS_SHORT_CODE,
            self::OIM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Sustainability short codes.
     *
     * @return array<string>
     */
    public function sustainabilityShortCodes(): array
    {
        return [
            self::SUM_SHORT_CODE,
            self::ENVSP_SHORT_CODE,
            self::CSRC_SHORT_CODE,
            self::SANA_SHORT_CODE,
            self::SUCO_SHORT_CODE,
            self::GBS_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Investor Relations short codes.
     *
     * @return array<string>
     */
    public function investorRelationsShortCodes(): array
    {
        return [
            self::IRM_SHORT_CODE,
            self::SRO_SHORT_CODE,
            self::FCS_SHORT_CODE,
            self::IRA_SHORT_CODE,
            self::CAPMARKS_SHORT_CODE,
            self::ERA_SHORT_CODE,
        ];
    }

    /**
     * Get the list of UX/UI Design short codes.
     *
     * @return array<string>
     */
    public function uxUiDesignShortCodes(): array
    {
        return [
            self::UXD_SHORT_CODE,
            self::UID_SHORT_CODE,
            self::DL_SHORT_CODE,
            self::ISTDESIGN_SHORT_CODE,
            self::VD_SHORT_CODE,
            self::UR_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Content Strategy short codes.
     *
     * @return array<string>
     */
    public function contentStrategyShortCodes(): array
    {
        return [
            self::CST_SHORT_CODE,
            self::CW_SHORT_CODE,
            self::EDM_SHORT_CODE,
            self::CMM_SHORT_CODE,
            self::SEOCS_SHORT_CODE,
            self::SMCM_SHORT_CODE,
        ];
    }

    /**
     * Get the list of Community Engagement short codes.
     *
     * @return array<string>
     */
    public function communityEngagementShortCodes(): array
    {
        return [
            self::COMAN_SHORT_CODE,
            self::PCO_SHORT_CODE,
            self::ORS_SHORT_CODE,
            self::VCO_SHORT_CODE,
            self::CSRM_SHORT_CODE,
            self::CRS_SHORT_CODE,
        ];
    }

    /**
     * Check if the job is part of the C-Suite roles.
     *
     * @return bool
     */
    public function isCSuite(): bool
    {
        return in_array(
            $this->short_code,
            $this->cSuiteShortCodes(),
        );
    }

    /**
     * Check if the job is part of the Directorship roles.
     *
     * @return bool
     */
    public function isDirectorship(): bool
    {
        return in_array(
            $this->short_code,
            $this->directorshipShortCodes(),
        );
    }

    /**
     * Check if the job is part of the HR Department roles.
     *
     * @return bool
     */
    public function isHRDepartment(): bool
    {
        return in_array(
            $this->short_code,
            $this->hRShortCodes(),
        );
    }

    /**
     * Check if the job is part of the IT Department roles.
     *
     * @return bool
     */
    public function isITDepartment(): bool
    {
        return in_array(
            $this->short_code,
            $this->iTShortCodes(),
        );
    }

    /**
     * Check if the job is part of the Sales roles.
     *
     * @return bool
     */
    public function isSales(): bool
    {
        return in_array(
            $this->short_code,
            $this->salesShortCodes(),
        );
    }

    /**
     * Check if the job is part of the Customer Support roles.
     *
     * @return bool
     */
    public function isCustomerSupport(): bool
    {
        return in_array(
            $this->short_code,
            $this->customerSupportShortCodes(),
        );
    }

    /**
     * Check if the job is part of the Finance roles.
     *
     * @return bool
     */
    public function isFinance(): bool
    {
        return in_array(
            $this->short_code,
            $this->financeShortCodes(),
        );
    }

    /**
     * Check if the job is part of the Operations roles.
     *
     * @return bool
     */
    public function isOperations(): bool
    {
        return in_array(
            $this->short_code,
            $this->operationsShortCodes(),
        );
    }

    /**
     * Check if the job is part of the Legal roles.
     *
     * @return bool
     */
    public function isLegal(): bool
    {
        return in_array(
            $this->short_code,
            $this->legalShortCodes(),
        );
    }

    /**
     * Check if the job is part of the Marketing roles.
     *
     * @return bool
     */
    public function isMarketing(): bool
    {
        return in_array(
            $this->short_code,
            $this->marketingShortCodes()
        );
    }

    /**
     * Check if the job is part of the Administration roles.
     *
     * @return bool
     */
    public function isAdministration(): bool
    {
        return in_array(
            $this->short_code,
            $this->administrationShortCodes()
        );
    }

    /**
     * Check if the job is part of the Research and Development roles.
     *
     * @return bool
     */
    public function isResearchAndDevelopment(): bool
    {
        return in_array(
            $this->short_code,
            $this->researchAndDevelopmentShortCodes()
        );
    }

    /**
     * Check if the job is part of the Procurement roles.
     *
     * @return bool
     */
    public function isProcurement(): bool
    {
        return in_array(
            $this->short_code,
            $this->procurementShortCodes()
        );
    }

    /**
     * Check if the job is part of the Quality Assurance roles.
     *
     * @return bool
     */
    public function isQualityAssurance(): bool
    {
        return in_array(
            $this->short_code,
            $this->qualityAssuranceShortCodes()
        );
    }

    /**
     * Check if the job is part of the Training and Development roles.
     *
     * @return bool
     */
    public function isTrainingAndDevelopment(): bool
    {
        return in_array(
            $this->short_code,
            $this->trainingAndDevelopmentShortCodes()
        );
    }

    /**
     * Check if the job is part of the Public Relations roles.
     *
     * @return bool
     */
    public function isPublicRelations(): bool
    {
        return in_array(
            $this->short_code,
            $this->publicRelationsShortCodes()
        );
    }

    /**
     * Check if the job is part of the Facilities roles.
     *
     * @return bool
     */
    public function isFacilities(): bool
    {
        return in_array(
            $this->short_code,
            $this->facilitiesShortCodes()
        );
    }

    /**
     * Check if the job is part of the Compliance roles.
     *
     * @return bool
     */
    public function isCompliance(): bool
    {
        return in_array(
            $this->short_code,
            $this->complianceShortCodes()
        );
    }

    /**
     * Check if the job is part of the Security roles.
     *
     * @return bool
     */
    public function isSecurity(): bool
    {
        return in_array(
            $this->short_code,
            $this->securityShortCodes()
        );
    }

    /**
     * Check if the job is part of the Product Management roles.
     *
     * @return bool
     */
    public function isProductManagement(): bool
    {
        return in_array(
            $this->short_code,
            $this->productManagementShortCodes()
        );
    }

    /**
     * Check if the job is part of the Data Analytics roles.
     *
     * @return bool
     */
    public function isDataAnalytics(): bool
    {
        return in_array(
            $this->short_code,
            $this->dataAnalyticsShortCodes()
        );
    }

    /**
     * Check if the job is part of the Strategic Planning roles.
     *
     * @return bool
     */
    public function isStrategicPlanning(): bool
    {
        return in_array(
            $this->short_code,
            $this->strategicPlanningShortCodes()
        );
    }

    /**
     * Check if the job is part of the Business Intelligence roles.
     *
     * @return bool
     */
    public function isBusinessIntelligence(): bool
    {
        return in_array(
            $this->short_code,
            $this->businessIntelligenceShortCodes()
        );
    }

    /**
     * Check if the job is part of the Innovation roles.
     *
     * @return bool
     */
    public function isInnovation(): bool
    {
        return in_array(
            $this->short_code,
            $this->innovationShortCodes()
        );
    }

    /**
     * Check if the job is part of the Sustainability roles.
     *
     * @return bool
     */
    public function isSustainability(): bool
    {
        return in_array(
            $this->short_code,
            $this->sustainabilityShortCodes()
        );
    }

    /**
     * Check if the job is part of the Investor Relations roles.
     *
     * @return bool
     */
    public function isInvestorRelations(): bool
    {
        return in_array(
            $this->short_code,
            $this->investorRelationsShortCodes()
        );
    }

    /**
     * Check if the job is part of the UX/UI Design roles.
     *
     * @return bool
     */
    public function isUxUiDesign(): bool
    {
        return in_array(
            $this->short_code,
            $this->uxUiDesignShortCodes()
        );
    }

    /**
     * Check if the job is part of the Content Strategy roles.
     *
     * @return bool
     */
    public function isContentStrategy(): bool
    {
        return in_array(
            $this->short_code,
            $this->contentStrategyShortCodes()
        );
    }

    /**
     * Check if the job is part of the Community Engagement roles.
     *
     * @return bool
     */
    public function isCommunityEngagement(): bool
    {
        return in_array(
            $this->short_code,
            $this->communityEngagementShortCodes()
        );
    }

    /**
     * Get executive short codes.
     *
     * @return array<string>
     */
    private function chiefExecutiveShortCodes(): array
    {
        return [
            self::CEO_SHORT_CODE,
            self::COO_SHORT_CODE,
            self::CFO_SHORT_CODE,
            self::CHRO_SHORT_CODE,
            self::CLO_SHORT_CODE,
            self::CIO_SHORT_CODE,
            self::CTO_SHORT_CODE,
            self::CAO_SHORT_CODE,
            self::CBO_SHORT_CODE,
            self::CCAO_SHORT_CODE,
        ];
    }

    /**
     * Get opperations short codes.
     *
     * @return array<string>
     */
    private function chiefOperationsShortCodes(): array
    {
        return [
            self::CRO_SHORT_CODE,
            self::CPRODO_SHORT_CODE,
            self::CCOMPO_SHORT_CODE,
            self::CPO_SHORT_CODE,
            self::CSTO_SHORT_CODE,
            self::CPEOPLEO_SHORT_CODE,
            self::CITO_SHORT_CODE,
            self::CLEARNO_SHORT_CODE,
            self::CINVO_SHORT_CODE,
            self::CTRANO_SHORT_CODE,
        ];
    }

    /**
     * Get growth short codes.
     *
     * @return array<string>
     */
    private function chiefGrowthShortCodes(): array
    {
        return [
            self::CMO_SHORT_CODE,
            self::CDATAO_SHORT_CODE,
            self::CSEO_SHORT_CODE,
            self::CXO_SHORT_CODE,
            self::CINO_SHORT_CODE,
            self::CDIVO_SHORT_CODE,
            self::CRISKO_SHORT_CODE,
            self::CCOMMSO_SHORT_CODE,
            self::CBDO_SHORT_CODE,
            self::CFRAO_SHORT_CODE,
            self::CIRO_SHORT_CODE,
            self::CETHICSO_SHORT_CODE,
            self::CDIGITO_SHORT_CODE,
            self::CGO_SHORT_CODE,
            self::CFDO_SHORT_CODE,
            self::CCDO_SHORT_CODE,
            self::CGMO_SHORT_CODE,
            self::CDMO_SHORT_CODE,
        ];
    }

    /**
     * Get general director short codes.
     *
     * @return array<string>
     */
    private function generalDirectorShortCodes(): array
    {
        return [
            self::DIR_SHORT_CODE,
            self::MD_SHORT_CODE,
            self::ED_SHORT_CODE,
            self::SDIR_SHORT_CODE,
            self::ASSOCDIR_SHORT_CODE,
            self::REGDIR_SHORT_CODE,
            self::PDIR_SHORT_CODE,
            self::PJDIR_SHORT_CODE,
            self::ODIR_SHORT_CODE,
            self::BDDIR_SHORT_CODE,
        ];
    }

    /**
     * Get functional director short codes.
     *
     * @return array<string>
     */
    private function functionalDirectorShortCodes(): array
    {
        return [
            self::SALESDIR_SHORT_CODE,
            self::MDIR_SHORT_CODE,
            self::FINDIR_SHORT_CODE,
            self::HRDIR_SHORT_CODE,
            self::ITDIR_SHORT_CODE,
            self::LDIR_SHORT_CODE,
            self::CDIR_SHORT_CODE,
            self::PRODDIR_SHORT_CODE,
            self::CUSTEXDIR_SHORT_CODE,
            self::IDIR_SHORT_CODE,
            self::CADIR_SHORT_CODE,
        ];
    }

    /**
     * Get specialized director short codes.
     *
     * @return array<string>
     */
    private function specializedDirectorShortCodes(): array
    {
        return array_merge(
            $this->specializedDirectorGroupOne(),
            $this->specializedDirectorGroupTwo()
        );
    }

    /**
     * Get specialized director group one short codes.
     *
     * @return array<string>
     */
    private function specializedDirectorGroupOne(): array
    {
        return [
            self::SUSDIR_SHORT_CODE,
            self::DADIR_SHORT_CODE,
            self::RMDIR_SHORT_CODE,
            self::IRDIR_SHORT_CODE,
            self::TDDIR_SHORT_CODE,
            self::FACDIR_SHORT_CODE,
            self::SECDIR_SHORT_CODE,
            self::PROCDIR_SHORT_CODE,
            self::QADIR_SHORT_CODE,
            self::PRDIR_SHORT_CODE,
        ];
    }

    /**
     * Get specialized director group two short codes.
     *
     * @return array<string>
     */
    private function specializedDirectorGroupTwo(): array
    {
        return [
            self::COMMSENGDIR_SHORT_CODE,
            self::CORPSTRDIR_SHORT_CODE,
            self::DTDIR_SHORT_CODE,
            self::GODIR_SHORT_CODE,
            self::FRDIR_SHORT_CODE,
            self::CDDIR_SHORT_CODE,
            self::CUSTSUPPDIR_SHORT_CODE,
            self::ADMINDIR_SHORT_CODE,
            self::RDIR_SHORT_CODE,
        ];
    }

    /**
     * Get IT Management short codes.
     *
     * @return array<string>
     */
    private function itManagementShortCodes(): array
    {
        return [
            self::ITM_SHORT_CODE,
            self::ITPM_SHORT_CODE,
            self::ITCO_SHORT_CODE,
            self::ITOM_SHORT_CODE,
            self::CHANGEM_SHORT_CODE,
            self::CONFIGM_SHORT_CODE,
            self::ITRM_SHORT_CODE,
        ];
    }

    /**
     * Get IT Development short codes.
     *
     * @return array<string>
     */
    private function itDevelopmentShortCodes(): array
    {
        return [
            self::SDEV_SHORT_CODE,
            self::ITBA_SHORT_CODE,
            self::WD_SHORT_CODE,
            self::MAD_SHORT_CODE,
            self::ITPA_SHORT_CODE,
        ];
    }

    /**
     * Get IT Operations short codes.
     *
     * @return array<string>
     */
    private function itOperationsShortCodes(): array
    {
        return [
            self::SA_SHORT_CODE,
            self::NE_SHORT_CODE,
            self::DBA_SHORT_CODE,
            self::DA_SHORT_CODE,
            self::CSA_SHORT_CODE,
            self::ITS_SHORT_CODE,
            self::DE_SHORT_CODE,
            self::SECA_SHORT_CODE,
            self::ITSM_SHORT_CODE,
            self::ITVM_SHORT_CODE,
            self::ITAM_SHORT_CODE,
            self::ITDRS_SHORT_CODE,
            self::ITNA_SHORT_CODE,
            self::ITSE_SHORT_CODE,
            self::ITBCM_SHORT_CODE,
            self::ITQAA_SHORT_CODE,
            self::ISA_SHORT_CODE,
        ];
    }

    /**
     * Get IT Support short codes.
     *
     * @return array<string>
     */
    private function itSupportShortCodes(): array
    {
        return [
            self::CS_SHORT_CODE,
            self::HDT_SHORT_CODE,
            self::BIA_SHORT_CODE,
            self::ITT_SHORT_CODE,
            self::ITPS_SHORT_CODE,
            self::ITPA_SHORT_CODE,
        ];
    }
}
