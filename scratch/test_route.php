<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$testUrls = [
    '/favicon.ico',
    '/favicon-48x48.png',
    '/favicon-96x96.png',
    '/favicon-192x192.png',
    '/apple-touch-icon.png',
];

echo str_pad("Request URL", 25) . str_pad("Status", 10) . str_pad("Content-Type", 25) . "Content-Length\n";
echo str_repeat("-", 75) . "\n";

foreach ($testUrls as $url) {
    $request = Illuminate\Http\Request::create($url, 'GET');
    $response = $kernel->handle($request);
    
    $status = $response->getStatusCode();
    $contentType = $response->headers->get('Content-Type');
    $length = strlen($response->getContent());
    
    echo str_pad($url, 25) . str_pad($status, 10) . str_pad($contentType ?? 'none', 25) . $length . " bytes\n";
    $kernel->terminate($request, $response);
}
