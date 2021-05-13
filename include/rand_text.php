<?php
/*
이미지 보안숫자
*/
session_start();

$ipwd="0123456789"; // ABCDEFGHIJKLMNOPQRSTUVWXYZ // : 앞에 영어도 넣으면 영어,숫자 혼용이 됨.
$pwd = array();
for($i=0;$i<6;$i++) {
	$pwd[] = $ipwd[rand(0, strlen($ipwd)-1)]; 
}

if($_GET['wr_no']) $_SESSION['_reply_rand_'][$_GET['wr_no']] = @implode("", $pwd);
else $_SESSION['rand_nums'] = @implode("", $pwd);

$bg_color = array(255, 239, 177);
$width = 100;
$im = imagecreate($width, 30);

// White background and blue text
$bg = imagecolorallocate($im, $bg_color[0], $bg_color[1], $bg_color[2]);
$textcolor = imagecolorallocate($im, 0, 0, 255);

$width -= $width / 2;

// Write the string at the top left

$first_w = rand(5,25);
foreach($pwd as $k=>$v) {
	$w = $first_w+($k*12);
	//$txt_color = array(rand(10,254), rand(10,254), rand(10,254));
	$txt_color = array(0, 0, 0);
	$textcolor = imagecolorallocate($im, $txt_color[0], $txt_color[1], $txt_color[2]);
	imagestring($im, 5, $w, rand(0,10), $v, $textcolor);
}

// Output the image
header('Content-type: image/png');

imagepng($im);
imagedestroy($im);
?>