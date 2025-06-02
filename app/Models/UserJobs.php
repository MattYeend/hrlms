<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJobs extends Model
{
    /** @use HasFactory<\Database\Factories\UserJobsFactory> */
    use HasFactory, SoftDeletes;
}
