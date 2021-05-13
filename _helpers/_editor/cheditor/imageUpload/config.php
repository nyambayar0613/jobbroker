<?php
	// ---------------------------------------------------------------------------

	# 이미지가 저장될 디렉토리의 전체 경로를 설정합니다.
	# 끝에 슬래쉬(/)는 붙이지 않습니다.
	# 주의: 이 경로의 접근 권한은 쓰기, 읽기가 가능하도록 설정해 주십시오.

	//$alice_path['path'] = "../../../..";
	$alice_path = "../../../../";
	$cat_path = "../../../../";

	include_once $alice_path . "_core.php";

	$ym = date("ym", time());

	define("SAVE_DIR", $alice['data_tmp_path'] . '/' . $ym);
	define("THUMB_DIR", $alice['data_tmp_path'] . '/' . $ym . "/thumb");

	@mkdir(SAVE_DIR, 0707);
	@chmod(SAVE_DIR, 0707);
	$index_file = SAVE_DIR . '/index.html';
	if(!file_exists($index_file)){	 // 디렉토리 보안을 위해
		$f = @fopen($index_file, "w"); 
		@fwrite($f, ""); 
		@fclose($f); 
		@chmod($index_file, 0606);	// index.html 파일 생성
	}

	@mkdir(THUMB_DIR, 0707);
	@chmod(THUMB_DIR, 0707);
	$index_file = THUMB_DIR . '/index.html';
	if(!file_exists($index_file)){	 // 디렉토리 보안을 위해
		$f = @fopen($index_file, "w"); 
		@fwrite($f, ""); 
		@fclose($f); 
		@chmod($index_file, 0606);	// index.html 파일 생성
	}

	# 위에서 설정한 'SAVE_DIR'의 URL을 설정합니다.
	# 끝에 슬래쉬(/)는 붙이지 않습니다.

	define("SAVE_URL", DOMAIN.NFE_URL."/data/tmp/".$ym);
	define("THUMB_URL", DOMAIN.NFE_URL."/data/tmp/".$ym."/thumb");

?>