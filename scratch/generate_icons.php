<?php

$sourcePath = __DIR__ . '/../public/images/escort_favicon.png';
if (!file_exists($sourcePath)) {
    die("Source file not found: $sourcePath\n");
}

$srcImage = imagecreatefrompng($sourcePath);
if (!$srcImage) {
    die("Failed to load source image\n");
}

$srcWidth = imagesx($srcImage);
$srcHeight = imagesy($srcImage);
echo "Source dimensions: {$srcWidth}x{$srcHeight}\n";

$sizes = [
    'favicon-48x48.png' => 48,
    'favicon-96x96.png' => 96,
    'favicon-192x192.png' => 192,
    'apple-touch-icon.png' => 180,
    'apple-touch-icon-precomposed.png' => 180,
];

$targetDirs = [
    __DIR__ . '/../public',
    __DIR__ . '/..',
];

// Generate PNG sizes
foreach ($sizes as $filename => $size) {
    $dst = imagecreatetruecolor($size, $size);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefilledrectangle($dst, 0, 0, $size, $size, $transparent);
    imagecopyresampled($dst, $srcImage, 0, 0, 0, 0, $size, $size, $srcWidth, $srcHeight);

    foreach ($targetDirs as $dir) {
        $outPath = $dir . '/' . $filename;
        imagepng($dst, $outPath, 9);
        echo "Saved: $outPath ({$size}x{$size})\n";
    }
    imagedestroy($dst);
}

// Generate sizes for ICO: 16x16, 32x32, 48x48
$icoSizes = [16, 32, 48];
$icoFrames = [];
foreach ($icoSizes as $s) {
    $dst = imagecreatetruecolor($s, $s);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefilledrectangle($dst, 0, 0, $s, $s, $transparent);
    imagecopyresampled($dst, $srcImage, 0, 0, 0, 0, $s, $s, $srcWidth, $srcHeight);
    
    ob_start();
    imagepng($dst, null, 9);
    $pngData = ob_get_clean();
    $icoFrames[$s] = $pngData;
    imagedestroy($dst);
}

// Build standard ICO format containing PNG streams (Vista+ icon format supported by all modern browsers)
$count = count($icoFrames);
$icoData = pack('vvv', 0, 1, $count);

$offset = 6 + ($count * 16); // Header size + directory entries size
$imageData = '';

foreach ($icoFrames as $s => $data) {
    $len = strlen($data);
    $widthByte = ($s >= 256) ? 0 : $s;
    $heightByte = ($s >= 256) ? 0 : $s;
    
    // Directory entry: width, height, colors(0), reserved(0), color planes(1), bpp(32), data size, offset
    $icoData .= pack('CCCCvvVV', $widthByte, $heightByte, 0, 0, 1, 32, $len, $offset);
    $imageData .= $data;
    $offset += $len;
}

$fullIco = $icoData . $imageData;

foreach ($targetDirs as $dir) {
    $icoPath = $dir . '/favicon.ico';
    file_put_contents($icoPath, $fullIco);
    echo "Saved ICO: $icoPath (size: " . strlen($fullIco) . " bytes)\n";
}

// Also ensure images directory in root has escort_favicon.png and escort_logo1.png
$rootImagesDir = __DIR__ . '/../images';
if (!is_dir($rootImagesDir)) {
    mkdir($rootImagesDir, 0755, true);
}
copy($sourcePath, $rootImagesDir . '/escort_favicon.png');
echo "Copied escort_favicon.png to root/images/\n";

if (file_exists(__DIR__ . '/../public/images/escort_logo1.png')) {
    copy(__DIR__ . '/../public/images/escort_logo1.png', $rootImagesDir . '/escort_logo1.png');
    echo "Copied escort_logo1.png to root/images/\n";
}

imagedestroy($srcImage);
echo "All icons successfully created!\n";
