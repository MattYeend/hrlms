<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningMaterial extends Model
{
    /**
     * HasFactory Used for model factories
     * SoftDeletes Enables soft delete functionality
     * Traits used by the blog likes model:
     *
     * @use HasFactory<\Database\Factories\LearningMaterialFactory>
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
        'title',
        'slug',
        'key_objectives',
        'description',
        'file_path',
        'learning_provider_id',
        'department_id',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'restored_at' => 'datetime',
    ];

    /**
     * Get the unique identifier for the blog.
     * This method is used by route model binding to
     * retrieve the blog by their slug.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the user who created the learning provider.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the learning provider.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted the learning provider.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Get the learning provider that the material belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LearningProvider>
     */
    public function learningProvider()
    {
        return $this->belongsTo(
            LearningProvider::class,
            'learning_provider_id'
        );
    }

    /**
     * Get the department that the material belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Department>
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Scope a query to only include active learning material.
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
     * Scope a query to only include archived learning material.
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
     * Get the users that have completed the material
     *
     *  @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function completedBy()
    {
        return $this->belongsToMany(User::class, 'learning_material_user')
            ->withTimestamps();
    }

    /**
     * Get the users that have started the material
     *
     *  @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hasStarted()
    {
        return $this->belongsToMany(User::class, 'learning_material_user')
            ->wherePivot('status', '!=', 1)
            ->withTimestamps();
    }
}
