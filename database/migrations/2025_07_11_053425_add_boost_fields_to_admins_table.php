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
        Schema::table('admin', function (Blueprint $table) {
            //
            $table->integer('boost_days')->default(0)->after('type');
        $table->decimal('boost_cost', 8, 2)->default(0.00)->after('boost_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
        $table->dropColumn(['boost_days', 'boost_cost']);
    });
    }
};
