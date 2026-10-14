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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();

            $table->string('featured_image')->nullable()->comment('Path relative to public/');
            $table->string('featured_image_alt')->nullable();
            $table->string('featured_video')->nullable()->comment('Uploaded video path relative to public/');
            $table->string('featured_video_url', 500)->nullable()->comment('YouTube / Vimeo / Dailymotion URL');
            $table->enum('featured_media_type', ['image', 'video'])->default('image');

            $table->foreignId('author_id')->nullable()->constrained('admin')->nullOnDelete();
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft');
            $table->dateTime('published_at')->nullable()->comment('Go-live time; future value + scheduled status = scheduled');

            // Location master data lives in imported tables without FK-friendly engines, so index only
            // (same approach as location_seo_contents).
            $table->unsignedMediumInteger('country_id')->nullable()->index();
            $table->unsignedMediumInteger('state_id')->nullable()->index();
            $table->unsignedMediumInteger('city_id')->nullable()->index();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url', 500)->nullable();
            $table->enum('robots_index', ['index', 'noindex'])->default('index');
            $table->enum('robots_follow', ['follow', 'nofollow'])->default('follow');

            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
