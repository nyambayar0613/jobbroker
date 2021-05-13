<?php
		/*
		* /application/nad/config/process/db.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: DB Backup process
		* @Comment :: DB 백업
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];

		switch($mode){

			## dump 파일 생성
			case 'make':

				$uid = $_POST['uid'];

				if($_GET['uid']){	 // GET 으로 넘어온 변수 에러
					echo $config->_errors('0000'); exit;	 // 잘못된 방법으로 변수가 정의 되었습니다.
				}
				if(!$uid || empty($uid) || !isset($uid)){	 // 관리자 아이디 입력 유무
					echo $admin_control->_errors('0001'); exit;	 // 관리자 아이디를 입력해 주세요.
				}

				if($is_demo){	 // 데모 일땐 작동 안함

					echo '0023'; exit;	 // 데모 버전에선 사용할 수 없는 기능입니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.

				} else {

					$db_host	= $db->db_host;
					$db_name = $db->db_name;
					$db_user	= $db->db_user;
					$db_pass	= $db->db_pass;

					$dump_name = $utility->get_unique_code('db') . ".dump";

					$save_dir = $alice['data_db_path'] . '/' . $ym;
					if(!is_dir($save_dir)){
						@mkdir($save_dir, 0707); @chmod($save_dir, 0707);
					}
					$index_file = $save_dir . '/index.html';
					if(!file_exists($index_file)){	// 디렉토리 보안을 위해서
						$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);
					}

					$dump_path = $save_dir . "/" . $dump_name;

					exec("/usr/local/mysql/bin/mysqldump -u" .$db_user." -h ".$db_host." -p".$db_pass." ".$db_name." > ".$dump_path);

					$vals['uid'] = $uid;
					$vals['type'] = 'sql';
					$vals['file_name'] = $ym . '/' . $dump_name;
					$vals['wdate'] = $now_date;

					$result = $backup_control->insert_backup($vals);

					if($result) {
						echo "0005"; exit;	// 백업 되었습니다.
					} else {
						echo $admin_control->_errors('0000'); exit;	 // 백업중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
					}

				}

			break;

			## dump 파일 삭제
			case 'delete':

				if($is_demo){	 // 데모 일땐 작동 안함

					echo '0023'; exit;	 // 데모 버전에선 사용할 수 없는 기능입니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.

				} else {

					if($is_admin){

						$no = $_POST['no'];
						$result = $backup_control->delete_backup($no);

						if($result) {
							echo "0001"; exit;	 // 백업파일 삭제가 완료 되었습니다.
						} else {
							echo $backup_control->_errors('0001'); exit;	// 백업파일 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
						}

					} else {

						echo $admin_control->_errors('0000'); exit;	 // 관리자만 접근 가능합니다.

					}

				}

			break;

			## dump 파일 삭제(복수)
			case 'deletes':

				if($is_demo){	 // 데모 일땐 작동 안함

					echo '0023'; exit;	 // 데모 버전에선 사용할 수 없는 기능입니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.

				} else {
					
					if($is_admin){

						$nos = explode(',',$no);
						$no_cnt = count($nos);
						for($i=0;$i<$no_cnt;$i++){
							$result = $backup_control->delete_backup($nos[$i]);
						}

						if($result) {
							echo "0001"; exit;	 // 백업파일 삭제가 완료 되었습니다.
						} else {
							echo $backup_control->_errors('0001'); exit;	// 백업파일 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
						}

					} else {

						echo $admin_control->_errors('0000'); exit;	 // 관리자만 접근 가능합니다.

					}

				}

			break;
		}

?>