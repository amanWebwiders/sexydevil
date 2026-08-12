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
            if (!Schema::hasColumn('uploaded_photos', 'custom_alt_text')) {
                $table->string('custom_alt_text')->nullable()->after('file_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uploaded_photos', function (Blueprint $table) {
            if (Schema::hasColumn('uploaded_photos', 'custom_alt_text')) {
                $table->dropColumn('custom_alt_text');
            }
        });
    }
};
