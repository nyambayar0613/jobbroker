<?php
		/*
		* /application/nad/config/process/admin.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Admin/etc Info
		* @Comment :: 관리자 정보 설정 처리
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];
		$mode = $_POST['mode'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$no = $_POST['no'];
		$name = $_POST['name'];
		$uid = $_POST['uid'];
		$nick = $_POST['nick'];
		$level = $_POST['level'];
		$passwd = $_POST['password'];
		$passwd_re = $_POST['password_re'];


		if($mode=='super_update' || $mode=='sadmin_insert' || $mode=='sadmin_update'){

			if(!$uid || empty($uid) || !isset($uid)){	 // 관리자 아이디 입력 유무
				echo $admin_control->_errors('0001'); exit;	// 관리자 아이디를 입력해 주세요.
			}
			
			if (!trim($uid) || !trim($nick) || !trim($passwd)){	// 공백체크
				echo $admin_control->_errors('0005'); exit;	// 관리자 아이디나 비밀번호, 닉네임은 공백이면 안됩니다.
			}

			if($_GET['uid'] || $_GET['nick'] || $_GET['password'] || $_GET['password_re']){	 // GET 으로 넘어온 변수 에러
				echo $config->_errors('0000'); exit; // 잘못된 방법으로 변수가 정의 되었습니다.
			}
			if(!$nick || empty($nick) || !isset($nick)){	 // 관리자 닉네임 입력 유무
				echo $admin_control->_errors('0008'); exit;	// 관리자 닉네임을 입력해 주세요.
			}
			// 부관리자 수정이 아닐때만
			if($mode!='sadmin_update'){
				if(!$passwd || empty($passwd) || !isset($passwd)){	// 관리자 패스워드 입력 유무
					echo $admin_control->_errors('0002'); exit;	// 관리자 비밀번호를 입력해 주세요.
				}
				if($passwd != $passwd_re){	// 관리자 패스워드 일치 여부
					echo $config->_errors('0053'); exit;	// 비밀번호(패스워드)가 일치하지 않습니다.
				}
			}

		}

		switch($mode){
			
			## 최고관리자 정보 수정
			case 'super_update':

				$vals['uid'] = $uid;
				$vals['passwd'] = md5($passwd);
				$vals['level'] = $level;
				$vals['name'] = $name;
				$vals['nick'] = $nick;

				$result = $admin_control->update_admin($no, $vals);
				
				if($result) {
					$admin_control->update_uid($admin_info['uid'],$uid);	// 회원 uid 수정시 모든 환경설정 정보를 수정해야 한다.
					echo "0003"; exit;	// 관리자 정보가 수정 되었습니다.
				} else {
					echo $admin_control->_errors('0009'); exit;	// 관리자 정보 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
				}

			break;

			case 'sadmin_insert':	## 부관리자 등록
			case 'sadmin_update':## 부관리자 수정

				if($mode=='sadmin_insert'){
					$duplication = $admin_control->sadmin_duplication($uid);	 // uid 중복 체크
					if($duplication) {
						echo $admin_control->_errors('0010'); exit;	// 이미 존재하는 관리자 아이디(ID) 입니다.
					}
				}

				$top_menu = $_POST['top_menu'];
				$middle_menu = $_POST['middle_menu'];
				$sub_menu = $_POST['sub_menu'];

				$val['uid'] = $uid;
				if($passwd!='')	// 패스워드 정보를 입력한 경우에만
					$val['passwd'] = md5($passwd);
				$val['level'] = $level;
				$val['name'] = $name;
				$val['nick'] = $nick;

				if($mode=='sadmin_insert')
					$result = $admin_control->insert_sadmin($val);
				else 
					$result = $admin_control->update_sadmin($val, $uid);

				if($result){	 // 관리자 정보가 입력됐으면

					$vals['uid'] = $uid;
					$vals['top_menu'] = @implode(',',$top_menu);
					$vals['middle_menu'] = @implode(',',$middle_menu);
					$vals['sub_menu'] = @implode(',',$sub_menu);
					$vals['wdate'] = $now_date;

					$result = $admin_control->sadmin_auth($vals, $uid);

					if($result) {
						echo "0004"; exit;	// 부관리자 정보가 입력 되었습니다.
					} else {
						echo $admin_control->_errors('0013'); exit;	// 부관리자 메뉴별 권한 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
					}

				} else {
					echo $admin_control->_errors('0011'); exit;	// 부관리자 정보 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
				}

			break;
			case 'sadmin_delete':	## 부관리자 삭제 (단수)

				$get_admin = $admin_control->get_admin($uid);	 // 부관리자 기본 정보
				$get_admin_auth = $admin_control->get_admin_auth($uid);	 // 부관리자 접근 메뉴

				if($_GET['uid'] || $_GET['no']){	 // GET 으로 넘어온 변수 에러
					echo $config->_errors('0000'); exit; // 잘못된 방법으로 변수가 정의 되었습니다.
				}

				$result = $admin_control->delete_sadmin($uid);

				if($result){
					echo "0005"; exit;	// 부관리자 삭제가 완료 되었습니다.
				} else {
					echo $admin_control->_errors('0012'); exit;	// 부관리자 정보 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
				}

			break;
			case 'sadmin_deletes':	## 부관리자 삭제 (복수)

				$uids = explode(',',$uid);
				$uid_cnt = count($uids);
				for($i=0;$i<$uid_cnt;$i++){
					$result = $admin_control->delete_sadmin($uids[$i]);
				}

				if($result){
					echo "0005"; exit;	// 부관리자 삭제가 완료 되었습니다.
				} else {
					echo $admin_control->_errors('0012'); exit;	// 부관리자 정보 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
				}

			break;

		}	// switch end.
?>