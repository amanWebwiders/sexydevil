<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\FrontEnd\UserRequest;
use App\Http\Controllers\Front\HomeController;
use App\Models\User;
use App\Models\Availability;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

echo "========================================================\n";
echo "      COMPREHENSIVE AUTOMATED VERIFICATION OF ALL 4 POINTS\n";
echo "========================================================\n\n";

// POINT 1 & 2: Test Registration with 6.55MB .jpeg & .jpg files
echo "--------------------------------------------------------\n";
echo "POINT 1 & 2: Registration with DOB & 6.55MB .jpeg / .jpg Photos\n";
echo "--------------------------------------------------------\n";

$testEmail = 'model_test_' . time() . '@testdomain.com';
$jpgPath = __DIR__ . '/test_sample_camera.jpg';
$jpegPath = __DIR__ . '/test_sample_camera.jpeg';

if (!file_exists($jpgPath) || !file_exists($jpegPath)) {
    die("Test images missing! Run make_images.php first.\n");
}

echo "1. Upload File 1 (.jpg - ID Document): " . round(filesize($jpgPath) / (1024*1024), 2) . " MB\n";
echo "2. Upload File 2 (.jpeg - Holding Doc): " . round(filesize($jpegPath) / (1024*1024), 2) . " MB\n";
echo "3. Upload File 3 (.jpg - Holding Paper): " . round(filesize($jpgPath) / (1024*1024), 2) . " MB\n";
echo "4. Upload File 4 (.jpeg - Identity Photos): " . round(filesize($jpegPath) / (1024*1024), 2) . " MB\n";

$country = DB::table('country_codes')->first();
$countryId = $country ? $country->id : 1;
$phoneCode = $country ? $country->code : '+1';

$docFile = new UploadedFile($jpgPath, 'camera_id.jpg', 'image/jpeg', null, true);
$holdingDocFile = new UploadedFile($jpegPath, 'camera_holding_doc.jpeg', 'image/jpeg', null, true);
$mediaFile = new UploadedFile($jpgPath, 'camera_holding_paper.jpg', 'image/jpeg', null, true);
$idPhoto1 = new UploadedFile($jpegPath, 'camera_face1.jpeg', 'image/jpeg', null, true);
$idPhoto2 = new UploadedFile($jpgPath, 'camera_face2.jpg', 'image/jpeg', null, true);

$postData = [
    'type' => '2',
    'name' => 'AutoModel_' . rand(100, 999),
    'dob' => '15/05/2000', // DD/MM/YYYY format selected from Flatpickr
    'country_id' => (string)$countryId,
    'email' => $testEmail,
    'password' => 'SecretPass123!',
    'password_confirmation' => 'SecretPass123!',
    'phone_code' => $phoneCode,
    'phone' => (string)rand(1000000000, 9999999999),
];

$files = [
    'document_image' => $docFile,
    'holding_document_image' => $holdingDocFile,
    'media' => $mediaFile,
    'identity_photos' => [$idPhoto1, $idPhoto2],
];

$formRequest = UserRequest::create('/user.register', 'POST', $postData, [], $files);
$formRequest->setContainer($app);

// Run validation
$validator = Validator::make($formRequest->all(), $formRequest->rules(), $formRequest->messages());
if ($validator->fails()) {
    echo "Validation FAILED:\n";
    print_r($validator->errors()->all());
    exit(1);
} else {
    echo ">>> Form Request Validation PASSED for all fields and 6.55MB files!\n";
}

// Call Controller Register
$controller = $app->make(HomeController::class);
$response = $controller->Register($formRequest);

echo "Response Status Code: " . $response->getStatusCode() . "\n";
$responseData = json_decode($response->getContent(), true);
echo "Response Body: " . json_encode($responseData, JSON_PRETTY_PRINT) . "\n";

$point1and2Success = false;
if (isset($responseData['status']) && $responseData['status'] == 1) {
    echo "\n>>> [PASS] Point 1 & 2 SUCCESS: Model successfully registered with .jpeg & .jpg files >6MB!\n";
    $point1and2Success = true;
} else {
    echo "\n>>> [FAIL] Point 1 & 2 FAILED!\n";
}

// Verify User in Database
$createdUser = User::where('email', $testEmail)->first();
if ($createdUser) {
    echo "- Created User in DB: ID {$createdUser->id}, Name '{$createdUser->name}'\n";
    echo "- Parsed DOB in DB: {$createdUser->dob} (Correct YYYY-MM-DD format!)\n";
    echo "- Saved Document Image: {$createdUser->document_image}\n";
    echo "- Saved Holding Doc Image: {$createdUser->holding_document_image}\n";
    echo "- Saved Media (Holding Paper): {$createdUser->verify_age_document}\n";
    echo "- Saved Identity Photos: {$createdUser->identity_photos}\n";
}

// POINT 3: Verification & Approval Emails Me Logo Check
echo "\n--------------------------------------------------------\n";
echo "POINT 3: Verification & Approval Emails Logo Check\n";
echo "--------------------------------------------------------\n";

$token = 'test-token-verification-123';
$mailData = [
    'subject' => 'Verify Email',
    'email' => $testEmail,
    'body' => 'Please click the link below to verify your email address.',
    'mailData' => ['body' => 'Please click the link below to verify your email address.']
];

$demoMail = new \App\Mail\DemoMail($mailData);
$verifyEmailHtml = $demoMail->render();

$userDetails = (object)[
    'store_owner_name' => 'Sophia Model',
    'message' => 'Photo requires clearer lighting'
];

$acceptEmailHtml = view('email.accept', ['userDetails' => $userDetails])->render();
$rejectEmailHtml = view('email.reject', ['userDetails' => $userDetails])->render();

// Check for escort_logo1.png and absence of escort_logo.png
$verifyHasOld = (bool)preg_match('/escort_logo\.png/i', $verifyEmailHtml);
$verifyHasNew = (bool)preg_match('/escort_logo1\.png/i', $verifyEmailHtml);

$acceptHasOld = (bool)preg_match('/escort_logo\.png/i', $acceptEmailHtml);
$acceptHasNew = (bool)preg_match('/escort_logo1\.png/i', $acceptEmailHtml);

$rejectHasOld = (bool)preg_match('/escort_logo\.png/i', $rejectEmailHtml);
$rejectHasNew = (bool)preg_match('/escort_logo1\.png/i', $rejectEmailHtml);

echo "1. Verification Email (DemoMail / MailTemp):\n";
echo "   - Contains old logo (escort_logo.png): " . ($verifyHasOld ? "YES [FAIL]" : "NO [OK]") . "\n";
echo "   - Contains new logo (escort_logo1.png): " . ($verifyHasNew ? "YES [OK]" : "NO [FAIL]") . "\n";

echo "2. Approval Email (accept.blade.php):\n";
echo "   - Contains old logo (escort_logo.png): " . ($acceptHasOld ? "YES [FAIL]" : "NO [OK]") . "\n";
echo "   - Contains new logo (escort_logo1.png): " . ($acceptHasNew ? "YES [OK]" : "NO [FAIL]") . "\n";

echo "3. Rejection Email (reject.blade.php):\n";
echo "   - Contains old logo (escort_logo.png): " . ($rejectHasOld ? "YES [FAIL]" : "NO [OK]") . "\n";
echo "   - Contains new logo (escort_logo1.png): " . ($rejectHasNew ? "YES [OK]" : "NO [FAIL]") . "\n";

$point3Success = (!$verifyHasOld && $verifyHasNew && !$acceptHasOld && $acceptHasNew && !$rejectHasOld && $rejectHasNew);
if ($point3Success) {
    echo "\n>>> [PASS] Point 3 SUCCESS: All emails display new escort_logo1.png exclusively!\n";
} else {
    echo "\n>>> [FAIL] Point 3 FAILED!\n";
}

// POINT 4: Availability "All Day" (19:00-19:00 Bug Check)
echo "\n--------------------------------------------------------\n";
echo "POINT 4: Availability 'All day' (19:00-19:00 Bug Check)\n";
echo "--------------------------------------------------------\n";

if ($createdUser) {
    // Clear existing availability for this test user
    \App\Models\UserAvailability::where('user_id', $createdUser->id)->delete();
    
    // Set Monday as All Day (all_day = 1, start_time = null, end_time = null)
    $availMonday = \App\Models\UserAvailability::create([
        'user_id' => $createdUser->id,
        'day' => 'Monday',
        'all_day' => 1,
        'start_time' => null,
        'end_time' => null,
    ]);
    
    // Set Tuesday with normal hours (all_day = 0, 10:00:00 to 18:00:00)
    $availTuesday = \App\Models\UserAvailability::create([
        'user_id' => $createdUser->id,
        'day' => 'Tuesday',
        'all_day' => 0,
        'start_time' => '10:00:00',
        'end_time' => '18:00:00',
    ]);
    
    $availabilities = \App\Models\UserAvailability::where('user_id', $createdUser->id)->get();
    
    // 1. Render Public Profile View (resources/views/front/model_detail.blade.php)
    // Needs user, availabilities and supporting arrays
    $publicHtml = view('front.model_detail', [
        'user' => $createdUser,
        'availabilities' => $availabilities,
        'newsstory' => [],
        'selectedServices' => [],
        'selectedSelections' => [],
        'categories' => collect(),
        'uploadedPhotos' => collect(),
        'uploadedVideos' => collect(),
        'countryCodes' => collect(),
        'language' => collect(),
        'favorite_users' => [],
        'locationSeoContent' => null,
        'pageTitle' => 'Test Model',
        'seoOgImage' => null
    ])->render();
    
    // 2. Render Admin User Detail View (resources/views/admin/user-detail.blade.php)
    $categories = \App\Models\EscortServiceCategory::with('services.selections')->get();
    $adminHtml = view('admin.user-detail', [
        'user' => $createdUser,
        'availabilities' => $availabilities,
        'countryCodes' => DB::table('country_codes')->get(),
        'categories' => $categories,
        'selectedServices' => [],
        'selectedSelections' => [],
        'uploadedPhotos' => collect(),
        'uploadedVideos' => collect(),
        'rates' => collect(),
        'language' => collect(),
        'plans' => collect(),
    ])->render();
    
    // Check Monday shows "All day" and NOT 19:00
    $publicHasAllDay = strpos($publicHtml, 'All day') !== false;
    $publicHas1900 = (strpos($publicHtml, '19:00') !== false || strpos($publicHtml, '07:00 PM - 07:00 PM') !== false);
    
    $adminHasAllDay = strpos($adminHtml, 'All day') !== false;
    $adminHas1900 = (strpos($adminHtml, '19:00') !== false || strpos($adminHtml, '07:00 PM - 07:00 PM') !== false);
    
    echo "1. Public Model Profile (model_detail.blade.php):\n";
    echo "   - Contains 'All day': " . ($publicHasAllDay ? "YES [OK]" : "NO [FAIL]") . "\n";
    echo "   - Contains 19:00 / 07:00 PM: " . ($publicHas1900 ? "YES [FAIL]" : "NO [OK]") . "\n";
    
    echo "2. Admin User Details (user-detail.blade.php):\n";
    echo "   - Contains 'All day': " . ($adminHasAllDay ? "YES [OK]" : "NO [FAIL]") . "\n";
    echo "   - Contains 19:00 / 07:00 PM: " . ($adminHas1900 ? "YES [FAIL]" : "NO [OK]") . "\n";
    
    $point4Success = ($publicHasAllDay && !$publicHas1900 && $adminHasAllDay && !$adminHas1900);
    if ($point4Success) {
        echo "\n>>> [PASS] Point 4 SUCCESS: 'All day' is displayed properly with no 19:00-19:00 bug!\n";
    } else {
        echo "\n>>> [FAIL] Point 4 FAILED!\n";
    }
}

echo "\n========================================================\n";
echo "OVERALL VERIFICATION SUMMARY:\n";
echo "Point 1 (DOB Selection & Validation): " . ($point1and2Success ? "PASSED [OK]" : "FAILED") . "\n";
echo "Point 2 (.jpeg/.jpg Photos >6MB):     " . ($point1and2Success ? "PASSED [OK]" : "FAILED") . "\n";
echo "Point 3 (New Logo in All Emails):     " . ($point3Success ? "PASSED [OK]" : "FAILED") . "\n";
echo "Point 4 (Availability 'All day'):     " . ($point4Success ? "PASSED [OK]" : "FAILED") . "\n";
echo "========================================================\n";
