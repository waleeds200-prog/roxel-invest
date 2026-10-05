<?php

declare(strict_types=1);

$source = $argv[1] ?? null;
$destination = $argv[2] ?? null;
$targetWidth = isset($argv[3]) ? (int) $argv[3] : 4320;

if (!$source || !$destination || $targetWidth < 1) {
    fwrite(STDERR, "Usage: php scripts/build-hero-asset.php <source.png> <destination.webp> [width]\n");
    exit(1);
}

$contents = file_get_contents($source);
$image = $contents === false ? false : imagecreatefromstring($contents);

if (!$image) {
    fwrite(STDERR, "Unable to read source image.\n");
    exit(1);
}

$targetHeight = (int) round(imagesy($image) * $targetWidth / imagesx($image));
$resized = imagecreatetruecolor($targetWidth, $targetHeight);
imagecopyresampled(
    $resized,
    $image,
    0,
    0,
    0,
    0,
    $targetWidth,
    $targetHeight,
    imagesx($image),
    imagesy($image)
);

if (!imagewebp($resized, $destination, 95)) {
    fwrite(STDERR, "Unable to write WebP image.\n");
    exit(1);
}

imagedestroy($image);
imagedestroy($resized);

echo $targetWidth . 'x' . $targetHeight . PHP_EOL;
