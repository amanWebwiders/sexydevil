<?php

namespace Database\Seeders;

use App\Models\TermsCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermsConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TermsCondition::create([
            "name" => "Terms of Service",
            "content" => '<div class="content-section">
            <h2><i class="fas fa-file-contract section-icon"></i>Terms of Service</h2>
            <p>Welcome to Elite Companions. By accessing our website and using our services, you agree to comply with and be bound by the following terms and conditions.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-user-tie section-icon"></i>Eligibility</h3>
            <p>You must be at least 18 years of age to use our website and services. By using Elite Companions, you represent and warrant that you are of legal age.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-handshake section-icon"></i>Services</h3>
            <p>Elite Companions provides a platform to connect clients with companionship services. We are not directly involved in the actual provision of companionship services and act solely as an intermediary.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-credit-card section-icon"></i>Payments and Fees</h3>
            <p>All services are subject to availability and at the rates displayed on our website. Payment must be made in advance through our secure payment system. We accept various forms of payment as indicated on our website.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-calendar-times section-icon"></i>Cancellation Policy</h3>
            <p>Cancellations made more than 24 hours in advance will receive a full refund. Cancellations made within 24 hours of the scheduled time may be subject to a cancellation fee. No-shows will be charged the full amount.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-ban section-icon"></i>Prohibited Activities</h3>
            <p>You agree not to:</p>
            <ul>
                <li>Use our services for any illegal purposes or solicit illegal activities.</li>
                <li>Harass, abuse, or harm another person.</li>
                <li>Impersonate any person or entity or falsely state your affiliation with a person or entity.</li>
                <li>Interfere with or disrupt the service or servers connected to the service.</li>
                <li>Attempt to gain unauthorized access to any portion of the website or any other systems connected to the service.</li>
            </ul>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-exclamation-triangle section-icon"></i>Limitation of Liability</h3>
            <p>Elite Companions shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from the use or inability to use our services or for the cost of procurement of substitute services.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-gavel section-icon"></i>Governing Law</h3>
            <p>These terms shall be governed by and construed in accordance with the laws of the jurisdiction in which we operate, without regard to its conflict of law provisions.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-pencil-alt section-icon"></i>Changes to Terms</h3>
            <p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting to the website. Your continued use of the service after any changes constitutes your acceptance of the new terms.</p>
        </div>'
        ]);

        TermsCondition::create([
            "name" => "Privacy Policy",
            "content" => '<div class="content-section">
            <h2><i class="fas fa-user-shield section-icon"></i>Privacy Policy</h2>
            <p>At Elite Companions, your privacy is of utmost importance to us. This Privacy Policy outlines how we collect, use, and safeguard your information when you visit our website and use our services.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-info-circle section-icon"></i>Information We Collect</h3>
            <p>We may collect the following types of information:</p>
            <ul>
                <li><span class="highlight">Personal Information:</span> Name, email address, phone number, and any details you voluntarily share through our contact forms or registration process.</li>
                <li><span class="highlight">Booking Information:</span> Details about requested services, dates, times, and special preferences.</li>
                <li><span class="highlight">Communication Data:</span> Messages, inquiries, and other communications you send to us.</li>
                <li><span class="highlight">Technical Data:</span> IP address, browser type, device information, and pages visited on our site.</li>
            </ul>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-cogs section-icon"></i>How We Use Your Information</h3>
            <p>We use your information for the following purposes:</p>
            <ul>
                <li>To communicate with you regarding services, bookings, and inquiries.</li>
                <li>To process transactions and arrange services.</li>
                <li>To improve our website and offerings based on your feedback and interactions.</li>
                <li>To maintain the security and integrity of our platform.</li>
                <li>To comply with legal obligations and prevent fraudulent activities.</li>
            </ul>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-cookie section-icon"></i>Cookies and Tracking Technologies</h3>
            <p>We use cookies and similar technologies to enhance your browsing experience. Cookies help us remember your preferences and understand how you use our site. You can control cookies through your browser settings.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-share-alt section-icon"></i>Sharing of Information</h3>
            <p>We do not sell, trade, or rent your personal information to third parties. However, we may share information with:</p>
            <ul>
                <li>Trusted partners who assist us in operating the website and providing services.</li>
                <li>Legal authorities when required by law or to protect our rights and safety.</li>
                <li>Service providers who perform functions on our behalf, such as payment processing.</li>
            </ul>
            <p>All third parties are required to maintain the confidentiality and security of your information.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-lock section-icon"></i>Data Security</h3>
            <p>We implement appropriate technical and organizational measures to protect your data against unauthorized access, alteration, disclosure, or destruction. All sensitive information is encrypted during transmission and stored securely.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-link section-icon"></i>Third-Party Links</h3>
            <p>Our website may contain links to third-party websites. We are not responsible for the privacy practices or content of such external sites. We encourage you to review the privacy policies of any third-party sites you visit.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-user-check section-icon"></i>Your Rights</h3>
            <p>You have the right to:</p>
            <ul>
                <li>Access, correct, or delete your personal data.</li>
                <li>Object to or restrict the processing of your information.</li>
                <li>Data portability for the information you`ve provided.</li>
                <li>Withdraw consent at any time, where we rely on consent to process your information.</li>
            </ul>
            <p>To exercise your rights, please contact us at privacy@elitecompanions.com.</p>
        </div>

        <div class="content-block">
            <h3><i class="fas fa-exchange-alt section-icon"></i>Changes to This Privacy Policy</h3>
            <p>We reserve the right to update or modify this Privacy Policy at any time. Any changes will be posted on this page with an updated effective date. We encourage you to review this policy periodically.</p>
        </div>
'
        ]);
    }
}
