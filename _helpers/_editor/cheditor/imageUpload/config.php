<?php
	// ---------------------------------------------------------------------------

	# �̹����� ����� ���丮�� ��ü ��θ� �����մϴ�.
	# ���� ������(/)�� ������ �ʽ��ϴ�.
	# ����: �� ����� ���� ������ ����, �бⰡ �����ϵ��� ������ �ֽʽÿ�.

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
	if(!file_exists($index_file)){	 // ���丮 ������ ����
		$f = @fopen($index_file, "w"); 
		@fwrite($f, ""); 
		@fclose($f); 
		@chmod($index_file, 0606);	// index.html ���� ����
	}

	@mkdir(THUMB_DIR, 0707);
	@chmod(THUMB_DIR, 0707);
	$index_file = THUMB_DIR . '/index.html';
	if(!file_exists($index_file)){	 // ���丮 ������ ����
		$f = @fopen($index_file, "w"); 
		@fwrite($f, ""); 
		@fclose($f); 
		@chmod($index_file, 0606);	// index.html ���� ����
	}

	# ������ ������ 'SAVE_DIR'�� URL�� �����մϴ�.
	# ���� ������(/)�� ������ �ʽ��ϴ�.

	define("SAVE_URL", DOMAIN.NFE_URL."/data/tmp/".$ym);
	define("THUMB_URL", DOMAIN.NFE_URL."/data/tmp/".$ym."/thumb");

?>