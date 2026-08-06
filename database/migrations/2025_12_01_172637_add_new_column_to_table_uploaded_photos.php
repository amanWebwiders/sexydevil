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
        Schema::table('uploaded_photos', function (Blueprint $table) {
            $table->string('sequence')->nullable()->after('orignal_file_path');
            $table->tinyInteger('hide_show')->default('1')->after('sequence')->comment('1=show,2=hide');
            $table->index('sequence');
            $table->index('hide_show');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uploaded_photos', function (Blueprint $table) {
            $table->dropColumn('sequence');
            $table->dropColumn('hide_show');
        });
    }
};
