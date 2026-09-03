<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // For Advertisers
            [
                'question' => 'Who can advertise in our directory?',
                'answer' => 'Any independent escort, escort agency, massage salon, or erotic entertainment venue offering professional adult companionship services can advertise on our platform provided they meet our verification standards and terms of service.',
                'category' => 'For Advertisers',
                'order' => 1,
                'status' => 1,
            ],
            [
                'question' => 'I am an independent escort provider. How can I register an Ad?',
                'answer' => 'To register as an independent provider, click on the "Sign up" button in the top menu, choose "Escort / Provider", fill in your personal details, upload your best photos for verification, set your services and rates, and your profile will be published once approved.',
                'category' => 'For Advertisers',
                'order' => 2,
                'status' => 1,
            ],
            [
                'question' => 'I have an agency. How can we register an Ad?',
                'answer' => 'Agencies can register easily through our Agency registration portal. Once registered, you will have access to a dedicated agency dashboard allowing you to add, manage, and schedule multiple models simultaneously with full analytics.',
                'category' => 'For Advertisers',
                'order' => 3,
                'status' => 1,
            ],
            [
                'question' => 'I have a strip club/cabaret. How can we register an Ad?',
                'answer' => 'Strip clubs, cabarets, and erotic clubs can register under our Sex Locations / Venues section. Fill out the business details form or get in touch with our 24/7 support team to arrange tailored venue packages.',
                'category' => 'For Advertisers',
                'order' => 4,
                'status' => 1,
            ],
            [
                'question' => 'Is advertising for free?',
                'answer' => 'We provide flexible advertising options including standard free listings as well as VIP boost packages that place your profile at the top of search results, city pages, and featured carousel sections for maximum visibility.',
                'category' => 'For Advertisers',
                'order' => 5,
                'status' => 1,
            ],
            [
                'question' => 'How do I make a great profile?',
                'answer' => 'To make a standout profile: use bright, high-resolution original photos, write a detailed and friendly description, list all your special services clearly, keep your working hours up-to-date, and get your profile verified with our badge.',
                'category' => 'For Advertisers',
                'order' => 6,
                'status' => 1,
            ],

            // For Members and Visitors
            [
                'question' => 'How do I contact an escort or model?',
                'answer' => 'You can reach out directly to any provider using the verified contact methods shown on their profile, including direct phone call, WhatsApp, and Telegram. We do not charge any booking fees to clients.',
                'category' => 'For Members and Visitors',
                'order' => 7,
                'status' => 1,
            ],
            [
                'question' => 'Are model profiles verified?',
                'answer' => 'Yes, our moderation team inspects submitted photos and IDs through our internal verification system. Look for the "Verified" badge on profiles for guaranteed authentic pictures and details.',
                'category' => 'For Members and Visitors',
                'order' => 8,
                'status' => 1,
            ],
            [
                'question' => 'How can I save favorites and leave reviews?',
                'answer' => 'Create a free member account to save your favorite models, track new uploads and stories, and leave authentic feedback and ratings to help the community.',
                'category' => 'For Members and Visitors',
                'order' => 9,
                'status' => 1,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
