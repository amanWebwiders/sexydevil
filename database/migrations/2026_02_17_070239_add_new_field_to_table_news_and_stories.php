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
        Schema::table('news_and_stories', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('videos')->comment('Path to thumbnail image for videos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_and_stories', function (Blueprint $table) {
            $table->dropColumn('thumbnail');
        });
    }
};
