<?php

declare(strict_types=1);

/**
 * Creates WebP copies for the public project galleries without altering originals.
 * Usage: php scripts/convert-gallery-images.php
 */

$directories = [
    __DIR__ . '/../public/assets/img/City_Panorama',
    __DIR__ . '/../public/assets/img/Amathos_Photos',
    __DIR__ . '/../public/assets/img/Olea Mare/Styles Photos',
    __DIR__ . '/../public/assets/rox2026/images',
];

$quality = 82;
$converted = 0;
$originalBytes = 0;
$webpBytes = 0;

foreach ($directories as $directory) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    foreach ($iterator as $file) {
        if (! $file->isFile() || ! in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png'], true)) {
            continue;
        }

        $source = $file->getPathname();
        $target = $file->getPath() . DIRECTORY_SEPARATOR . $file->getBasename('.' . $file->getExtension()) . '.webp';
        $image = @imagecreatefromstring((string) file_get_contents($source));

        if ($image === false) {
            fwrite(STDERR, "Skipped unreadable image: {$source}\n");
            continue;
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        if (! imagewebp($image, $target, $quality)) {
            imagedestroy($image);
            throw new RuntimeException("Could not create {$target}");
        }

        imagedestroy($image);
        $converted++;
        $originalBytes += $file->getSize();
        $webpBytes += filesize($target);
    }
}

printf(
    "Converted %d images: %.2f MB → %.2f MB (%.1f%% smaller)\n",
    $converted,
    $originalBytes / 1048576,
    $webpBytes / 1048576,
    $originalBytes > 0 ? (1 - ($webpBytes / $originalBytes)) * 100 : 0,
);
