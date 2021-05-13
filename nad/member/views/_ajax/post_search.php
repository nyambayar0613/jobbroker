<?php
		/*
		* /application/nad/member/views/_ajax/post_search.php
		* @author Harimao
		* @since 2013/07/11
		* @last update 2013/02/05
		* @Module v3.5 ( Alice )
		* @Brief :: Post search
		* @Comment :: 우편번호 검색
		*/

		$alice_path = "../../../../";

		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$keyword = $_POST['keyword'];
		$type = $_POST['type'];

		$result = array();

		switch($mode){

			## 개인회원 우편번호 검색
			case 'individual':
			
				if($type=='new'){	// 도로명 주소

					$result['list'] = $zipcode_control->__NewPostSearch( $keyword );

				} else {	 // 번지 주소

					$result['list'] = $zipcode_control->__PostSearch( $keyword, "desc" );

				}

				echo json_encode($result);

			break;

			## 기업회원 우편번호 검색
			case 'company':

				if($type=='new'){	// 도로명 주소

					$result['list'] = $zipcode_control->__NewPostSearch( $keyword );

				} else {	 // 번지 주소

					$result['list'] = $zipcode_control->__PostSearch( $keyword, "desc" );

				}

				echo json_encode($result);

			break;

			## 네이버 지도 검색
			case 'naver_map_search':

				$search_addr = $_POST['search_addr'];

				$result = $map_control->get_naver_geocode($search_addr);

				if($result[0]){

					echo json_encode($result[0]);

				} else {

					$search_addrs = explode(' ',$search_addr);
					$search_addr = $search_addrs[0]." ".$search_addrs[1]." ".$search_addrs[2];

					$result = $map_control->get_naver_geocode($search_addr);

					echo json_encode($result[0]);

				}

			break;

			## 구글 지도 검색
			case 'google_map_search':

				$search_addr = $_POST['search_addr'];

				$results = $map_control->get_google_geocode($search_addr);

				$address = explode("location",$results);

				$address = explode(":",$address[1]);

				$lat = explode(',',$address[2]);
				$lng = explode('}',$address[3]);

				//$result['lat'] = "'".trim($lat[0])."'";
				//$result['lng'] = "'".trim($lng[0])."'";
				$result['lat'] = trim($lat[0]);
				$result['lng'] = trim($lng[0]);

				echo implode($result,'/');

			break;

		}
?>