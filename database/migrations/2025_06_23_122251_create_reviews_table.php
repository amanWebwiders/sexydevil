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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The reviewed user
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade'); // The one writing the review
            $table->unsignedTinyInteger('rating'); // Rating from 1 to 5 (or 10 if needed)
            $table->text('comment')->nullable();
            $table->boolean('photo_accurate')->default(false);
            $table->boolean('agreement_fulfilled')->default(false);
            $table->boolean('is_smoker')->default(false);
            $table->enum('hygiene', ['poor', 'average', 'excellent'])->nullable();
            $table->enum('ambience', ['poor', 'average', 'satisfying', 'very satisfying'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
