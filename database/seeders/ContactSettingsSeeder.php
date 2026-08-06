<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactSetting::create([
            "phone_no" => "(800) 123-45-67",
            "alter_phone_no" => "(800) 123-45-67",
            "email" => "test@gmail.com",
            "address" => "316 Tipple Road Philadelphia, PA 19143",
            "telegram_active" => 2,
            "telegram" => "https://telegram.org/",
            "facebook_active" => 2,
            "facebook" => "https://www.facebook.com/",
            "instagram_active" => 2,
            "intagram" => "https://www.instagram.com/",
            "whatsApp_no" => "+11 1111111111"
        ]);
    }
}
