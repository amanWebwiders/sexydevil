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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->date('dob')->nullable();
           $table->foreignId('country_id')->nullable()->constrained('country_codes');
            $table->string('document_image')->nullable();
            $table->string('holding_document_image')->nullable();
                $table->string('identity_photos')->nullable();
                $table->string('nickname')->nullable();
                $table->string('nationality')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
