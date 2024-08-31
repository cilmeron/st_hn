<?php

// Define the cache directory and make sure it exists
$cacheDir = './cache/';
if (!file_exists($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

// Get the text from the query parameter
if (!isset($_GET['text']))
    $_GET['text'] = $argv[1];

$text = $_GET['text'];

// Sanitize the text to use in a filename
$safeText = preg_replace('/[^a-zA-Z0-9_]/', '_', $text);

// Define the cache file path
$cacheFile = $cacheDir . md5($safeText) . '.png';

// Check if a cached version exists
if (file_exists($cacheFile)) {
    // Serve the cached file
    header("Content-Type: image/png");
    readfile($cacheFile);
   // exit;
}

$font = "./helvetica.otf";
$fontSize = 30;

$textDim = imagettfbbox($fontSize, 0, $font, $text);
$textX = $textDim[2] - $textDim[0];
$textY = $textDim[7] - $textDim[1];

// No cached version, create the image
$img = imagecreatetruecolor($textX, 40);
$imageX = imagesx($img);
$imageY = imagesy($img);

imagealphablending($img, false);
imagesavealpha($img, true);

$transparent = imagecolorallocatealpha($img, 255, 255, 255, 127);
$black = imagecolorallocate($img, 0, 0, 0);
$white = imagecolorallocate($img, 255, 255, 255);
$color = $white;
if (isset($_GET['color']))
{
    if ($_GET['color'] == "white")
        $color = $white;
    else if($_GET['color'] == "black")
        $color = $black;
}

imagefilledrectangle($img, 0, 0, $imageX, $imageY, $transparent);



$text_posX = ($imageX / 2) - $textX / 2;
$text_posY = ($imageY / 2) - $textY / 2;

imagealphablending($img, true);
imagettftext($img, $fontSize, 0, $text_posX, $text_posY, $color, $font, $text);

// Save the image to the cache directory
imagepng($img, $cacheFile);

// Output the image
header("Content-Type: image/png");
imagepng($img);

imagedestroy($img);

?>