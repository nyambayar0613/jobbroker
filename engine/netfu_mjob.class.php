<?php
class netfu_mjob {

	var $path = "";
	var $url = "";
	var $pay_conference = array( 0 => "", 1 => "협의", 2 => "면접후" );

	var $logo_size = 100; // : 로고 최대용량 kb단위
	var $photo_size = 100;  // : 사진 최대용량 kb단위

	var $sub_title = array(
		'job'=>array('hurry'=>'급구', 'area'=>'지역별', 'job_type'=>'업직종별', 'subway'=>'역세권별', 'univ'=>'대학가별', 'date'=>'기간별', 'pay'=>'급여별', 'job_target'=>'대상별'),
		'resume'=>array('hurry'=>'급구', 'area'=>'지역별', 'job_type'=>'업직종별', 'date'=>'기간별'),
	);

	var $school_arr1 = array('high_school'=>'고등학교', 'half_college'=>'대학(2,3년)', 'college'=>'대학교(4년)', 'graduate'=>'대학원');

	// : 접수방법
	var $requisition_arr = array('online'=>'온라인', 'email'=>'이메일', 'phone'=>'전화연락', 'meet'=>'방문접수', 'post'=>'우편', 'fax'=>'팩스', 'homepage'=>'홈페이지');

	var $proposal_arr = array('interview'=>'면접제의', 'become'=>'입사지원');

	// : 입사지원 연락처 공개설정
	var $receive_arr = array('mb_phone'=>'전화번호', 'mb_hphone'=>'휴대폰', 'mb_email'=>'e-메일', 'mb_address'=>'주소', 'mb_homepage'=>'홈페이지');

	var $oa_arr = array('word'=>'워드(한글·MS워드)', 'pt'=>'프리젠테이션(파워포인트)', 'sheet'=>'스프레시트(엑셀)', 'internet'=>'인터넷(정보검색)');
	var $oa_s_arr = array('word'=>'한글·MS워드', 'pt'=>'파워포인트', 'sheet'=>'엑셀', 'internet'=>'인터넷');
	var $oa_arr_gif = array('word'=>'word', 'pt'=>'power', 'sheet'=>'power', 'internet'=>'ie');
	var $oa_arr2 = array(
		'word'=>array('상(표/도구 활용기능)', '중(문서편집기능)', '하(기본사용)'),
		'pt'=>array('상(챠트/효과 활용가능)', '중(서식/도형 가능)', '하(기본사용)'),
		'sheet'=>array('상(수식/함수 활용가능)', '중(데이터 편집가능)', '하(기본사용)'),
		'internet'=>array('상(정보수집 능숙)', '중(정보수집 가능)', '하(기본사용)'),
	);

	var $language_level = array(0=>'상(회화능숙)', 1=>'중(일상대화)', 2=>'하(간단대화)');
	var $language_date = array( 0 => "6개월 이하", 1 => "1년", 2 => "1년 미만", 3 => "2년", 4 => "2년 미만", 5 => "3년", 6 => "3년 미만", 7 => "4년", 8 => "4년 미만", 9 => "5년", 10 => "5년 미만", 11 => "6년", 12 => "6년 미만", 13 => "7년", 14 => "7년 미만", 15 => "8년", 16 => "8년 미만", 17 => "9년", 18 => "9년 미만", 19 => "10년", 20 => "10년 미만", 21 => "10년 이상" );

	var $pay_conference_arr = array(1=>'추후협의', 2=>'면접후결정');

	var $job_where = "`wr_open` = 1 and `is_delete` = 0 and `wr_is_adult` = 0 and (`wr_volume_date` >= curdate() or `wr_volume_always` = 1 or `wr_volume_end` = 1 )";
	var $resume_where = "aar.`is_delete` = 0 and aar.`wr_open`=1";

	var $_service_where = " and !(`wr_service_platinum` < curdate() and `wr_service_grand` < curdate() and `wr_service_special` < curdate() and `wr_service_basic` < curdate())"; // : 서비스체크

	var $ing_job = " and ( `wr_volume_always` = '1' or `wr_volume_end` = '1' or `wr_volume_date` >= curdate() ) ";
	var $end_job = " and ( `wr_volume_always` = '0' and `wr_volume_end` = '0' and `wr_volume_date` < curdate() ) ";

	var $job_read_check;
	var $resume_read_check;

	function netfu_mjob(){
		global $service_control;
		$this->path = $_SERVER['DOCUMENT_ROOT'];


		$this->job_read_check = $service_control->service_check('etc_alba');
		$this->resume_read_check = $service_control->service_check('etc_open');
	}


	function get_member($id) {
		$query = " select * from alice_member where `mb_id` = '".$id."' ";
		$result = sql_fetch($query);
		return $result;
	}

	function get_company($id) {
		$query = " select * from alice_member_company where `mb_id` = '".$id."' ";
		$result = sql_fetch($query);
		return $result;
	}

	function get_logo($id){
		$m_row = $this->get_company($id);
		$logo = $this->url."/data/member/".$id."/logo/".$m_row['mb_logo'];

		return $logo;
	}


// : $__alba_icon_arr, $__resume_icon_arr 변수는 _core.php에 있음.
	function get_service_option($type, $row) {
		global $__alba_icon_arr, $__resume_icon_arr;
		if($type=='alba') $_icon_val = $__alba_icon_arr[$row['wr_service_icon_val']]['name'];
		else $_icon_val = $__resume_icon_arr[$row['wr_service_icon_val']]['name'];

		$_day = date("Y-m-d");
		if($row['wr_service_icon']>=$_day) $_option['icon'] = '<img src="'.NFE_URL.'/data/icon/'.$_icon_val.'" alt="" class="icon">';
		if($row['wr_service_neon']>=$_day) $_option['neon'] = 'background-color:#'.$row['wr_service_neon_val'];
		if($row['wr_service_color']>=$_day) $_option['color'] = 'color:#'.$row['wr_service_color_val'];
		if($row['wr_service_blink']>=$_day) $_option['blink'] = 'blink';
		if($row['wr_service_bold']>=$_day) $_option['bold'] = 'bold';

		return $_option;
	}

	function get_logo_type($field, $row, $get_logo) {
		$_class = array(0=>'fade_image', 1=>'blink_image', 2=>'slide_image');
		if($row[$field]>=date("Y-m-d")) {
			$arr[$row[$field.'_val']] = $_class[$row[$field.'_val']];
		}
		$arr['img'] = '<img src="'.$get_logo.'" class="'.$arr[0].' '.$arr[1].'" alt="LOGO">';
		if($arr[2]) $arr['img'] .= $arr['img'];
		$arr['img_size'] = @getimagesize(NFE_PATH.$get_logo);
		return $arr;
	}

	// 이력서 추출 (단수) :: wr_no 기준
	function get_resume_no( $no ){
		if(!$no || $no=='') return false;
		$query = " select * from alice_alba_resume where `no` = '".$no."' ";
		$result = sql_fetch($query);
		return $result;
	}

	// 열람 정보 저장
	function open_insert( $resume_no, $wr_id="", $type ){		
		global $netfu_util, $member_info, $member_service;
			
		if(!$resume_no || $resume_no == '') return false;

		if(!$wr_id || $wr_id == '') return false;	// wr_id 가 있어야 됨

		$get_member = $netfu_member->get_member($wr_id);

		$get_resume = $this->get_resume_no($resume_no);

		// 기업 회원일때만
		if($member_info['mb_type']!='company') return false;

		// 열람권이 있는 기업회원이 볼때만
		if($netfu_util->valid_day($member_service['mb_service_open'])){	// 열람권 서비스 기간이 있다면

			// 01. 중복 데이터 체크
			$sel_count = sql_num_rows2(" select * from alice_resume_open where `p_no` = '".$resume_no."' and  `mb_id` = '".$member_info['mb_id']."' and `wr_id` = '".$wr_id."' ");

			// 02. 중복 데이터가 없다면 입력
			if(!$sel_count){
				
				$result = sql_query(" insert into alice_resume_open set `p_no` = '".$resume_no."', `mb_id` = '".$member_info['mb_id']."', `wr_id` = '".$wr_id."', `wr_type` = '".$type."', `wr_name` = '".$get_member['mb_name']."', `wr_subject` = '".$get_resume['wr_subject']."', `wdate` = now() ");
				
				// 열람권 기간/건수 확인
				$is_open_service = false;
				if( $netfu_util->valid_day($member_service['mb_service_open']) ){
					$is_open_service = $member_service['mb_service_open'];
				}
				$is_open_count = false;
				if( $netfu_util->valid_day($member_service['mb_service_open']) && $member_service['mb_service_open_count'] ){	// 건수 사용이 가능하다면
					$is_open_count = $member_service['mb_service_open_count'];
				}

				if($is_open_count){	// 건수 사용이 가능하면 열람 했으니 차감
					$mb_service_open_count = $is_open_count - 1;
					sql_query(" update `alice_member_service` set `mb_service_open_count` = '".$mb_service_open_count."' where `mb_id` = '".$member_info['mb_id']."' ");
				}
			} else {
				$result = false;
			}
		} else {
			return false;
		}
		return $result;
	}

// : 구인정보 검색
	function job_search_func() {
		if($_GET['job_type'][0]) $job_type = array_diff($_GET['job_type'], array(""));
		if($_GET['area'][0]) $area = array_diff($_GET['area'], array(""));
		if($_GET['wr_stime'][0]) $wr_stime = array_diff($_GET['wr_stime'], array(""));
		if($_GET['wr_etime'][0]) $wr_etime = array_diff($_GET['wr_etime'], array(""));
		
		$job_type_txt = @implode("/", $job_type).'/';
		$area_txt = @implode("/", $area).'/';

		// : 직종
		if($job_type[0]) $job_type_arr[] = "(`wr_job_type0`='".$job_type[0]."' or `wr_job_type3`='".$job_type[0]."' or `wr_job_type6`='".$job_type[0]."')";
		if($job_type[1]) $job_type_arr[] = "(`wr_job_type1`='".$job_type[1]."' or `wr_job_type4`='".$job_type[1]."' or `wr_job_type7`='".$job_type[1]."')";
		if($job_type[2]) $job_type_arr[] = "(`wr_job_type2`='".$job_type[2]."' or `wr_job_type5`='".$job_type[2]."' or `wr_job_type8`='".$job_type[2]."')";

		// : 지하철
		if($_GET['subway'][0]) $subway_arr[] = "(wr_subway_area_0='".addslashes($_GET['subway'][0])."' or wr_subway_area_1='".addslashes($_GET['subway'][0])."' or wr_subway_area_2='".addslashes($_GET['subway'][0])."')";
		if($_GET['subway'][1]) $subway_arr[] = "(wr_subway_line_0='".addslashes($_GET['subway'][1])."' or wr_subway_line_1='".addslashes($_GET['subway'][1])."' or wr_subway_line_2='".addslashes($_GET['subway'][1])."')";
		if($_GET['subway'][2]) $subway_arr[] = "(wr_subway_station_0='".addslashes($_GET['subway'][2])."' or wr_subway_station_1='".addslashes($_GET['subway'][2])."' or wr_subway_station_2='".addslashes($_GET['subway'][2])."')";

		// : 근무시간
		if(count($wr_stime)>0)
			$stime_val = sprintf("%02d", $_GET['wr_stime'][0]).':'.sprintf("%02d", $_GET['wr_stime'][1]);
		if(count($wr_etime)>0)
			$etime_val = sprintf("%02d", $_GET['wr_etime'][0]).':'.sprintf("%02d", $_GET['wr_etime'][1]);

		$_data['where'] = "";
		if(count($job_type_arr)) $_data['where'] .= " and (".@implode(" and ", $job_type_arr).")";
		if(count($area)) $_data['where'] .= " and (`wr_area_0` like '".$area_txt."%' or `wr_area_1` like '".$area_txt."%' or `wr_area_2` like '".$area_txt."%')";
		if(count($subway_arr)) $_data['where'] .= " and (".@implode(" and ", $subway_arr).")";
		// : 대학가
		if($_GET['job_college'][0]) $_data['where'] .= " and wr_college_area='".addslashes($_GET['job_college'][0])."'";
		if($_GET['job_college'][1]) $_data['where'] .= " and wr_college_vicinity='".addslashes($_GET['job_college'][1])."'";
		// : 근무기간
		if($_GET['alba_date']) $_data['where'] .= " and `wr_date`='".addslashes($_GET['alba_date'])."'";
		// : 근무요일
		if($_GET['alba_week']) $_data['where'] .= " and `wr_week`='".addslashes($_GET['alba_week'])."'";
		// : 대상별
		if($_GET['wr_target']) $_data['where'] .= " and find_in_set('".addslashes($_GET['wr_target'])."', `wr_target`)";
		// : 근무시간
		if($stime_val) $_data['where'] .= " and `wr_stime`>='".addslashes($stime_val)."'";
		if($etime_val) $_data['where'] .= " and `wr_etime`<='".addslashes($etime_val)."'";
		if($_GET['wr_time_conference']) $_data['where'] .= " and `wr_time_conference`='".addslashes($_GET['wr_time_conference'])."'";
		// : 급여
		if(count($_GET['alba_pay'])>0) $_data['where'] .= " and wr_pay_type in ('".@implode("','", $_GET['alba_pay'])."')";
		if($_GET['wr_pay'][0]) $_data['where'] .= " and wr_pay>='".intval($_GET['wr_pay'][0])."'";
		if($_GET['wr_pay'][1]) $_data['where'] .= " and wr_pay<='".intval($_GET['wr_pay'][1])."'";
		// : 성별
		if(isset($_GET['wr_gender'])) $_data['where'] .= " and wr_gender='".addslashes($_GET['wr_gender'])."'";
		// : 연령
		if($_GET['wr_age_etc']=='over') $_data['where'] .= " and (SUBSTRING_INDEX(wr_age, '-', 1)<='".addslashes($_GET['wr_age'])."' and SUBSTRING_INDEX(wr_age, '-', -1)>='".addslashes($_GET['wr_age'])."')";
		if($_GET['wr_age_etc']=='under') $_data['where'] .= " and SUBSTRING_INDEX(wr_age, '-', 1)<='".addslashes($_GET['wr_age'])."'";
		if($_GET['wr_age_etc']=='1') $_data['where'] .= " and `wr_age_limit`=1";
		// : 학력
		if($_GET['wr_ability']) $_data['where'] .= " and `wr_ability`='".addslashes($_GET['wr_ability'])."'";
		// : 경력
		if($_GET['wr_career_type']) $_data['where'] .= " and `wr_career_type`='".addslashes($_GET['wr_career_type'])."'";
		if($_GET['wr_career_type']==2) $_data['where'] .= " and `wr_career`='".addslashes($_GET['wr_career'])."'";

		if($_GET['search_keyword']) $_keyword_val = $_GET['search_keyword'];
		if($_GET['top_keyword']) $_keyword_val = $_GET['top_keyword'];

		if($_GET['code']=='hurry') $_data['where'] .= " and `wr_service_busy`>=curdate()";


		$top_keyword = strtolower(addslashes($_keyword_val));
		if($top_keyword) {
			$_keyword[] = "LOWER(`wr_subject`) like '%".$top_keyword."%'";
			$_keyword[] = "LOWER(`wr_company_name`) like '%".$top_keyword."%'";
			$_keyword[] = "LOWER(`wr_content`) like '%".$top_keyword."%'";
			$_data['where'] .= " and (".@implode(" or ", $_keyword).")";
		}

		return $_data;
	}

	function resume_search_func() {
		if($_GET['job_type'][0]) $job_type = array_diff($_GET['job_type'], array(""));
		if($_GET['area'][0]) $area = array_diff($_GET['area'], array(""));
		$job_type_txt = @implode("/", $job_type).'/';
		$area_txt = @implode("/", $area).'/';

		// : 직종
		if($job_type[0]) $job_type_arr[] = "(`wr_job_type0`='".$job_type[0]."' or `wr_job_type3`='".$job_type[0]."' or `wr_job_type6`='".$job_type[0]."')";
		if($job_type[1]) $job_type_arr[] = "(`wr_job_type1`='".$job_type[1]."' or `wr_job_type4`='".$job_type[1]."' or `wr_job_type7`='".$job_type[1]."')";
		if($job_type[2]) $job_type_arr[] = "(`wr_job_type2`='".$job_type[2]."' or `wr_job_type5`='".$job_type[2]."' or `wr_job_type8`='".$job_type[2]."')";

		// : 지역
		if($area[0]) $area_arr[] = "(`wr_area0`='".$area[0]."' or `wr_area2`='".$area[0]."' or `wr_area4`='".$area[0]."')";
		if($area[1]) $area_arr[] = "(`wr_area1`='".$area[1]."' or `wr_area3`='".$area[1]."' or `wr_area5`='".$area[2]."')";

		$_data['where'] = "";
		if(count($job_type_arr)) $_data['where'] .= " and (".@implode(" and ", $job_type_arr).")";
		if($_GET['wr_school_ability']) $_data['where'] .= " and `wr_school_ability`='".addslashes($_GET['wr_school_ability'])."'";
		if(count($area_arr)) $_data['where'] .= " and (".@implode(" and ", $area_arr).")";
		if(isset($_GET['wr_career_use'])) $_data['where'] .= " and wr_career_use='".addslashes($_GET['wr_career_use'])."'";
		if(strlen($_GET['wr_gender'])>0) $_data['where'] .= " and mb_gender='".addslashes($_GET['wr_gender'])."'";
		if($_GET['wr_date']) $_data['where'] .= " and wr_date='".addslashes($_GET['wr_date'])."'";
		if($_GET['wr_week']) $_data['where'] .= " and wr_week='".addslashes($_GET['wr_week'])."'";
		if($_GET['wr_time']) $_data['where'] .= " and wr_time='".addslashes($_GET['wr_time'])."'";


		if($_GET['search_keyword']) $_keyword_val = $_GET['search_keyword'];
		if($_GET['top_keyword']) $_keyword_val = $_GET['top_keyword'];

		$top_keyword = strtolower(addslashes($_keyword_val));
		if($top_keyword) {
			$_keyword[] = "LOWER(aar.`wr_subject`) like '%".$top_keyword."%'";
			$_keyword[] = "LOWER(am.`mb_name`) like '%".$top_keyword."%'";
			$_keyword[] = "LOWER(aar.`wr_introduce`) like '%".$top_keyword."%'";
			$_data['where'] .= " and (".@implode(" or ", $_keyword).")";
		}

		return $_data;
	}

	function get_alba($row) {
		global $netfu_util, $member, $member_service, $utility, $alba_resume_user_control, $service_control, $is_admin;

		$result = $row;

		// : 접수기간
		if($row['wr_volume_always'] || $row['wr_volume_end']) {
			if($row['wr_volume_always']) $result['volume_text'] .= " 상시모집";
			if($row['wr_volume_end']) $result['volume_text'] .= " 채용시까지";
		} else {
			if($row['wr_volume_date']>=$netfu_util->today) {
				$result['volume_text'] = $row['wr_volume_date'].'까지';
			} else {
				$result['volume_text'] = " 마감됨";
			}
		}

		// : 시간
		if($row['wr_time_conference']){	// 시간 협의
			$result['wr_time'] = "시간협의";
		} else {
			$result['wr_time'] = $row['wr_stime'] . " ~ " . $row['wr_etime'];	// 근무시간
		}


		// : 열람정보
		$service_check = $service_control->service_check('etc_alba');
		$open_is_pay = $service_check['is_pay'];
		$service_open = $utility->valid_day($member_service['mb_service_alba_open']);	// 공고 열람 서비스 기간 체크

		$is_open_count = false;
		if( $utility->valid_day($member_service['mb_service_alba_open']) && $member_service['mb_service_alba_count'] ){	// 건수 사용이 가능하다면
			$is_open_count = $member_service['mb_service_alba_count'];
		}

		$is_open_alba = $alba_resume_user_control->is_open_resume('alba',$member['mb_id'],$row['wr_id'], $row['no']);	// 열람한 정보가 있는지

		$wr_person = $wr_email = $wr_phone = $wr_hphone = $wr_fax = $company_infos = "";

		// 열람가능 조건
		$receve_row = sql_fetch("select * from alice_resume_proposal where `wr_employ`='".$row['no']."' and `wr_id`='".$member['mb_id']."'");
		$_allow = false;
		if($is_open_count && !$open_is_pay) $_allow = 'count';
		if($service_open || $is_open_count) $_allow = true;
		if($is_admin) $_allow = true;
		if($member['mb_id'] && $member['mb_id']==$row['wr_id']) $_allow = true;
		if($receve_row) $_allow = true;
		if(!$this->job_read_check['is_pay']) $_allow = true;
		$result['is_open__'] = $_allow;

		//<em class="vt_m">비공개</em>

		if(($member['mb_id'] && $member['mb_id']==$row['wr_id']) || $is_admin || $result['is_open__']===true) {
			$result['wr_person'] = $row['wr_person'];
			$result['wr_email'] = "<a href=\"mailto://".$row['wr_email']."\">".$row['wr_email']."</a>";
			$result['wr_phone'] = $row['wr_phone'];
			$result['wr_hphone'] = $row['wr_hphone'];
			$result['wr_fax'] = $row['wr_fax'];
		} else {

			if($open_is_pay && $is_admin==false){	// 열람서비스를 사용한다면 
				if( $service_open || $is_open_alba ) {
					$result['wr_person'] = $row['wr_person'];
					$result['wr_email'] = "<a href=\"mailto://".$row['wr_email']."\">".$row['wr_email']."</a>";
					$result['wr_phone'] = $row['wr_phone'];
					$result['wr_hphone'] = $row['wr_hphone'];
					$result['wr_fax'] = $row['wr_fax'];
				} else if( $is_open_count && !$is_open_alba ){	 // 열람 건수가 있다면
					$result['wr_person'] = $result['wr_email'] = $result['wr_phone'] = $result['wr_hphone'] = $result['wr_fax'] = '<span style="cursor:pointer;" class="vt_n" onclick="open_alba(\''.$row['no'].'\',\''.$row['wr_id'].'\', \'alba\', \''.$is_open_count.'\');">열람권사용</em>';
				} else {
					if($member['mb_type']=='individual')
						$result['wr_person'] = $result['wr_email'] = $result['wr_phone'] = $result['wr_hphone'] = $result['wr_fax'] = '<em class="vt_n" onClick="location.href=\''.NFE_URL.'/payment/read_payment.php\'">열람권결제</em>';
					else
						$result['wr_person'] = $result['wr_email'] = $result['wr_phone'] = $result['wr_hphone'] = $result['wr_fax'] = '<em class="vt_n" onClick="alert(\'개인으로 로그인하셔야합니다.\');">열람권결제</em>';

				}
			} else {
				//if($member['mb_id']==$row['wr_id']){
					$result['wr_person'] = $row['wr_person'];
					$result['wr_email'] = $row['wr_email'];
					$result['wr_phone'] = $row['wr_phone'];
					$result['wr_hphone'] = $row['wr_hphone'];
					$result['wr_fax'] = $row['wr_fax'];
					//$company_infos = "<em class=\"companyDetail positionA\" style=\"bottom:-1px; right:-1px;\"><a href=\"".$alice['alba_path']."/company_info.php?no=".$row['wr_company']."\" target=\"_blank\">회사정보상세보기</a></em>";
				//}
			}
		}

		return $result;
	}


	// : 무료서비스 처리
	function mu_service_process($kind, $no) {
		global $payment_control;
		$get_pg_page = $payment_control->get_pg_page(1);

		switch($kind) {
			case "job":
				if($get_pg_page['alba_pay']) return false;

				$arr['platinum'] = $get_pg_page['main_platinum'];
				$arr['grand'] = $get_pg_page['main_grand'];
				$arr['special'] = $get_pg_page['main_special'];
				$arr['basic'] = $get_pg_page['main_basic'];

				if(is_array($arr)) { foreach($arr as $k=>$v) {
					if($v) {
						$_field = 'wr_service_'.$k;
						$_set[] = $_field."='".date("Y-m-d", strtotime($v))."'";
					}
				} }
				if(count($_set)>0) {
					$update = sql_query("update alice_alba set ".@implode(", ", $_set)." where `no`='".$no."'");
				}

				$move = NFE_URL.'/job/detail.php?no='.$no;
				break;

			default:
				if($get_pg_page['alba_resume_pay']) return false;

				$arr['main_focus'] = $get_pg_page['main_resume_focus'];
				$arr['busy'] = $get_pg_page['main_resume_busy'];
				$arr['basic'] = $get_pg_page['main_resume_basic'];
				if(is_array($arr)) { foreach($arr as $k=>$v) {
					if($v) {
						$_field = 'wr_service_'.$k;
						$_set[] = $_field."='".date("Y-m-d", strtotime($v))."'";
					}
				} }
				if(count($_set)>0) {
					$update = sql_query("update alice_alba_resume set ".@implode(", ", $_set)." where `no`='".$no."'");
				}

				$move = NFE_URL.'/resume/detail.php?no='.$no;
				break;
		}

		return $move;
	}


	function get_resume($row, $member=array()) {
		global $alice, $category_control, $netfu_util, $alba_individual_control;

		$arr = $row;

		$mb_photo_file = NFE_URL."/data/member/".$member['mb_id']."/".$member['mb_photo'];
		$id_pic_num = !$member['mb_gender'] ? '' : 2;
		$arr['mb_photo'] = ($member['mb_photo'] && is_file(NFE_PATH.$mb_photo_file)) ? $mb_photo_file : NFE_URL."/images/id_pic".$id_pic_num.".png";	 // 개인회원 프로필 사진

		// : 근무일시
		if($row['wr_date']) $arr['wr_date'] = $category_control->get_categoryCodeName($row['wr_date']);		// 근무기간
		if($row['wr_week']) $arr['wr_week'] = $category_control->get_categoryCodeName($row['wr_week']);	// 근무요일
		if($row['wr_time']) $arr['wr_time'] = $category_control->get_categoryCodeName($row['wr_time']);		// 근무시간
		if($row['wr_work_direct']) $arr['wr_work_direct'] = ($row['wr_work_direct']) ? "(즉시출근가능)" : "";

		// : 희망근무지
		$count = 0;
		$arr['max_area'] = 0;
		for($i=0; $i<3; $i++) {
			for($j=0; $j<2; $j++) {
				if($row['wr_area'.$count]) {
					$area_val = $netfu_util->get_cate($row['wr_area'.$count]);
					$arr['area'][$i][] = $area_val['name'];
					if($arr['max_area']<=$j) $arr['max_area'] = $j+1;
				}
				$count++;
			}
			if(is_array($arr['area'][$i]))
				$arr['area_val'][$i] = @implode(" ", $arr['area'][$i]);
		}

		// : 희망직종
		$count = 0;
		$arr['max_job_type'] = 0;
		for($i=0; $i<3; $i++) {
			for($j=0; $j<3; $j++) {
				if($row['wr_job_type'.$count]) {
					$area_val = $netfu_util->get_cate($row['wr_job_type'.$count]);
					$arr['job_type'][$i][] = $area_val['name'];
					if($arr['max_job_type']<=$j) $arr['max_job_type'] = $j+1;
				}
				$count++;
			}
			if(is_array($arr['job_type'][$i]))
				$arr['job_type_val'][$i] = @implode(" > ", $arr['job_type'][$i]);
		}

		// : 희망급여
		if($row['wr_pay_conference']){
			$arr['pay_type'] = "추후협의";
		} else {
			$wr_pay_type = $category_control->get_categoryCode($row['wr_pay_type']);
			$arr['pay_type'] = "<b>".$wr_pay_type['name']."</b> <em>".number_format($row['wr_pay'])."원</em>";
		}

		// : 학력사항
		$wr_school_ability = explode('/',$row['wr_school_ability']);
		$arr['wr_school_ability'] = $category_control->get_categoryCode($wr_school_ability[0]);
		$arr['school_ability'] = explode(' ',$arr['wr_school_ability']['name']);

		/* 근무형태 */
		if($row['wr_work_type']){
			$wr_work_type = explode(',',$row['wr_work_type']);	
			$wr_work_type_cnt = count($wr_work_type);
			$work_type = array();
			for($i=0;$i<$wr_work_type_cnt;$i++){
				$work_type_name = $category_control->get_categoryCodeName($wr_work_type[$i]);
				$work_type[] = $work_type_name;
			}
		}
		$arr['work_type'] = @implode(", ", $work_type);


		// : 자격증
		$arr['license'] = '';
		if($row['wr_license']){
			$wr_license = unserialize($row['wr_license']);
			$wr_license_cnt = count($wr_license);
			if($wr_license){
				foreach($wr_license as $key => $val){
					if($key==0){
						$arr['license'] .= $val['name'];
					}
				}
				if($wr_license_cnt >= 2){
					$arr['license'] .= " 외 " . ($wr_license_cnt-1) . "개";
				}
			} else {
				$arr['license'] .= "없음";
			}
		} else {
			$arr['license'] .= "없음";
		}

		// : 외국어
		$arr['language'] = array();
		if($row['wr_language']){
			$wr_language = unserialize($row['wr_language']);
			$wr_language_cnt = count($wr_language);
			if($wr_language){
				foreach($wr_language as $key => $val){
					$language_val = $category_control->get_categoryCode($val['language']);
					if($key==0){
						$arr['language']['name'] = $language_val['name'];
						$language_icon = $alba_individual_control->language_level[$val['level']]['icon'];
						$language_name = $alba_individual_control->language_level[$val['level']]['name'];
						$arr['language']['lv'] = $language_name;
					}
				}
				if($wr_language_cnt >= 2){
					$arr['language']['etc'] = " 외 " . ($wr_language_cnt-1) . "개국어";
				}
				$arr['language_txt'] = '<p>'.$arr['language']['name'].'<em>'.$arr['language']['lv'].'</em> '.$arr['language']['etc'].'</p>';
			} else {
				$arr['language_txt'] = '없음';
			}
		} else {
			$arr['language_txt'] = '없음';
		}

		return $arr;
	}


	function scrap_write() {
		global $member, $alba_user_control, $netfu_util;
		// : 스크랩 했는지 체크
		$row = sql_fetch("select * from alice_scrap where `scrap_rel_table`='".addslashes($_POST['code'])."' and `scrap_rel_id`='".addslashes($_POST['no'])."' and `mb_id`='".$member['mb_id']."' limit 1");
		if($row) $arr['msg'] = "이미 스크랩을 했습니다.";

		// : 정보불러오기
		switch($_POST['code']) {
			case "alba":
				$info = $alba_user_control->get_alba_no($_POST['no']); // 정규직 정보
				if($member['mb_type']!='individual') $arr['mem_msg'] = "개인회원만 스크랩이 가능합니다.";
				break;

			case "alba_resume":
				$info = sql_fetch("select * from alice_alba_resume where `no`='".addslashes($_POST['no'])."'"); // 인재정보
				if($member['mb_type']!='company') $arr['mem_msg'] = "기업회원만 스크랩이 가능합니다.";
				break;

			default:
				break;
		}

		// : 정보가 있는지 체크
		if(!$info && !$arr['msg']) $arr['msg'] = "정보가 존재하지 않습니다.";

		// : 회원종류 체크
		if($arr['mem_msg'] && !$arr['msg']) $arr['msg'] = $arr['mem_msg'];

		// : 스크랩하기
		if(!$arr['msg']) {
			$q = "
			mb_id='".$member['mb_id']."',
			scrap_content='".$info['wr_subject']."',
			scrap_rel_table='".addslashes($_POST['code'])."',
			scrap_rel_id='".addslashes($_POST['no'])."',
			scrap_rel_action='".$netfu_util->today."',
			wdate='".$netfu_util->today_time."'
			";
			$query = sql_query("insert into alice_scrap set ".$q);
			$arr['msg'] = "스크랩이 완료되었습니다.";
			$arr['process'] = true;
		}

		return $arr;
	}
}
?>