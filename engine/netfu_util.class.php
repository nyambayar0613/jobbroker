<?php
class netfu_util {

	var $_mobile_array  = array("iphone","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","android","sony","phone");
	var $mobile_is = false;

	var $paging_arr = array('var'=>'page', 'group'=>10, 'total'=>10, 'num'=>10);
	var $gender_arr = array( 0 => "남", 1 => "여");
	var $gender_val = array( 0 => "성별무관", 1 => "남자", 2 => "여자");
	var $day_arr = array('day'=>'일', 'week'=>'주일', 'month'=>'개월', 'year'=>'년', 'count'=>'건');
	var $today;
	var $today_time;

	// : 문자발송 현황
	var $sms_type_arr = array('give'=>'발송', 'get'=>'수신');

	var $pay_method = array('card'=>'신용카드', 'direct'=>'실시간 계좌이체', 'hphone'=>'핸드폰', 'phone'=>'일반전화', 'bank'=>'무통장입금');
	var $inicis_method = array('card'=>'onlycard', 'direct'=>'onlydbank', 'hphone'=>'onlyhpp', 'phone'=>'onlyphone', 'bank'=>'bank');
	var $allthegate_method = array('card'=>'onlycard', 'direct'=>'onlyiche', 'hphone'=>'onlyhp', 'phone'=>'onlyars', 'bank'=>'bank');
	var $kcp_method = array('card'=>'100000000000', 'direct'=>'010000000000', 'hphone'=>'000010000000', 'phone'=>'000000000010', 'bank'=>'bank');

	// : 사이트관리
	var $site_content = array('site_agreement'=>'회원약관', 'site_privacy'=>'개인정보취급방침', 'privacy_info'=>'개인정보수집이용안내', 'board_criterion'=>'게시판관리기준', 'email_denied'=>'이메일무단수집거부', 'site_bottom'=>'사이트하단', 'email_bottom'=>'메일하단');

	var $military_arr = array('미필', '군필', '면제');

	// : 게시판 가로 개수
	var $bo_width_count_arr = array('default'=>1, 'image'=>2, 'webzine'=>1);
	var $bo_css_word = array('webzine'=>'webzine', 'default'=>'txt', 'image'=>'img', 'text'=>'txt');
	var $search_width_count_arr = array('webzine'=>'5', 'default'=>'5', 'image'=>'6', 'text'=>'5');
	var $bo_title_img = array('default'=>'title_icon02', 'webzine'=>'title_icon02', 'image'=>'title_icon03');

	var $board_where = " and `wr_is_comment` = 0";

// : 생성자
	function netfu_util() {
		$this->today = date("Y-m-d");
		$this->today_time = date("Y-m-d H:i:s");

		// : 회원등급 레벨별
		$mb_level = $this->get_cate_array('mb_level', array('where'=>" and `p_code` = ''"));
		if(is_array($mb_level)) { foreach($mb_level as $k=>$v) {
			$this->mb_level[$v['rank']] = $v;
		} }

		$checkCount = 0; 
		foreach($this->_mobile_array as $k=>$v) {
			if(preg_match("/$v/", strtolower($_SERVER['HTTP_USER_AGENT']))) { $checkCount++; break; }
		}
		if($checkCount>0) $this->mobile_is = true;


		$this->notice_cate = $this->get_cate_code_array('notice');
	}

	function session_put($txt) {
		$_arr = unserialize($_SESSION['_session_arr_']);
		$_arr[$txt] = $_SERVER['QUERY_STRING'];
		$_SESSION['_session_arr_'] = serialize($_arr);
	}

	function session_get($txt) {
		$_arr = unserialize($_SESSION['_session_arr_']);
		$_result = $_arr[$txt];
		if(!$_result) {
			$_res = parse_str($_SERVER['HTTP_REFERER'], $_output);
			$_para = http_build_query($_output, '', '&amp;');
			$_result = $_output;
		}
		return $_result;
	}


	function page_move($msg, $page) {
?>
		<script type="text/javascript">
		<?php if($msg) {?>
		alert("<?=$msg;?>");
		<?php }?>

		<?php if($page) {?>
			location.replace("<?=$page;?>");
		<?php } else {
			history.back();
		}?>
		</script>
<?php
	}

	static function input_htmlspecialchars($datas) {
		if(is_array($datas)) { foreach($datas as $keys=>$vals) {
			switch(is_array($vals)) {
				case true:
					foreach($vals as $keys2=>$vals2) {
						if(is_array($vals2)) continue;
						else $RESULT[$keys][$keys2] = htmlspecialchars(stripslashes($vals2));
					}
					break;
				default:
					$RESULT[$keys] = htmlspecialchars(stripslashes($vals));
					break;
			}
		} } else {
			if($datas) $RESULT = htmlspecialchars(stripslashes($datas));
		}
		return $RESULT;
	}

// : 확장자 값
	function get_ext($name) {
		return array_pop(explode(".", $name));
	}

	function get_age($birth) {
		if(strlen($birth)==4) $birth = $birth.'-01-01';
		return date("Y") - date("Y", strtotime($birth)) + 1;
	}

	function get_stag($txt) {
		return stripslashes(strip_Tags($txt));
	}

	function get_homepage($homepage) {
		if($homepage) {
			if(strpos($homepage, 'http')!==false) $re = $homepage;
			else $re = 'http://'.$homepage;
		} else {
			$re = '';
		}
		return $re;
	}


	function date_txt($txt) {
		return str_replace(array_keys($this->day_arr), $this->day_arr, $txt);
	}

	function sale_price($sale, $price) {
		if($sale>0)
			return $price - ($price*$sale/100);
		else
			return $price;
	}

	function photo_service_print($logo_file, $print_type, $company_name="", $is_mobile=true) {
		switch($print_type){
			case '0':
				if( $is_mobile ){
					$result = "<img src=\"".$logo_file."\" class=\"vm fade_image\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:114px;max-height:57px;\"/>";
				} else {
					$result = "<img src=\"".$logo_file."\" class=\"vm fade_image\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:100px;max-height:50px;\"/>";
				}
			break;
			case '1':
				if( $is_mobile ){
					$result = "<img src=\"".$logo_file."\" class=\"vm blink_image\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:114px;max-height:57px;\"/>";
				} else {
					$result = "<img src=\"".$logo_file."\" class=\"vm blink_image\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:100px;max-height:50px;\"/>";
				}
			break;
			case '2':
				if( $is_mobile ){
					$result = "<div class=\"slide_image\" style=\"position:relative; width:114px; height: 66px; overflow: hidden; display: inline-block;\">";
					$result .= "<img src=\"".$logo_file."\" title=\"".$company_name."\" alt=\"".$company_name."\"/>";
					$result .= "<img src=\"".$logo_file."\" title=\"".$company_name."\" alt=\"".$company_name."\"/>";
					$result .= "</div>";
				} else {
					//$result  = "<div style=\"float:right;margin-left:5px;\" class=\"slide_image\">";
					$result = "<div class=\"slide_image\" style=\"position:relative; width:100px; height: 50px; overflow: hidden; display: inline-block;\">";
					$result .= "<img src=\"".$logo_file."\" title=\"".$company_name."\" alt=\"".$company_name."\"/>";
					$result .= "<img src=\"".$logo_file."\" title=\"".$company_name."\" alt=\"".$company_name."\"/>";
					$result .= "</div>";
				}
			break;
			default:
				if( $is_mobile ){
					$result = "<img src=\"".$logo_file."\" class=\"vm\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:114px;max-height:57px;\"/>";
				} else {
					$result = "<img src=\"".$logo_file."\" class=\"vm\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:100px;max-height:50px;\"/>";
				}
			break;
		}
		return $result;
	}

// : 카테고리 가져오기
	function get_cate($code_arr=array()) {
		if(is_array($code_arr)) { foreach($code_arr as $k=>$v) {
			$row = array();
			if($v) {
				$row = sql_fetch("select * from alice_category where `code`='".$v."'");
			}
			$_re[] = $row['name'];
		} } else {
			if($code_arr)
				return $row = sql_fetch("select * from alice_category where `code`='".$code_arr."'");
		}
		return $_re;
	}

// : 카테고리 전체 가져오기
	function get_cate_array($type, $array=array()) {
		if($array['where']) $_where = $array['where'];
		$q = "select * from alice_category where `type` = '".$type."' and `view`='yes' ".$_where." order by `rank` asc";
		$query = sql_query($q);
		while($row=sql_fetch_array($query)) {
			$arr[] = $row;
		}
		return $arr;
	}

// : 카테고리 code=>name형식으로 전체 가져오기
	function get_cate_code_array($type, $array=array()) {
		if($array['where']) $_where = $array['where'];
		$q = "select * from alice_category where `type` = '".$type."' and `view`='yes' ".$_where." order by `rank` asc";
		$query = sql_query($q);
		while($row=sql_fetch_array($query)) {
			$arr[$row['code']] = $row['name'];
		}
		return $arr;
	}

// 등록일이 현재 날짜를 지났는지 체크, 시간까지는 하지않고 날짜값으로만 한다.
	function valid_day($val){
		if(!$val || $val=='0000-00-00') {
			return false;
		}
		$time = strtotime(date("Y-m-d", mktime()));
		$str_time = strtotime($val);

		if($str_time >= $time) :
			return $val;
		else :
			return false;
		endif;
	}

// : 광고 남은개수
	function get_remain($total, $num, $width='1') {
		$num = $num>0 ? $num : 1;
		if($num>=$total) {
			$nanum = ceil($total/$width);
			return $nanum*$width;
		} else {
			return $total%$num==0 ? $total : $total+($num-($total%$num));
		}
	}

	function createThumb_list($img_width, $img_height, $imgSource, $imgThumb) {
		global $get_img;

			// 이미지체크 
			if($get_img[2]==1){
				$img_org = imagecreatefromgif($imgSource);            //원본 이미지: gif
			}else if($get_img[2]==2){
				$img_org = imagecreatefromjpeg($imgSource);            //원본 이미지: jpg
			}else if($get_img[2]==3){
				$img_org = imagecreatefrompng($imgSource);            //원본 이미지: png
			}else if($get_img[2]==6){
				$img_org = ImageCreateFromBMP($imgSource);
			}else{
				return;
			}


		$target = imagecreatetruecolor($img_width,$img_height); // 리사이징 이미지 생성
		Imagecopyresampled($img_org, $img_org, 0, 0, 0, 0, $img_width, $img_height, $get_img[0], $get_img[1]);  // 리사이징 temp 생성
		imagecopy($target, $img_org, 0, 0, 0, 0, $img_width, $img_height); // 리사이징 temp target에 복사
		imagejpeg($target,$imgThumb,100);
	}

// 파일의 용량을 구한다.
	function get_filesize($size) {

			if ($size >= 1048576) {
				$size = number_format($size/1048576, 1) . "M";
			} else if ($size >= 1024) {
				$size = number_format($size/1024, 1) . "K";
			} else {
				$size = number_format($size, 0) . "byte";
			}


		return $size;
	}

// 게시글에 첨부된 파일을 얻는다. (배열로 반환)
	function get_file( $bo_table, $wr_no ) {
		global $alice, $cat_path;

			$file["count"] = 0;
			$q = " select * from alice_board_file where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' order by `file_no` ";
			$get_files = query_fetch_rows($q);

			foreach($get_files as $val){
				$no = $val['file_no'];
				$file[$no]['href'] = "./download.php?bo_table=" . $bo_table . "&wr_no=".$wr_no."&no=" . $no;
				$file[$no]['download'] = $val['file_download'];
				$file[$no]['path'] = $alice['data_board_path'] . '/' . $bo_table;
				$file[$no]['size'] = $this->get_filesize($val['file_filesize']);
				$file[$no]['datetime'] = $val['file_datetime'];
				$file[$no]['source'] = addslashes($val['file_source']);
				$file[$no]['file_content'] = $val['file_content'];
				$file[$no]['content'] = $this->get_text($val['file_content']);
				$file[$no]['view'] = $this->view_file_link($val['file_name'], $val['file_width'], $val['file_height'], $file[$no]['content']);
				$file[$no]['file'] = $val['file_name'];
				$file[$no]['image_width'] = $val['file_width'] ? $val['file_width'] : 640;
				$file[$no]['image_height'] = $val['file_height'] ? $val['file_height'] : 480;
				$file[$no]['image_type'] = $val['file_type'];
				$file[$no]['width'] = $val['file_width'];		// 실제 파일 가로
				$file[$no]['height'] = $val['file_height'];	// 실제 파일 높이
				$file["count"]++;
			}

		return $file;
	}

// TEXT 형식으로 변환
	// 그누보드 발췌
	function get_text( $str, $html=0 ) {
			// 3.31
			// TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
			if ($html == 0) {
				$str = $this->html_symbol($str);
			}

			$source[] = "/</";
			$target[] = "&lt;";
			$source[] = "/>/";
			$target[] = "&gt;";
			//$source[] = "/\"/";
			//$target[] = "&#034;";
			$source[] = "/\'/";
			$target[] = "&#039;";
			//$source[] = "/}/"; $target[] = "&#125;";
			if ($html) {
				$source[] = "/\n/";
				$target[] = "<br/>";
			}
			
			if ($html){

				$source[] = "/\n/";

				$target[] = "<br/>";

			}
		
		return preg_replace($source, $target, $str);
	}

// : $fname - 파일명, $name - $_FILES[$name]에 사용
	function attach_save($code, $fname, $name, $dir, $mb_id, $mb_type, $photo_no=0, $con="") {
		global $utility, $now_date, $user_control;
		$timg = @getimagesize($dir);
		$file_upload = $utility->file_upload($_FILES[$name]['tmp_name'], $fname, $dir, $_FILES);	// 파일 업로드
		$row = sql_fetch("select * from alice_member_photo where `mb_id` = '".$mb_id."' and `photo_table` = '".$code."' and `photo_no` = '".$photo_no."'");
		if($row) {
			@unlink($dir.$row['photo_name']);
		}
		$upload_file = $file_upload['upload_file'];
		$vals['mb_id'] = $mb_id;
		$vals['mb_type'] = $mb_type;
		$vals['photo_source'] = $_FILES[$name]['name'];
		$vals['photo_name'] = $file_upload['upload_file'];
		$vals['photo_filesize'] = $_FILES[$name]['size'];
		$vals['photo_width'] = $timg[0];
		$vals['photo_height'] = $timg[1];
		$vals['photo_type'] = $timg[2];
		$vals['photo_datetime'] = $now_date;
		$vals['photo_table'] = $code;
		// update
		if($row) $user_control->user_photo_update($vals, $mb_id, $code, $photo_no, $con);
		else $user_control->user_photo_insert($vals);
		return $file_upload;
	}

// 파일을 보이게 하는 링크 (이미지, 플래쉬, 동영상)
	function view_file_link($file, $width, $height, $content="") {
		global $alice, $board;

			$ids = 0;

			if (!$file) return;

			$ids++;

			// 파일의 폭이 게시판설정의 이미지폭 보다 크다면 게시판설정 폭으로 맞추고 비율에 따라 높이를 계산
			/*
			if ($width > $board['bo_image_width'] && $board['bo_image_width']):
				$rate = $board['bo_image_width'] / $width;
				$width = $board['bo_image_width'];
				$height = (int)($height * $rate);
			endif;
			*/

			// 폭이 있는 경우 폭과 높이의 속성을 주고, 없으면 자동 계산되도록 코드를 만들지 않는다.
			if ($width)
				$attr = " width='$width' height='$height' ";
			else
				$attr = "";

			$upload_ext_img = explode('|',$board['bo_upload_ext_img']);
			$ext = $this->get_extension($file);	 // 확장자 검사

			if(in_array($ext,$upload_ext_img))
				return "<img src='".$alice['data_board_path'] . '/' . $board['bo_table']."/".urlencode($file)."' name='target_resize_image[]' onclick='image_window(this);' style='cursor:pointer;' title='$content'>";
	}

// HTML SYMBOL 변환
	// &nbsp; &amp; &middot; 등을 정상으로 출력
	// 그누보드 발췌
	function html_symbol( $str ) {
		return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
	}

// 파일의 확장자를 구하는 함수
	function get_extension( $file ){
			return strtolower(substr(strrchr($file,"."),1));
	}

	function get_date($type, $date) {
		switch($type) {
			case "dot":
				return date("Y.m.d", strtotime($date));
				break;

			default:
				return date("Y-m-d", strtotime($date));
				break;
		}
	}

	function start_slide_num($total) {
		return $total>0 ? 1 : 0;
	}

// : 페이징
	function _paging_start($page, $limit) {
		return $start = $page>0 ? (($page-1)*$limit) : 0;
	}
	function _paging_($arr) {
		if(!$arr['var']) $arr['var'] = $this->paging_arr['var']; // : 페이지 변수
		if(!$arr['group']) $arr['group'] = $this->paging_arr['group']; // : 그룹수
		//if(!$arr['total']) $arr['total'] = $this->paging_arr['total']; // : 총개수
		$arr['total'] = intval($arr['total']);
		if(!$arr['num']) $arr['num'] = $this->paging_arr['num']; // : 한페이지 수

		$_para = http_build_query($_GET, '', '&amp;');
		$_hash = $arr['hash'] ? '&__hash_='.$arr['hash'].$arr['var'] : '';

		if($arr['page']>0) $this_page = $arr['page'];
		else $this_page = $_GET[$arr['var']]>0 ? $_GET[$arr['var']] : 1;

		$start = $this_page>$arr['group'] ? (intval(($this_page-1)/$arr['group'])*$arr['group']) : 0;
		$url_path = $arr['path'] ? $arr['path'] : $_SERVER['PHP_SELF'];
		$url = $url_path.'?'.$_para.'&'.$arr['var'].'=';
		$prev_page = (ceil($this_page/$arr['group'])-1)*$arr['group'];
		$end_page = ceil($arr['total']/$arr['num']);

		if(($start+1)>$arr['group']) $_page[] = '<a href="'.$url.'1'.$_hash.'" class="first">처음</a><a href="'.$url.$prev_page.$_hash.'" class="prev"><</a>';
		for($i=1; $i<=$arr['group']; $i++) {
			$start += 1;
			if($start>$end_page) break;
			$_on = $start==$this_page ? 'active' : '';
			$_page[] = '<a href="'.$url.$start.$_hash.'" class="'.$_on.'">'.$start.'</a>';
		}
		if($start<$end_page) $_page[] = '<a href="'.$url.($start+1).$_hash.'" class="next">></a><a href="'.$url.($end_page).$_hash.'" class="last">마지막</a>';

		$_paging = @implode("", $_page);

		if($arr['num']<$arr['total']) {
			if($arr['type']=='not_bg') return '<ul class="list_con"><div class="paging pg2">'.$_paging.'</div></ul>';
			else return '<div class="paging_con cf"><div class="paging">'.$_paging.'</div></div>';
		}
	}














############## 게시판 ##################
// : 게시판 이미지
	function get_board_img($bo_table, $row) {
		global $alice;
		$data_path = $alice['data_board_path'] . "/" . $bo_table;
		$thumb_path = $data_path.'/thumb';


		// 가변 파일
		$file_array = $this->get_file($bo_table, $row['wr_no']);

		$icon_file = false;
		if($file_array['count'])
			$icon_file = ($row['wr_del']) ? false : true;

		preg_match("/<img[^>]*src=[\'\"]?([^>\'\"]+)[\'\"]?[^>]*>/i", stripslashes($row['wr_content']), $_img);

		if(!$_img){	 // 내용상 이미지가 없다면

			if($file_array[0]['view']){
				$src = $file_array[0]['path']."/".$file_array[0]['file'];
				$get_img = @getimagesize($src); // 파일정보를 가져옴

				// 관리자가 이미지 사이즈를 바꾸었을때를 대비하여 리사이징 크기를 이름에 포함과 이미지 재 첨부시 바뀜
				$img_step1 = explode("_",$file_array[0][file]);
				$img_step2 = explode(".",$img_step1[1]);
				$new_imgname = $img_step2[0];
				$thumb_file_list = $thumb_path . "/187x170_".$new_imgname."_".$row['wr_no'];
				if(!file_exists($thumb_file_list)){
					$gd = gd_info();		// gd lib 체크
					$gdversion = substr(preg_replace("/[^0-9]/", "", $gd['GD Version']), 0, 2); // gd 버전이 2.0 이상인지 체크
					if(!$gdversion){ 
						$thumb_file_list = $src; // gd 2.0 이하면 강제적으로 줄임
					}else{
						if($get_img[0] <= $re_img_width){
							$thumb_file_list = $src;
							$img_height = $re_img_height;
							$img_width = $re_img_width;
						}else{
							// 정비율
							if ($get_img[0] >= $re_img_width){
								$rate = $re_img_width / $get_img[0];
								$img_width = $re_img_width;
								$img_height = (int)($get_img[1] * $rate);
							}

							// 섬네일 파일 체크
							if(!file_exists($thumb_file_list)){
								$this->createThumb_list(187,170,$src, $thumb_file_list); // list 페이지 썸네일
							}
						}
					}
				}

				$img = $thumb_file_list;

			} else {

				$img = "../images/basic/img_01.gif";

			}

		} else {
			$img = ($_img[1]) ? $_img[1] : "../images/basic/img_01.gif";	// 169 x 100

		}

		return $img;
	}

// 게시판 정보 추출(단수) :: bo_table 기준
	function get_boardTable( $bo_table ){
		if(!$bo_table) return false;
		$query = " select * from alice_board where `bo_table` = '".$bo_table."' ";
		$result = sql_fetch($query);
		return $result;

	}

// : 게시판 board_code 
	function get_board_group() {
		$q = "select * from `alice_category` where `type` = 'board_menu' and `p_code` = '' order by `rank` asc";
		$query = sql_query($q);
		while($row=sql_fetch_array($query)) {
			$arr[] = $row;
		}
		return $arr;
	}

// : 게시판 값 가져오기
	function get_board($board_main, $row) {
		global $board_control, $page_type;
		$bo_table = $row['bo_table'];
		$bo_no = $row['no'];
		$bo_print = $board_main[$bo_table];
		$_add = $board_control->_Search();
		if(!$bo_print['view']) return;

		// : 검색인경우 개수정하기
		if($page_type=='search') $bo_print['print_cnt'] = $this->search_width_count_arr[$bo_print['print_type']];

		// : 개수
		$board_width_nums = $this->bo_width_count_arr[$bo_print['print_type']];
		if($board_width_nums<=0) $board_width_nums = 1;

		$_width = $board_width_nums; // : 가로개수
		$_height = ceil($bo_print['print_cnt']/$board_width_nums); // : 세로개수
		$_total = $bo_print['print_cnt']; // : 전체개수
		$_li_width = 100/$_width;
		$_box_num = $_width*$_height;

		$q = 'alice_write_'.$bo_table." where 1 " . $this->board_where;
		$top_keyword = strtolower(addslashes($_GET['top_keyword']));
		if($_GET['top_keyword']) {
			$_search[] = "`wr_subject` like '%".$top_keyword."%'";
			$_search[] = "`wr_content` like '%".$top_keyword."%'";
			$q .= " and (".@implode(" or ", $_search).")";
		}
		$q_txt = "select * from ".$q." order by ".$_add['order']." limit 0, ".$_total;
		$query = sql_query($q_txt);
		$list_num = mysql_num_rows($query);
		$_total = $this->get_remain($list_num, $_box_num, $_width);

		$paging = $this->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$list_num));

		$_bunmo = ($_width*$_height)>0 ? ($_width*$_height) : 1;
		$paging_group = ceil($list_num/$_bunmo);

		$section_class_txt = $this->bo_css_word[$bo_print['print_type']];
		$section_class_txt = $section_class_txt ? $section_class_txt : $bo_print['print_type'];
		if(!$section_class_txt) $section_class_txt = 'txt';
		$section_class = 'community_'.$section_class_txt;
		if($bo_print['print_type']=='webzine') $section_class .= ' web_c';

		$slide_class = 'board_'.$bo_no;

		$arr['bo_print'] = $bo_print;
		$arr['width'] = $_width;
		$arr['height'] = $_height;
		$arr['total'] = $_total;
		$arr['li_width'] = $_li_width;
		$arr['box_num'] = $_box_num>0 ? $_box_num : 1;
		$arr['q'] = $q_txt;
		$arr['query'] = $query;
		$arr['query_total'] = $list_num;
		$arr['paging'] = $paging;
		$arr['paging_group'] = $paging_group;
		$arr['section_class'] = $section_class;
		$arr['slide_class'] = $slide_class;
		$arr['bo_type'] = $section_class_txt;
		$arr['img_size'] = array($bo_print['img_width'], $bo_print['img_height']);

		return $arr;
	}

	// : 게시물정보
	function get_board_info($board, $row) {

		if($row) {

			if($this->today_time<=date("Y-m-d H:i:s", strtotime($row['wr_datetime']." +".$board['bo_new']." hour"))) $_arr['new'] = '<img src="'.NFE_URL.'/images/ic/new.gif" />';

		}

		return $_arr;
	}




	function mailer($datas) {
		global $env;
		require_once NFE_PATH.'/plugin/PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;

		if(!$datas['send_email']) $datas['send_email'] = $env['email'];
		if(!$datas['send_name']) $datas['send_name'] = $env['site_name'];

		//$mail->SMTPDebug = 1;                               // Enable verbose debug output
		$mail->Debugoutput = 'html';
		$mail->CharSet = 'utf-8';

		$mail->isSMTP();                                      // Set mailer to use SMTP
		/*
		$mail->Host = $_SERVER['HTTP_HOST'];  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'netk@daum.net';                 // SMTP username
		$mail->Password = '111';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		*/

		// : 보낸이
		$mail->setFrom($datas['send_email'], $datas['send_name']);
		// : 받을사람
		if(is_array($datas['email_arr'])) { foreach($datas['email_arr'] as $keys=>$vals) {
			$mail->addAddress($vals['email'], $vals['name']);     // Add a recipient
		} }
		/*
		$mail->addReplyTo('netk@daum.net', 'Information');
		$mail->addCC('netk@daum.net');
		$mail->addBCC('netk@daum.net');
		*/

		// : 첨부파일
		if(is_array($datas['email_attach'])) { foreach($datas['email_attach'] as $keys=>$vals) {
			$mail->addAttachment($vals['file'], $vals['name']);         // Add attachments
		} }

		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $datas['subject'];
		$mail->Body    = $datas['content'];
		//$mail->AltBody = '메일내용2';

		$mail->send();
	}



	// : 거리계산함수 - 위도경도로 계산 // : 마일계산은 6371대신 3959로 대체
	function get_distance($datas) {
		return 6371 * acos(cos(deg2rad($datas['this_lat'])) * cos(deg2rad($datas['lat'])) * cos(deg2rad($datas['lng']) - deg2rad($datas['this_lng'])) + sin(deg2rad($datas['this_lat'])) * sin(deg2rad($datas['lat'])));
	}
// : 거리계산 쿼리문 // : 마일계산은 6371대신 3959로 대체
	function distance_q($datas) {
		switch($datas['type']) {
			case 'where':
				return $geo_q = " and ((6371 * acos(cos(radians('".$datas['lat']."')) * cos(radians(".$datas['lat_field'].")) * cos(radians(".$datas['lng_field'].") - radians('".$datas['lng']."')) + sin(radians('".$datas['lat']."')) * sin(radians(".$datas['lat_field'].")))) <= ".$datas['distance'].")";
				break;
			default:
				return $geo_q = '(6371 * acos(cos(radians('.$datas['lat'].')) * cos(radians('.$datas['lat_field'].')) * cos(radians('.$datas['lng_field'].') - radians('.$datas['lng'].')) + sin(radians('.$datas['lat'].')) * sin(radians('.$datas['lat_field'].')))) as map_distance';
				break;
		}
	}

	function icon_tit($k) {
		global $icon_img;
		$img = $k;
		if($icon_img && strpos($k, 'title_icon')===false) $img .= '_'.$icon_img;
		return $img;
	}


	function get_money_txt($txt) {
		$txt = preg_replace(array("/,/"), array(""), $txt);
		if(strlen($txt)>4) return substr($txt, 0, -4);
		else return $txt;
	}

	function get_short_area($area) {
		$area_arr = explode(" ", $area);
		return $area_arr[0].' '.$area_arr[1];
	}
}
?>