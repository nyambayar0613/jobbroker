<?php

	$alice_path = "../";

	$cat_path = "../";

	include_once $alice_path . "_core.php";

	//error_reporting (E_ALL);
	include('kcaptcha.php');

	//session_start();
	$captcha = new KCAPTCHA();
	$captcha->setKeyString($_SESSION['captcha_keystring']);
	$captcha->getKeyString();
	$captcha->image();
?>