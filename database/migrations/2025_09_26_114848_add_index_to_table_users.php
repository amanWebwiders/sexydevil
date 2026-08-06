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
            $table->index('type');
            $table->index('top3status');
            $table->index('user_status');
            $table->index('admin_status');
            $table->index('is_boosted');
            $table->index('plan_start_date');
            $table->index('plan_id');
            $table->index('created_at');
            $table->index('gender_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('type');
            $table->dropIndex('top3status');
            $table->dropIndex('user_status');
            $table->dropIndex('admin_status');
            $table->dropIndex('is_boosted');
            $table->dropIndex('plan_start_date');
            $table->dropIndex('plan_id');
            $table->dropIndex('created_at');
            $table->dropIndex('gender_id');
        });
    }
};
