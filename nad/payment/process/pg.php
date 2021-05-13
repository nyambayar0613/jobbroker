<?php
		/*
		* /application/nad/payment/process/pg.php
		* @author Harimao
		* @since 2013/09/05
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Gateway config process
		* @Comment :: 결제 모듈 정보 설정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크
	
		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];

		$pg_company = $_POST['pg_company'];	// 선택 결제모듈

		$get_pgInfoCompany = $payment_control->get_pgInfoCompany($pg_company);

		switch($mode){

			## 입력
			case 'pg_insert':
				//$pg_control->insert_pg();
			break;

			## 수정
			case 'pg_update':

				$vals['pg_company'] = $pg_company;

				switch($pg_company){
					
					## 이니시스
					case 'inicis':

						$vals['pg_id'] = $_POST['inicis_pg_id'];
						$vals['pg_passwd'] = $_POST['inicis_pg_passwd'];
						$vals['pg_key'] = $_POST['inicis_pg_key'];
						//$vals['inicis_pg_pay'] = '';

						/* 로고 업로드 */
						$tmp_file	= $_FILES['inicis_logo']['tmp_name'];
						$filename	= $_FILES['inicis_logo']['name'];
						$get_LogoExtension = $payment_control->_logo();	// 로고파일 확장자 설정 정보
						if(is_uploaded_file($tmp_file)){
							$timg = @getimagesize($tmp_file);
							if($timg[0] > 90 || $timg[1] > 34) {	// 상점 로고 사이즈 체크
								echo '0001';	// $payment_control->_errors('0001');
								exit;
							}
							if(preg_match("/\.($get_LogoExtension)$/i", $filename)){ // 파일 이미지 확장자 체크
								@unlink($alice['data_logo_path'] . "/" . $get_pgInfoCompany['pg_logo']);	// 기존 로고 삭제
								$file_upload = $utility->file_upload($tmp_file, $filename, $alice['data_logo_path'], $_FILES);	// 파일 업로드
								$vals['pg_logo'] = $file_upload['upload_file'];	// 변수 할당
							} else {	 // 확장자가 맞지 않는 경우
								echo '0004';	// $payment_control->_errors('0004');
								exit;
							}
						}
						/* //로고 업로드 */

						/* 키 파일 업로드 */
						$tmp_file	= $_FILES['inicis_key']['tmp_name'];
						$filename	= $_FILES['inicis_key']['name'];
						if(is_uploaded_file($tmp_file)){
							if(preg_match("/\.(zip)$/i", $filename)){ // 파일 확장자가 zip 이 아니면 튕겨냄
								$pclzip = new PclZip($tmp_file);
								$files = explode('.',$filename);	// . 구분으로 자름
								$key_name = $files[0];	// 키파일명
								$path = $_SERVER['DOCUMENT_ROOT'].'/plugin/PG/inicis/key/' . $key_name;
								@mkdir($path, 0707);	 // 키파일명으로 디렉토리 생성 (nobody.nobody 로 생성된다.)
								$extract = $pclzip->extract(PCLZIP_OPT_PATH, $path . '/' );	// 압축해제
								$vals['pg_keyfile'] = $key_name;
							} else {
								echo '0005';	// $payment_control->_errors('0005');
								exit;
							}
						}
						/* //키 파일 업로드 */

					break;

					## 올더게이트
					case 'allthegate':

						$vals['pg_id'] = $_POST['ags_pg_id'];
						$vals['pg_passwd'] = $_POST['ags_pg_passwd'];

						/* 로고 업로드 */
						$tmp_file	= $_FILES['ags_logo']['tmp_name'];
						$filename	= $_FILES['ags_logo']['name'];
						$get_LogoExtension = $payment_control->_logo();	// 로고파일 확장자 설정 정보
						if(is_uploaded_file($tmp_file)){
							$timg = @getimagesize($tmp_file);
							if($timg[0] > 85 || $timg[1] > 38) {	// 상점 로고 사이즈 체크
								echo '0002';	// $payment_control->_errors('0001');
								exit;
							}
							if(preg_match("/\.($get_LogoExtension)$/i", $filename)){ // 파일 이미지 확장자 체크
								@unlink($alice['data_logo_path'] . "/" . $get_pgInfoCompany['ags_logo']);	// 기존 로고 삭제
								$file_upload = $utility->file_upload($tmp_file, $filename, $alice['data_logo_path'], $_FILES);	// 파일 업로드
								$vals['pg_logo'] = $file_upload['upload_file'];	// 변수 할당
							} else {	 // 확장자가 맞지 않는 경우
								echo '0004';	// $payment_control->_errors('0004');
								exit;
							}
						}
						/* //로고 업로드 */

						$vals['pg_cpid'] = $_POST['ags_cpid'];
						$vals['pg_cppasswd'] = $_POST['ags_cppasswd'];
						$vals['pg_subcp'] = $_POST['ags_subcp'];
						$vals['pg_code'] = $_POST['ags_code'];
						$vals['pg_ars'] = $_POST['ags_ars'];

					break;

					## KCP
					case 'kcp':
						$vals['pg_id'] = $_POST['kcp_pg_id'];
						$vals['pg_passwd'] = $_POST['kcp_pg_passwd'];
					
						/* 로고 업로드 */
						$tmp_file	= $_FILES['kcp_logo']['tmp_name'];
						$filename	= $_FILES['kcp_logo']['name'];
						$get_LogoExtension = $payment_control->_logo();	// 로고파일 확장자 설정 정보
						if(is_uploaded_file($tmp_file)){
							$timg = @getimagesize($tmp_file);
							if($timg[0] > 150 || $timg[1] > 50) {	// 상점 로고 사이즈 체크
								echo '0003';	// $payment_control->_errors('0001');
								exit;
							}
							if(preg_match("/\.($get_LogoExtension)$/i", $filename)){ // 파일 이미지 확장자 체크
								@unlink($alice['data_logo_path'] . "/" . $get_pgInfoCompany['kcp_logo']);	// 기존 로고 삭제
								$file_upload = $utility->file_upload($tmp_file, $filename, $alice['data_logo_path'], $_FILES);	// 파일 업로드
								$vals['pg_logo'] = $file_upload['upload_file'];	// 변수 할당
							} else {	 // 확장자가 맞지 않는 경우
								echo '0004';	// $payment_control->_errors('0004');
								exit;
							}
						}
						/* //로고 업로드 */

					break;



					## KCP
					case 'nicepay':
						$vals['pg_id'] = $_POST['nice_pg_id'];
						$vals['pg_passwd'] = $_POST['nice_pg_passwd'];
						$vals['pg_key'] = $_POST['nice_pg_key'];
						/* //로고 업로드 */

					break;

					/*
					## LG U+
					case 'lguplus':
						$vals['pg_id'] = $_POST['xpay_pg_id'];
						$vals['pg_passwd'] = $_POST['xpay_pg_passwd'];
					break;
					*/

				}	// pg_company switch end.

				$vals['pg_method'] = @implode($_POST['pg_method'],"/");

				$vals['wdate'] = $now_date;

			break;

		}	// mode switch end.

		$vals['pg_result'] = 1;	// 사용유무 (무조건 사용으로)

		// insert or update
		$result = $payment_control->update_pg_page( $vals, $pg_company );

		echo $result;

?>