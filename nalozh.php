<?php
$src = imagecreatefromjpeg('http://graphics8.nytimes.com/images/2008/04/20/magazine/20learn-600.jpg');
$main_img = imagecreatefromjpeg('img/00.jpg');
 
$w_src = 108;//imagesx($src);
$h_src = 140;//imagesy($src);
$w_dest = imagesx($main_img);
$h_dest = imagesy($main_img);
 
$transfer_x = 288;
$transfer_y = 22;
 
imagecopyresampled($main_img, $src, $transfer_x, $transfer_y, 0, 0, $w_src, $h_src, $w_src, $h_src);
header('Content-Type: image/jpeg');
imagejpeg($main_img);
imagedestroy($main_img);
imagedestroy($src);
?>