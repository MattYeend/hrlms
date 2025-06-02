<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJob extends Model
{
    /** @use HasFactory<\Database\Factories\UserJobsFactory> */
    use HasFactory, SoftDeletes;

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
}
