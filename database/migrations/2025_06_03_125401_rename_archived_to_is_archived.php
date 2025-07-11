<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('archived', 'is_archived');
        });

        Schema::table('user_jobs', function (Blueprint $table) {
            $table->renameColumn('archived', 'is_archived');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->renameColumn('archived', 'is_archived');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('is_archived', 'archived');
        });

        Schema::table('user_jobs', function (Blueprint $table) {
            $table->renameColumn('is_archived', 'archived');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->renameColumn('is_archived', 'archived');
        });
    }
};
