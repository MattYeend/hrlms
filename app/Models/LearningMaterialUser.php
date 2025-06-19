<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LearningMaterialUser extends Pivot
{
    /**
     * HasFactory Used for model factories
     * Traits used by the learning material user model:
     *
     * @use HasFactory<\Database\Factories\RoleFactory>
     */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * Laravel assumes the plural form (learning_material_users),
     * so we explicitly define
     * the correct singular table name used for this pivot-like model.
     */
    protected $table = 'learning_material_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'learning_material_id',
        'user_id',
        'status',
        'completed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'status' => 'integer',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Constants for status
     */
    public const STATUS_NOT_STARTED = 1;
    public const STATUS_STARTED = 2;
    public const STATUS_IN_PROGRESS = 3;
    public const STATUS_COMPLETED = 4; 

    /**
     * Get the learning material who this relates to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LearningProvider>
     */
    public function learningMaterial()
    {
        return $this->belongsTo(LearningMaterial::class);
    }

    /**
     * Get the user who this relates to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
