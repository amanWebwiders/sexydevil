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
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone_no');
            $table->string('alter_phone_no');
            $table->string('email');
            $table->string('address');
            $table->tinyInteger('telegram_active')->default(0)->comment('1 = active, 2 = deactive');
            $table->string('telegram')->nullable();
            $table->tinyInteger('facebook_active')->default(0)->comment('1 = active, 2 = deactive');
            $table->string('facebook')->nullable();
            $table->tinyInteger('instagram_active')->default(0)->comment('1 = active, 2 = deactive');
            $table->string('intagram')->nullable();
            $table->string('whatsApp_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};
