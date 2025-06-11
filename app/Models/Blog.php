<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    /**
     * HasFactory Used for model factories
     * SoftDeletes Enables soft delete functionality
     * Traits used by the user model:
     *
     * @use HasFactory<\Database\Factories\BlogFactory>
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
        'content',
        'approved',
        'approved_by',
        'approved_at',
        'denied',
        'denied_by',
        'denied_at',
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
        'approved_at' => 'datetime',
        'denied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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
     * Get all comments associated with the blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    /**
     * Get all likes associated with the blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(BlogLike::class);
    }

    /**
     * Get the user who created the blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted the blog (if soft deleted).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Get the user who approved the blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the user who denied the blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deniedBy()
    {
        return $this->belongsTo(User::class, 'denied_by');
    }
}
