<?php
		/*
		* /application/nad/statistics/process/search.php
		* @author Harimao
		* @since 2013/10/30
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Search control
		* @Comment :: 실시간검색어 정보 컨트롤
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];

		$type = $_POST['type'];	// realtime / popular
		$wr_content = $_POST['wr_content'];	// 검색어
		$wr_url = $_POST['wr_url'];	 // 링크주소
		$wr_blank = $_POST['wr_blank'];	// 새창 유무
		$wr_hit = $_POST['wr_hit'];	// 조회수


		switch($mode){

			## 인기검색어 입력
			case 'insert':
				
				$get_LastRank = $search_control->get_MaxRank($type);

				$vals['rank'] = $get_LastRank + 1;

				$vals['wr_type'] = $type;
				$vals['wr_content'] = $wr_content;
				$vals['wr_url'] = $wr_url;
				$vals['wr_blank'] = $wr_blank;
				$vals['wr_wdate'] = $now_date;

				$result = $search_control->insert_search($vals);

			break;

			## 인기검색어 수정
			case 'update':
				
				$vals['wr_content'] = $wr_content;
				$vals['wr_url'] = $wr_url;
				$vals['wr_blank'] = ($wr_blank=='true') ? 1 : 0;
				if($wr_hit)
					$vals['wr_hit'] = $wr_hit;

				$vals['wr_udate'] = $now_date;

				$result = $search_control->update_search($vals, $no);

			break;

			## 인기검색어 삭제
			case 'delete':
				
				$result = $search_control->delete_noRank($no, $type);

			break;

			## 인기검색어 선택 삭제
			case 'sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){

					$result = $search_control->delete_noRank($nos[$i], $type);

				}

			break;

			## 인기검색어 순위 조절
			case 'rank':

				$direction = $_POST['direction'];	// 방향
				
				$next_no = $_POST['next_no'];

				$result = $search_control->setRank($type, $no, $next_no);

			break;

		}	// switch end.

		echo $result;
?>