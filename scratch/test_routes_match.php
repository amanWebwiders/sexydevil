<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$routes = [
    '/favicon.ico',
    '/favicon-48x48.png',
    '/favicon-96x96.png',
    '/favicon-192x192.png',
    '/apple-touch-icon.png',
    '/apple-touch-icon-precomposed.png',
    '/robots.txt',
    '/bogota', // city route test
];

echo str_pad("URI", 35) . str_pad("Route Name", 25) . "Action / Handler\n";
echo str_repeat("-", 80) . "\n";

foreach ($routes as $uri) {
    $request = Illuminate\Http\Request::create($uri, 'GET');
    try {
        $route = Illuminate\Support\Facades\Route::getRoutes()->match($request);
        $name = $route->getName() ?? '(unnamed)';
        $action = $route->getActionName();
        echo str_pad($uri, 35) . str_pad($name, 25) . $action . "\n";
    } catch (\Exception $e) {
        echo str_pad($uri, 35) . "ERROR: " . $e->getMessage() . "\n";
    }
}
