<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

App\Models\User::where('id', 71)->update([
    'admin_status' => 'approved',
    'user_status' => 0,
    'email_verified_at' => now()
]);
echo "User 71 is now approved and active!\n";
