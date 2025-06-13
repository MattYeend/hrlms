<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    /**
     * HasFactory Used for model factories
     * Traits used by the quiz user model:
     *
     * @use HasFactory<\Database\Factories\RoleFactory>
     */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * Laravel assumes the plural form (quiz_users), so we explicitly define
     * the correct singular table name used for this pivot-like model.
     */
    protected $table = 'quiz_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'quiz_id',
        'user_id',
        'completed_at',
        'score',
        'passed',
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
     * Get the quiz who this reloates to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the user who this reloates to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
