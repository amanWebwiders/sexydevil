<?php
$w = 3600;
$h = 2800;
$img = imagecreatetruecolor($w, $h);
for ($y = 0; $y < $h; $y += 15) {
    for ($x = 0; $x < $w; $x += 15) {
        $c = imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
        imagefilledrectangle($img, $x, $y, $x + 14, $y + 14, $c);
    }
}
imagejpeg($img, __DIR__ . '/test_sample_camera.jpg', 99);
imagejpeg($img, __DIR__ . '/test_sample_camera.jpeg', 99);
imagedestroy($img);

echo "Created test_sample_camera.jpg: " . round(filesize(__DIR__ . '/test_sample_camera.jpg') / (1024*1024), 2) . " MB\n";
echo "Created test_sample_camera.jpeg: " . round(filesize(__DIR__ . '/test_sample_camera.jpeg') / (1024*1024), 2) . " MB\n";
