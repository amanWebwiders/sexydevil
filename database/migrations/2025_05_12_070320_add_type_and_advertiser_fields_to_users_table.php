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
             $table->tinyInteger('type')->default(1)->comment('1 = Normal User, 2 = Advertiser');
            $table->string('slogan')->nullable();
            $table->decimal('rates', 8, 2)->nullable(); // adjust precision as needed
            $table->string('contact_method')->nullable();
            $table->text('description')->nullable();
            $table->string('verify_age_document')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
             $table->dropColumn([
                'type',
                'slogan',
                'rates',
                'contact_method',
                'description',
                'verify_age_document',
            ]);
        });
    }
};
