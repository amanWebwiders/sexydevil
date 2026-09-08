<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ALL Users who have stories ===\n";
$usersAll = \App\Models\User::whereHas('stories')->get(['id','nickname','type','user_status','admin_status']);
foreach ($usersAll as $u) {
    $storyCount = \App\Models\NewsAndStory::where('user_id', $u->id)->count();
    echo "User {$u->id} ({$u->nickname}) | type={$u->type} | user_status={$u->user_status} | admin={$u->admin_status} | stories={$storyCount}\n";
}

echo "\n=== Users matching reels query (type=2, user_status=0) ===\n";
$usersFiltered = \App\Models\User::where('type', 2)->where('user_status', 0)->whereHas('stories')->get(['id','nickname']);
echo "Count: " . $usersFiltered->count() . "\n";
foreach ($usersFiltered as $u) {
    echo "  User {$u->id} ({$u->nickname})\n";
}

echo "\nNote: The logged-in user is EXCLUDED from reels via ['users.id', '!=', user_id]\n";
echo "Check which user you are logged in as - their stories wont show.\n";
