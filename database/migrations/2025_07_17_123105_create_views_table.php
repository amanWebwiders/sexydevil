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
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('viewer_id')->nullable(); // The user who viewed
            $table->unsignedBigInteger('viewed_id');             // The user who was viewed
            $table->string('viewed_type')->nullable();           // Optional: to support polymorphic types
            $table->ipAddress('ip_address')->nullable();         // IP tracking
            $table->timestamps();

            $table->foreign('viewer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('viewed_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('views');
    }
};
