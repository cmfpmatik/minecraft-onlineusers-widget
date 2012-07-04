<?php

$filename = null;
$size = null;

if(isset($_GET['pseudo']) && $_GET['pseudo'] != null)
{
	$filename = 'http://s3.amazonaws.com/MinecraftSkins/' . $_GET['pseudo'] . '.png';
}
else
{
	$filename = 'http://s3.amazonaws.com/MinecraftSkins/char.png';
}

if(isset($_GET['size']) && $_GET['size'] != null)
{
	$size = $_GET['size'];
}
else
{
	$size = '64';
}

if(is404($filename) || $filename == null)
{
	$filename = 'http://s3.amazonaws.com/MinecraftSkins/char.png';
}

// Content type
header('Content-type: image/png');
// Resample
$image_p = imagecreatetruecolor($size, $size);
$image = imagecreatefrompng($filename);
imagecopyresampled($image_p, $image, 0, 0, 8, 8, $size, $size, 8, 8);
// Output
imagepng($image_p);

function is404($filename)
{
    $handle = curl_init($filename);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);

    if ($httpCode >= 200 && $httpCode < 300) {
        return false;
    } else {
        return true;
    }
}

?>