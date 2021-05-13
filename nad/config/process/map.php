<?php
		/*
		* /application/nad/config/process/map.php
		* @author Harimao
		* @since 2013/06/11
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Map process
		* @Comment :: 지도 정보처리
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";
	
		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$no = $_POST['no'];
		$cno = $_POST['no'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		switch($mode){

			## 지도마커 클릭시 정보 출력
			case 'company_info':

				switch($env['use_map']){
					case 'google':
						$img_size = array(50,40);
					break;
					default:
						$img_size = array(100,100);
					break;
				}


				$test_maps = array("37.538779843072824,127.00200500605618", "37.538635699652154,127.00030778301571", "37.537338259427315,126.9998325645435", "37.53377026138633,127.00288736856231", "37.534941239454476,127.00920075758009");

				$test_maps_count = count($test_maps);

				$file_image = '<img src="./views/_image/20120329164619_9346.gif" width="120" height="60" />';
				$file_path = $alice['admin_config_path']."/views/_include/company.sample.php";

				ob_start();
				include_once $file_path;
				$msg = ob_get_contents();
				ob_end_clean();

				$test_datas = array( 
					0 => array( "x" => "37.538779843072824", "y" => "127.00200500605618", "zoom" => "", "msg" => $msg ), 
					1 => array( "x" => "37.538635699652154", "y" => "127.00030778301571", "zoom" => "12", "msg" => $msg ), 
					2 => array( "x" => "37.537338259427315", "y" => "126.9998325645435", "zoom" => "12", "msg" => $msg ), 
					3 => array( "x" => "37.53377026138633", "y" => "127.00288736856231", "zoom" => "", "msg" => $msg ), 
					4 => array( "x" => "37.534941239454476", "y" => "127.00920075758009", "zoom" => "12", "msg" => $msg ), 
				);

				echo json_encode($test_datas[$no]);

			break;

		}
?>