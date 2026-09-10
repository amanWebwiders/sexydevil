<?php

$files = [
    'public/favicon.ico',
    'public/favicon-48x48.png',
    'public/favicon-96x96.png',
    'public/favicon-192x192.png',
    'public/apple-touch-icon.png',
    'public/apple-touch-icon-precomposed.png',
    'favicon.ico',
    'favicon-48x48.png',
    'favicon-96x96.png',
    'favicon-192x192.png',
    'apple-touch-icon.png',
    'apple-touch-icon-precomposed.png',
];

echo str_pad("File", 42) . str_pad("Dimensions", 15) . "MIME / Type\n";
echo str_repeat("-", 70) . "\n";

foreach ($files as $f) {
    if (!file_exists($f)) {
        echo str_pad($f, 42) . "NOT FOUND\n";
        continue;
    }
    $info = @getimagesize($f);
    if ($info) {
        $dim = $info[0] . 'x' . $info[1];
        $mime = $info['mime'];
    } else {
        // Test if ICO
        $data = file_get_contents($f, false, null, 0, 4);
        if ($data === "\x00\x00\x01\x00") {
            $dim = "16,32,48";
            $mime = "image/x-icon (valid ICO)";
        } else {
            $dim = "Unknown";
            $mime = "Unknown binary";
        }
    }
    echo str_pad($f, 42) . str_pad($dim, 15) . $mime . "\n";
}
