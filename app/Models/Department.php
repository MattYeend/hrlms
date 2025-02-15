<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Department extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    
    protected $fillable = [
        'name',
        'lead_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function lead() {
        return $this->belongsTo(User::class, 'lead_id');
    }
}
