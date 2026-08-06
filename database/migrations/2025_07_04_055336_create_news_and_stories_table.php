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
        Schema::create('news_and_stories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // who is adding to wishlist (logged in user)
            $table->string('title')->nullable();
             $table->text('text'); // Supports emoji (UTF8MB4 by default)
             $table->text('emoji')->nullable();
            $table->json('images')->nullable(); // Store multiple image paths
            $table->json('videos')->nullable(); // Store multiple video paths

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_and_stories');
    }
};
