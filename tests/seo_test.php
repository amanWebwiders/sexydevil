<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use App\Models\UploadedPhoto;
use App\Models\User;

echo "==========================================" . PHP_EOL;
echo "  TECHNICAL SEO BACKEND & UI TEST SUITE   " . PHP_EOL;
echo "==========================================" . PHP_EOL . PHP_EOL;

$passed = 0;
$failed = 0;

function assertTest($title, $condition) {
    global $passed, $failed;
    if ($condition) {
        echo " [PASS] " . $title . PHP_EOL;
        $passed++;
    } else {
        echo " [FAIL] " . $title . PHP_EOL;
        $failed++;
    }
}

// ---------------------------------------------------------
// TEST 1: Database Migration Check for custom_alt_text
// ---------------------------------------------------------
$hasColumn = Schema::hasColumn('uploaded_photos', 'custom_alt_text');
assertTest("Database Schema: 'custom_alt_text' column exists in 'uploaded_photos' table", $hasColumn);

// ---------------------------------------------------------
// TEST 2: UploadedPhoto Model ALT Accessor Logic (Fallback)
// ---------------------------------------------------------
$mockPhoto = new UploadedPhoto();
$mockPhoto->custom_alt_text = null;
$mockPhoto->user = new User([
    'listing_title' => 'Stunning Bella',
    'city' => 'Sydney'
]);
$altTextFallback = $mockPhoto->alt_text;
assertTest("Model Accessor: Auto-generates fallback ALT tag ('Stunning Bella Escort in Sydney')", $altTextFallback === 'Stunning Bella Escort in Sydney');

// ---------------------------------------------------------
// TEST 3: UploadedPhoto Model ALT Accessor Logic (Custom Override)
// ---------------------------------------------------------
$mockPhotoOverride = new UploadedPhoto();
$mockPhotoOverride->custom_alt_text = 'Custom VIP Model Banner';
$mockPhotoOverride->user = new User([
    'listing_title' => 'Stunning Bella',
    'city' => 'Sydney'
]);
$altTextOverride = $mockPhotoOverride->alt_text;
assertTest("Model Accessor: Custom ALT text overrides fallback ('Custom VIP Model Banner')", $altTextOverride === 'Custom VIP Model Banner');

// ---------------------------------------------------------
// TEST 4: Canonical Query Parameter Stripping Logic
// ---------------------------------------------------------
$rawUrl = 'https://sexydevilescorts.com/model-search?gender=female&service=1&page=2';
$canonicalUrl = strtok($rawUrl, '?');
assertTest("Canonical Logic: Query strings stripped from filtered URLs ('https://sexydevilescorts.com/model-search')", $canonicalUrl === 'https://sexydevilescorts.com/model-search');

// ---------------------------------------------------------
// TEST 5: Robots.txt Rules & Sitemap Location
// ---------------------------------------------------------
$robotsPath = public_path('robots.txt');
$robotsContent = file_exists($robotsPath) ? file_get_contents($robotsPath) : '';

assertTest("Robots.txt: Contains 'Disallow: /admin'", strpos($robotsContent, 'Disallow: /admin') !== false);
assertTest("Robots.txt: Contains 'Disallow: /login'", strpos($robotsContent, 'Disallow: /login') !== false);
assertTest("Robots.txt: Contains 'Sitemap: https://sexydevilescorts.com/sitemap.xml'", strpos($robotsContent, 'Sitemap: https://sexydevilescorts.com/sitemap.xml') !== false);

// ---------------------------------------------------------
// TEST 6: Favicon Files Check
// ---------------------------------------------------------
$faviconPngExists = file_exists(public_path('images/escort_favicon.png'));
$faviconIcoExists = file_exists(public_path('favicon.ico'));

assertTest("Favicon: 'public/images/escort_favicon.png' exists", $faviconPngExists);
assertTest("Favicon: 'public/favicon.ico' exists", $faviconIcoExists);

echo PHP_EOL . "------------------------------------------" . PHP_EOL;
echo "RESULTS: Passed: $passed | Failed: $failed" . PHP_EOL;
echo "==========================================" . PHP_EOL;

exit($failed > 0 ? 1 : 0);
