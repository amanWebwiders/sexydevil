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
            $table->boolean('quickie_enabled')->default(false);
            $table->string('quickie_currency')->nullable();
            $table->json('quickie_rates')->nullable(); // Store all durations' prices in JSON
            $table->integer('quickie_overnight_hours')->nullable(); // e.g., 8 hours for overnight
            $table->string('payment_method')->nullable();
            $table->boolean('is_boosted')->default(0);
            $table->date('boost_start_date')->nullable();
            $table->date('boost_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'quickie_enabled',
                'payment_method',
                'quickie_currency',
                'quickie_rates',
                'quickie_overnight_hours'
            ]);
        });
    }
};
