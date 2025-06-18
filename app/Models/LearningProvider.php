<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningProvider extends Model
{
    /**
     * HasFactory Used for model factories
     * SoftDeletes Enables soft delete functionality
     * Traits used by the blog likes model:
     *
     * @use HasFactory<\Database\Factories\LearningProviderFactory>
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
        'business_type_id',
        'first_line',
        'second_line',
        'town',
        'city',
        'county',
        'country',
        'postcode',
        'main_email_address',
        'first_phone_number',
        'second_phone_number',
        'person_to_contact',
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
     * Get the business type the provider is related to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<BusinessType>
     */
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
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
     * Get the quizs that the learning provider created
     *
     * @param \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the total number of quizzes created by this learning provider.
     *
     * @return int
     */
    public function quizzesCount()
    {
        return $this->quizzes()->count();
    }

    /**
     * Scope a query to only include active learning providers.
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
     * Scope a query to only include archived learning providers.
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
