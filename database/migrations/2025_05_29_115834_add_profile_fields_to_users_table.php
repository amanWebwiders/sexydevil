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
            $table->foreignId('ethnicity_id')->nullable()->constrained('ethnicities')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->string('sexual_orientation')->nullable();
            $table->json('breast_size')->nullable();
            $table->boolean('incall_outcall')->nullable()->comment('1 = incall, 0 = outcall');
            $table->string('social_contact_method')->nullable()->comment('WhatsApp, SMS, Telegram, email, phone');
            $table->string('contact_detail')->nullable()->comment('Contact identifier');
            $table->string('sex_location')->nullable()->comment('e.g. nightclub, massage house, agency, independent');
            $table->integer('height_cm')->nullable();
            $table->integer('weight_kg')->nullable();
            $table->string('shoe_size')->nullable();
            $table->integer('displayed_age')->nullable();
            $table->string('tattoo')->nullable();
            $table->string('piercing')->nullable();
            $table->string('smoking')->nullable();

            $table->foreignId('oral_kissing_id')->nullable()->constrained('oral_kissings')->onDelete('set null');
            $table->foreignId('anal_related_option_id')->nullable()->constrained('anal_related_options')->onDelete('set null');
            $table->foreignId('cum_body_play_id')->nullable()->constrained('cum_body_plays')->onDelete('set null');
            $table->foreignId('manual_fingering_id')->nullable()->constrained('manual_fingerings')->onDelete('set null');
            $table->foreignId('massage_sensual_touch_id')->nullable()->constrained('massage_sensual_touches')->onDelete('set null');
            $table->foreignId('fetish_bdsm_id')->nullable()->constrained('fetish_bdsms')->onDelete('set null');
            $table->foreignId('group_special_experience_id')->nullable()->constrained('group_special_experiences')->onDelete('set null');
            $table->foreignId('media_virtual_option_id')->nullable()->constrained('media_virtual_options')->onDelete('set null');
            $table->foreignId('experience_id')->nullable()->constrained('experiences')->onDelete('set null');
            $table->text('service_notes')->nullable()->comment('Notes for private/phone only details');

            $table->foreignId('body_type_id')->nullable()->constrained('body_types')->onDelete('set null');
            $table->foreignId('hair_length_id')->nullable()->constrained('hair_lengths')->onDelete('set null');
            $table->foreignId('hair_type_id')->nullable()->constrained('hair_types')->onDelete('set null');
            $table->foreignId('hair_color_id')->nullable()->constrained('hair_colors')->onDelete('set null');
            $table->foreignId('eye_color_id')->nullable()->constrained('eye_colors')->onDelete('set null');
            $table->foreignId('tattoo_id')->nullable()->constrained('tattoos')->onDelete('set null');
            $table->foreignId('pubic_hair_id')->nullable()->constrained('pubic_hairs')->onDelete('set null');
            $table->json('blocked_countries')->nullable();
            $table->json('languages')->nullable();
             $table->json('contact_methods')->nullable();
            
            $table->string('onlyfans_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('telegram_link')->nullable();
            $table->string('tiktok_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ethnicity_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['sexual_orientation_id']);
            $table->dropForeign(['breast_size']);

            $table->dropForeign(['oral_kissing_id']);
            $table->dropForeign(['anal_related_option_id']);
            $table->dropForeign(['cum_body_play_id']);
            $table->dropForeign(['manual_fingering_id']);
            $table->dropForeign(['massage_sensual_touch_id']);
            $table->dropForeign(['fetish_bdsm_id']);
            $table->dropForeign(['group_special_experience_id']);
            $table->dropForeign(['media_virtual_option_id']);
            $table->dropForeign(['experience_id']);

            $table->dropColumn([
                'ethnicity_id',
                'state_id',
                'city_id',
                'sexual_orientation_id',
                'breast_size',
                'contact_method',
                'contact_detail',
                'sex_location',
                'height_cm',
                'weight_kg',
                'shoe_size',
                'rates',
                'oral_kissing_id',
                'anal_related_option_id',
                'cum_body_play_id',
                'manual_fingering_id',
                'massage_sensual_touch_id',
                'fetish_bdsm_id',
                'group_special_experience_id',
                'media_virtual_option_id',
                'experience_id',
                'service_notes',
                'blocked_countries',
                'languages',
                'onlyfans_link',
                'instagram_link',
                'telegram_link',
                'tiktok_link',
            ]);
        });
    }
};
