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
        Schema::create('user_escort_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('escort_service_categories')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('escort_services')->onDelete('cascade');
            $table->foreignId('selection_id')->nullable()->constrained('escort_service_selections')->onDelete('cascade');
            $table->unique(['user_id', 'category_id', 'service_id', 'selection_id'], 'user_service_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_escort_services');
    }
};
