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
            $table->bigInteger('rotation_pos')->default(0)->after('unique_user_id');
            $table->integer('alloted_ups')->default(0)->after('rotation_pos');
            $table->index('rotation_pos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('rotation_pos'); 
            $table->dropColumn('rotation_pos');           
            $table->dropColumn('alloted_ups');           
        });
    }
};
