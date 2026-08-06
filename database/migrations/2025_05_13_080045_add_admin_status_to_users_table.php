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
            //
             $table->string('admin_status')->default('pending')->after('type');
            $table->tinyInteger('user_status')->default(0)->after('admin_status')->comment('0 = unblock, 1 = block');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
              $table->dropColumn('admin_status');
        });
    }
};
