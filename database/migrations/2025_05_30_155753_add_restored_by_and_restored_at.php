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
            $table->unsignedBigInteger('restored_by')->nullable()->after('deleted_at');
            $table->timestamp('restored_at')->nullable()->after('restored_by');

            $table->foreign('restored_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedBigInteger('restored_by')->nullable()->after('deleted_at');
            $table->timestamp('restored_at')->nullable()->after('restored_by');

            $table->foreign('restored_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('restored_by')->nullable()->after('deleted_at');
            $table->timestamp('restored_at')->nullable()->after('restored_by');

            $table->foreign('restored_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['restored_by']);
            $table->dropColumn(['restored_by', 'restored_at']);
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['restored_by']);
            $table->dropColumn(['restored_by', 'restored_at']);
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['restored_by']);
            $table->dropColumn(['restored_by', 'restored_at']);
        });
    }
};
