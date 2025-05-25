<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

/**
 * @method bool isSuperAdmin()
 * @method bool isAdmin()
 * @method bool isUser()
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'name',
        'email',
        'password',
        'first_line',
        'second_line',
        'town',
        'city',
        'county',
        'country',
        'post_code',
        'full_time',
        'part_time',
        'role_id',
        'department_id',
        'created_by',
        'updated_by',
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
     * @method bool isSuperAdmin()
     */
    public function isSuperAdmin(): bool
    {
        return $this->role_id === Role::SUPER_ADMIN;
    }

    /**
     * @method bool isAdmin()
     */
    public function isAdmin(): bool
    {
        return $this->role_id === Role::ADMIN;
    }

    /**
     * @method bool isUser()
     */
    public function isUser()
    {
        return $this->role_id === Role::USER;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

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
}
