<?php
require_once("config.php");

//----------------------------------------------------------------------------
//
//
$filename = null;
$savefile = null;
$filesize = 0;

if (isset($_POST["filehtml5"])) {
	$filename = $_POST["randomname"];
	$savefile = SAVE_DIR . '/' . $filename;
	$fh = fopen($savefile, "w");
	fwrite($fh, base64_decode($_POST["filehtml5"]));
	fclose($fh);
}
else {
	$tempfile = $_FILES['file']['tmp_name'];
	$filename = $_FILES['file']['name'];

	$type = substr($filename, strrpos($filename, "."));
	$found = false;
	switch ($type) {
	case ".jpg":
	case ".jpeg":
	case ".gif":
	case ".png":
		$found = true;
	}

	if ($found != true) {
		exit;
	}

	$filename = $_POST["randomname"];
	$savefile = SAVE_DIR . '/' . $filename;

	move_uploaded_file($tempfile, $savefile);
	$imgsize = getimagesize($savefile);
	
	if (!$imgsize) {
		$filesize = 0;
		$filename = '-ERR';
		unlink($savefile);
	}
}

// 저장 파일 이름: 년월일시분초_렌덤문자8자
// 20140327125959_abcdefghi.jpg
// 원본 파일 이름: $_POST["origname"]
$filesize = filesize($savefile);

$rdata = sprintf('{"fileUrl": "%s/%s", "filePath": "%s", "fileName": "%s", "fileSize": "%d" }',
	SAVE_URL,
	$filename,
	$savefile,
	$filename,
	$filesize );

echo $rdata;
?>
