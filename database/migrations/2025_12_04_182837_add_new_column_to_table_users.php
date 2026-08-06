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
            $table->tinyInteger('shows_in_current_window')->default(0);
            $table->timestamp('last_shown_at')->default(now());
            $table->index('last_shown_at');
            $table->index('shows_in_current_window');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('shows_in_current_window');
            $table->dropColumn('last_shown_at');
        });
    }
};
