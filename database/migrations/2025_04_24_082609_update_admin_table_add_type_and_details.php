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
        //
        Schema::table('admin', function (Blueprint $table) {
            $table->tinyInteger('type')
                ->default(0)
                ->comment('1 = User, 0 = Admin, 2 = Blocked')
                ->after('email');

            $table->string('phone')->nullable()->comment('Phone with country code')->after('type');
            $table->unsignedBigInteger('country_code_id')->nullable()->after('phone')->comment('Foreign key to country_codes');
            $table->text('description')->nullable()->after('country_code_id');
            $table->unsignedBigInteger('occupation_id')->nullable()->comment('Foreign key from occupations table')->after('description');
            $table->decimal('fee', 10, 2)->nullable()->comment('User-specific service fee')->after('occupation_id');
            $table->decimal('gst', 10, 2)->nullable()->comment('User-specific service gst')->after('fee');
            $table->decimal('total', 10, 2)->nullable()->comment('User-specific service total')->after('gst');
            $table->string('location')->nullable()->comment('User location')->after('fee');

                   });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn(['type', 'phone', 'description', 'occupation_id', 'fee', 'location']);
        });
    }
};
