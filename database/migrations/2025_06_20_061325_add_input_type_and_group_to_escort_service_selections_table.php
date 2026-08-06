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
        Schema::table('escort_service_selections', function (Blueprint $table) {
            $table->enum('input_type', ['checkbox', 'radio'])->default('checkbox')->after('name');
            $table->string('value_group')->nullable()->after('input_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('escort_service_selections', function (Blueprint $table) {
        $table->dropColumn(['input_type', 'value_group']);
    });
    }
};
