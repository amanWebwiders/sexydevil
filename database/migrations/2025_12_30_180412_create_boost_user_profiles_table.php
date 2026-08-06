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
        Schema::create('boost_user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('ups_quantity');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('boosted_from');
            $table->dateTime('boosted_to');
            $table->index('user_id');
            $table->index('boosted_from');
            $table->index('boosted_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boost_user_profiles');
    }
};
