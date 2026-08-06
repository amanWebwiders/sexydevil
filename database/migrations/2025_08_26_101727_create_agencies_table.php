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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Agency name
            $table->string('headline')->nullable();
            $table->text('short_desc')->nullable();
            $table->longText('long_desc')->nullable();

            // Contact details
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('facebook')->nullable(); // can store JSON or links
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('telegram')->nullable();
            $table->string('website')->nullable();

            // Address
            $table->text('address')->nullable();

            // Media
            $table->string('photo')->nullable(); // main agency photo

            $table->timestamps();
        });
    }
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
