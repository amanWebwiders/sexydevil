<?php

$url = 'http://localhost/sexydevils/public/model-search?gender=female&page=2';
$html = @file_get_contents($url);

echo "==========================================" . PHP_EOL;
echo "   LIVE UI / HTML SOURCE VERIFICATION     " . PHP_EOL;
echo "==========================================" . PHP_EOL;

if (!$html) {
    echo "[FAIL] Could not fetch $url" . PHP_EOL;
    exit(1);
}

// 1. Check Canonical Tag
preg_match('/<link rel="canonical" href="([^"]+)">/', $html, $canonicalMatches);
$canonicalUrl = $canonicalMatches[1] ?? 'NOT FOUND';
echo "Canonical Tag Found: " . $canonicalUrl . PHP_EOL;

if (strpos($canonicalUrl, '?') === false && strpos($canonicalUrl, 'model-search') !== false) {
    echo " -> [PASS] Query parameters stripped from canonical tag!" . PHP_EOL;
} else {
    echo " -> [FAIL] Canonical tag contains query parameters or missing." . PHP_EOL;
}

// 2. Check Favicon Link Tags
preg_match_all('/<link rel="([^"]*icon[^"]*)"[^>]*>/', $html, $faviconMatches);
echo PHP_EOL . "Favicon Tags Found: " . count($faviconMatches[0]) . PHP_EOL;
foreach ($faviconMatches[0] as $favTag) {
    echo "  " . $favTag . PHP_EOL;
}

if (count($faviconMatches[0]) >= 2) {
    echo " -> [PASS] Multiple valid Favicon tags present!" . PHP_EOL;
} else {
    echo " -> [FAIL] Favicon tags missing." . PHP_EOL;
}

echo "==========================================" . PHP_EOL;
