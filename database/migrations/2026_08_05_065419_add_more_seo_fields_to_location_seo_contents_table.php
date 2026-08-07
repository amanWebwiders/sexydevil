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
        Schema::table('location_seo_contents', function (Blueprint $table) {
            $table->string('meta_keywords')->nullable()->after('image_alt_text');
            $table->string('seo_url_slug')->nullable()->after('meta_keywords');
            $table->string('canonical_url')->nullable()->after('seo_url_slug');
            $table->string('robots_setting')->nullable()->after('canonical_url');
            $table->string('og_title')->nullable()->after('robots_setting');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('twitter_title')->nullable()->after('og_image');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('location_seo_contents', function (Blueprint $table) {
            $table->dropColumn([
                'meta_keywords', 'seo_url_slug', 'canonical_url', 'robots_setting',
                'og_title', 'og_description', 'og_image',
                'twitter_title', 'twitter_description', 'twitter_image'
            ]);
        });
    }
};
