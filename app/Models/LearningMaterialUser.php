<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterialUser extends Model
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
        'completed_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the learning material who this reloates to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LearningProvider>
     */
    public function learningMaterial()
    {
        return $this->belongsTo(LearningMaterial::class);
    }

    /**
     * Get the user who this reloates to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
