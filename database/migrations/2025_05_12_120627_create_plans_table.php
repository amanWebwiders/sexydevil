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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
             $table->string('title');
            $table->string('heading')->nullable();
            $table->string('tag')->nullable();
            $table->integer('days');
            $table->text('description')->nullable();
            $table->decimal('cost', 8, 2); // e.g. 999999.99 max
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
