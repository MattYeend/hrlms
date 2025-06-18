<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    /**
     * HasFactory Used for model factories
     * SoftDeletes Enables soft delete functionality
     * Traits used by the departments model:
     *
     * @use HasFactory<\Database\Factories\DepartmentFactory>
     *
     * @see \Illuminate\Database\Eloquent\SoftDeletes
     */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_default',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'restored_by',
        'restored_at',
        'dept_lead',
        'is_archived',
    ];

    /**
     * Get the department lead user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function deptLead()
    {
        return $this->belongsTo(User::class, 'dept_lead');
    }

    /**
     * Get the department's users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<User>
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the jobs associated with the department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<UserJob>
     */
    public function jobs()
    {
        return $this->hasMany(UserJob::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope a query to only include active departments.
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
     * Scope a query to only include archived departments.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }
}
