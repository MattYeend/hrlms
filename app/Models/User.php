<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;
use App\Models\Department;
use App\Models\JobTitle;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'profile_picture',
        'cv_path',
        'cover_letter_path',
        'phone',
        'salary',
        'first_line',
        'second_line',
        'town',
        'city',
        'county',
        'country',
        'post_code',
        'full_or_part',
        'region',
        'timezone',
        'start_date',
        'end_date',
        'office_based',
        'remote_based',
        'hybrid_based',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
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

    public function role() {
        return $this->belongsTo(Role::class);
    }
    
    public function department() {
        return $this->belongsTo(Department::class);
    }
    
    public function jobTitle() {
        return $this->belongsTo(JobTitle::class);
    }

    public function isSuperAdmin()
    {
        return $this->role && $this->role->name === 'Super Admin';
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'Admin';
    }

    public function isDepartmentLead()
    {
        return $this->role && $this->role->name === 'Department Lead';
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(){
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function cSuite(){
        $cSuiteCodes = [
            'OWN', // OWNER
            'CEO', // Chief Executive Officer
            'COO', // Chief Operations Officer
            'CFO', // Chief Financial Officer
            'CTO', // Chief Technology Officer
            'CMO', // Chief Marketing Officer
            'CIO', // Chief Information Officer
            'CCO', // Chief Compliance Officer
            'CRO', // Chief Risk Officer
            'CDO', // Chief Data Officer
            'CCO', // Chief Customer Officer
            'CSO', // Chief Strategy Officer
            'CEO', // Chief Engineering Officer
            'CHRO' // Chief HR Officer
        ];
        return $this->job && in_array($this->job->code, $cSuiteCodes);
    }

    public function hrStaff(){
        $hrStaffCodes = [
            'CHRO', // Chief HR Officer
            'HRM', // Human Resources Manager
            'HRG', // HR Generalist
            'REC', // Recruitment Specialist
            'HRC', // HR Coordinator
            'CBS', // Compensation and Benefits Specialist
            'TDM', // Training and Development Manager
            'ERS', // Employee Relations Specialist
            'HRAN', // HR Analyst
            'HRAS', // HR Assistant
            'HRD' // HR Director
        ];
        return $this->job && in_array($this->job->code, $hrStaffCodes);
    }

    public function getShortName(): string{
        return $this->first_name;
    }

    public function getName(): string{
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullNameLong(): string {
        return $this->title . ' ' . $this->first_name . ($this->middle_name ? ' ' . $this->middle_name : '') . ' ' . $this->last_name;
    }

    public function getFullNameShort(): string{
        return $this->first_name[0] . ' ' . $this->last_name;
    }
}
