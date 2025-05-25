<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'first_line', 'second_line', 'town', 'city', 'county',
        'country', 'postcode', 'phone', 'email', 'is_active', 'is_default',
        'created_by', 'updated_by', 'deleted_by',
    ];
}
