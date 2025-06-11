<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    /**
     * HasFactory Used for model factories
     * SoftDeletes Enables soft delete functionality
     * Traits used by the role model:
     *
     * @use HasFactory<\Database\Factories\RoleFactory>
     *
     * @see \Illuminate\Database\Eloquent\SoftDeletes
     */
    use HasFactory, SoftDeletes;

    /**
     * Contstants for role IDs against role names
     * Can be used as Role::SUPER_ADMIN, or Role::ADMIN
     */
    public const SUPER_ADMIN = 1;
    public const ADMIN = 2;
    public const USER = 3;

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
}
