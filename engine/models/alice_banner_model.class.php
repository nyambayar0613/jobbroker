<?php
		/**
		* /application/nad/design/model/alice_banner_model.class.php
		* @author Harimao
		* @since 2013/06/12
		* @last update 2015/04/15
		* @Module v3.5 ( Alice ) - b1.0
		* @Brief :: Banner Model Class
		* @Comment :: 배너 설정 컨트롤 클래스
		*/
		class alice_banner_model extends DBConnection {

			var $banner_table			= "alice_banner";
			
			var $success_code = array(
					'0000' => '배너가 등록되었습니다.',
					'0001' => '배너 수정이 완료 되었습니다.',
					'0002' => '배너가 삭제 되었습니다.',
					'0003' => '배너 설정이 저장되었습니다.',
			);
			var $fail_code = array(
					'0000' => '배너 그룹 순위 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '이미지만 업로드 가능합니다.',
					'0002' => '배너 순위 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '배너 출력 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0004' => '배너 타겟 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0005' => '배너 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0006' => '배너 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0007' => '배너 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0008' => '배너 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);

			var $banner_title = array( 
				'all'=>'공통', 'main' => '메인', 'alba' => '구인정보', 'resume' => '인재정보', 'board' => '커뮤니티', 'etc' => '기타' 
			);

			var $banner_lists			= array( 
				'all' => array( // 공통배너
					0 => array( 'position' => 'all_top', 'name' => '최상단', 'width' => '960', 'height' => '제한없음' ),
					1 => array( 'position' => 'all_left_scroll', 'name' => '좌측스크롤', 'width' => '120', 'height' => '제한없음' ), 
					2 => array( 'position' => 'all_right_scroll', 'name' => '우측스크롤', 'width' => '120', 'height' => '제한없음' ), 
 
				),
				'main' => array( // 메인배너
					0 => array( 'position' => 'main_platinum', 'name' => '플래티넘상단', 'width' => '960', 'height' => '제한없음' ),
					1 => array( 'position' => 'main_grand', 'name' => '그랜드상단', 'width' => '960', 'height' => '제한없음' ), 
					2 => array( 'position' => 'main_special', 'name' => '스페셜상단', 'width' => '960', 'height' => '제한없음' ), 
					3 => array( 'position' => 'main_focus', 'name' => '포커스상단', 'width' => '960', 'height' => '제한없음' ), 
					4 => array( 'position' => 'main_job_list', 'name' => '일반형구인상단', 'width' => '960', 'height' => '제한없음' ), 
					5 => array( 'position' => 'main_indi_list_top', 'name' => '일반형인재상단', 'width' => '960', 'height' => '제한없음' ), 
					6 => array( 'position' => 'main_indi_list_bottom', 'name' => '일반형인재하단', 'width' => '960', 'height' => '제한없음' ), 
				),
				'alba' => array( // 구인정보
					0 => array( 'position' => 'alba_platinum', 'name' => '플래티넘상단', 'width' => '960', 'height' => '제한없음' ), 
					1 => array( 'position' => 'alba_grand', 'name' => '그랜드상단', 'width' => '960', 'height' => '제한없음' ), 
					2 => array( 'position' => 'alba_special', 'name' => '스페셜상단', 'width' => '960', 'height' => '제한없음' ), 
					3 => array( 'position' => 'alba_job_list', 'name' => '일반형구인상단', 'width' => '960', 'height' => '제한없음' ), 
					4 => array( 'position' => 'alba_job_list_bottom', 'name' => '일반형구인하단', 'width' => '960', 'height' => '제한없음' ), 
				),

				'resume' => array( // 인재정보
					0 => array( 'position' => 'resume_focus', 'name' => '포커스상단', 'width' => '960', 'height' => '제한없음' ), 
					1 => array( 'position' => 'resume_indi_list_top', 'name' => '일반형인재상단', 'width' => '960', 'height' => '제한없음' ), 
					2 => array( 'position' => 'resume_indi_list_bottom', 'name' => '일반형인재하단', 'width' => '960', 'height' => '제한없음' ), 
				),
				'board' => array( // 커뮤니티
					0 => array( 'position' => 'board_main_top', 'name' => '커뮤니티메인상단', 'width' => '960', 'height' => '제한없음' ), 
					1 => array( 'position' => 'board_main_bottom', 'name' => '커뮤니티메인하단', 'width' => '960', 'height' => '제한없음' ),
					2 => array( 'position' => 'board_sub_top', 'name' => '게시판상단', 'width' => '960', 'height' => '제한없음' ), 
					3 => array( 'position' => 'board_sub_bottom', 'name' => '게시판하단', 'width' => '960', 'height' => '제한없음' ), 
					4 => array( 'position' => 'board_view_top', 'name' => '게시물상단', 'width' => '960', 'height' => '제한없음' ), 
					5 => array( 'position' => 'board_view_bottom', 'name' => '게시물하단', 'width' => '960', 'height' => '제한없음' ), 
				),
				'etc' => array( // 기타배너
					0 => array( 'position' => 'etc_service_top', 'name' => '광고안내상단', 'width' => '960', 'height' => '제한없음' ),
					1 => array( 'position' => 'etc_service_bottom', 'name' => '광고안내하단', 'width' => '960', 'height' => '제한없음' ),						
					2 => array( 'position' => 'etc_search_top', 'name' => '통합검색상단', 'width' => '960', 'height' => '제한없음' ), 
					3 => array( 'position' => 'etc_search_bottom', 'name' => '통합검색하단', 'width' => '960', 'height' => '제한없음' ),
					4 => array( 'position' => 'etc_map_top', 'name' => '지도검색상단', 'width' => '960', 'height' => '제한없음' ),
					5 => array( 'position' => 'etc_map_bottom', 'name' => '지도검색하단', 'width' => '960', 'height' => '제한없음' ),
					6 => array( 'position' => 'etc_login_top', 'name' => '로그인상단', 'width' => '960', 'height' => '제한없음' ), 
				),

			);

			var $banner_extension = array( 'jpg', 'gif', 'png', 'swf' );	// 업로드 가능 파일 확장자
			var $roll_direction = array( 0 => "scrollHorz", 1 => "scrollHorz", 2 => "scrollVert", 3 => "scrollVert");	// 롤링 방향 문자
			
			var $roll_info = array( // 필요한 경우 사용 하세요
				"roll_type" => array( 0 => "고정배너", 1 => "롤링배너" ),
				"roll_direction" => array( 0 => "좌측 방향", 1 => "우측 방향", 2 => "위 방향", 3 => "아래 방향" ),
				"roll_turn" => array( 0 => "순차번경", 1 => "랜덤변경" ),
			);


				function __BannerList( $page="", $page_rows="" ){

						// 검색시 사용
						$_add = $this->_Search();

						$query = " select * from `".$this->banner_table."` " . $_add['que'] . " order by `rank` asc ";
						
						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}


						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;

					
					return $result;

				}


				// 배너 정보 추출(단일) :: no 기준
				function get_banner( $no ){

						if(!$no)
							return false;

						$query = " select * from `".$this->banner_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 배너 정보 추출(단일) :: position
				function _getBanner( $position, $no){

						$query = " select * from `".$this->banner_table."` where `position` = '".$position."' and `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 배너 랜덤 추출(단수)
				function _getBannerRand( $position, $view='yes' ){

						if(!$position)
							return false;

						$query = " select * from `".$this->banner_table."` where `position` = '".$position."' and `view` = '".$view."' order by rand() limit 1";

						$result = $this->query_fetch($query);


					return $result;
				}


				// 위치별 배너 position 정보 추출
				function _banners( $position ){

						$result = $this->banner_lists[$position];


					return $result;

				}

				
				// 파일 업로드시 확장자 구분
				function _file(){

						$result = implode('|',$this->banner_extension);


					return $result;

				}


				// 현재 position 알아내기
				function _position( $positions, $position ){

					$banner_lists = $this->banner_lists;

						$result = array();

						$positions_cnt = count($banner_lists[$positions]);

						for($i=0;$i<$positions_cnt;$i++){
							
							if($banner_lists[$positions][$i]['position']==$position){

								$result['name'] = $banner_lists[$positions][$i]['name'];
								$result['width'] = $banner_lists[$positions][$i]['width'];
								$result['height'] = $banner_lists[$positions][$i]['height'];

							}

						}


					return $result;

				}

				
				// 출력 위치에 따른 포지션별 배너 리스트
				function _positionBanners( $position, $view='yes' ){

						// 순위별
						$query = " select * from `".$this->banner_table."` where `position` = '".$position."' and `view`= '".$view."' order by `rank` asc ";

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 배너 검색
				function _Search(){

						$page = $_GET['page'];

						$position = $_GET['position'];

						$que = array();
						$url = array();

						if($position){

							array_push($que, " `position` = '".$position."' ");
							array_push($url, "position=".$position);

						}

						array_push($url, 'page='.$page);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que? " where ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url);


				}

				// 배너 rank 최대값 구함
				function get_MaxRank( $position ){

						if(!$position) return false;

						$query = " select max(`rank`) as `rank` from `".$this->banner_table."` where `position` = '".$position."' ";

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

				}

				// 배너 그룹 rank 최대값 구함
				function get_GroupMaxRank( $position, $p_no ){

						if(!$position || !$p_no) return false;

						$query = " select max(`g_rank`) as `g_rank` from `".$this->banner_table."` where `position` = '".$position."' and `p_no` = '".$p_no."' ";

						$result = $this->query_fetch($query);

					
					return ($result['g_rank']) ? $result['g_rank'] : 0;

				}


				// 배너 그룹 정보
				function _group( $position ){
					
						if(!$position) return false;

						$result = array();

						$result['list'] = $result['banner_distinct'] = $this->query_fetch_rows(" select distinct `p_no`, `g_name` from `".$this->banner_table."` where `position` = '".$position."' order by `rank` asc ");
						
						$result['group_count'] = count($result['banner_distinct']);	 // 그룹별 건수

					
					return $result;

				}


				// 질의문에 따른 배너 리스트 출력 (그룹별로 검색시 사용)
				function banner_list( $con="" ){

						$query = " select * from `".$this->banner_table."` " . $con . " order by `g_rank` asc ";

						$total_count = $this->_queryR($query);

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;

					
					return $result;

				}

				
				// p_no 를 기준으로 단수 추출
				function banner_Pno( $p_no ){

						if(!$p_no || $p_no == '') return false;

						$query = " select * from `".$this->banner_table."` where `no` = `p_no` and `p_no` = '".$p_no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				/*
				// 배너 그룹 정보
				function _getGroup( $position, $no ){

					global $alice, $utility;
						
						if(!$position || !$no) return false;

						//$list = $banner_distinct = $query->query_fetch(" select distinct `p_no`, `g_rank` from `".$this->banner_table."` where `no` = '".$no."' ");
						//$group_cnt = count($banner_distinct);	 // 그룹별 건수

				}
				*/

				// 포지션별 사용자측 배너 추출
				function get_banner_for_position( $position ){

					global $utility;
					global $page_name;
					
						if(!$position || $position == '') return false;

						$results = array();

						switch($position){

							## 메인 최상단 (쿠키가 필요하며, 1개씩만 출력해야 하기 때문에 별도의 쿼리가 필요함)
							case 'all_top':
							
								$rand_query = $this->query_fetch(" select * from `".$this->banner_table."` where `position` = '".$position."' and `view` = 1 order by rand() limit 1 ");	// 1개만 추출

								$roll_type = $rand_query['roll_type'];
								$roll_direction = $this->roll_direction[$rand_query['roll_direction']];
								$roll_time = $rand_query['roll_time'];
								$roll_turn = $rand_query['roll_turn'];

								$query_order = ($roll_turn) ? " rand() " : " `g_rank` asc ";

								$max_size = $this->query_fetch(" select `width`, `height` from `".$this->banner_table."` where `p_no` = '".$rand_query['p_no']."' order by `width` desc, `height` desc limit 1");

								$width = $max_size['width'];
								$height = $max_size['height'];

								$ids = $utility->getOrderNumber(6);

								$result = "";

								if($roll_type){	// 롤링배너

									$query = $this->query_fetch_rows(" select * from `".$this->banner_table."` where `view` = 1 and `p_no` = '".$rand_query['p_no']."' and `position` = '".$position."' order by " . $query_order );

									if($query){

										$banner_cnt = 0;
										foreach($query as $val){
											if($_COOKIE[$page_name."_banner_".$val['no']]!='done'){
												$results[] = $this->view_banner($val['no'], $val['type'], $val['position'], false, false, $width, $height);
												$banner_cnt++;
											}
										}

										//$sizes = ($width && $height) ? "width:".$width."px;height:".$height."px;" : "";
										
										$results_length = count($results);

										if(!$banner_cnt) return false;

										$reverse_add = in_array($banner_Pno['roll_direction'], array(1,2)) ? 'data-cycle-reverse = true' : '';

										$result .= "<div id=\"".$ids."\" style=\"position:relative;".$sizes."\"
											class='cycle-slideshow'
											data-cycle-fx=".$roll_direction."
											data-cycle-timeout=".$roll_time."000
											data-cycle-slides='.".$page_name."_banner_c'
											".$reverse_add."
										>\n";
										for($i=0;$i<$banner_cnt;$i++){
											$result .= "<div class='".$page_name."_banner_c' id=\"".$page_name."_banner_".$query[$i]['no']."\">\n";
											$result .= $results[$i];
											if($query[$i]['cookie']){
												$result .= "<p class=\"close\"><input type=\"checkbox\" value=\"".$query[$i]['no']."\"  name=\"more_no_view\" onclick=\"more_no_views(this, '".$query[$i]['cookie']."', '".$page_name."', '".$ids."');\"><span>".$query[$i]['cookie']."일간 보지 않기</span></p>\n";
												// <button class=\"btn\" onclick=\"\" type=\"button\">닫기</button>
											}
											$result .= "</div>\n";
										}
										$result .= "</div>\n";

									}

								} else {	 // 고정배너

									$query = $this->query_fetch(" select * from `".$this->banner_table."` where `view` = 1 and `p_no` = '".$rand_query['p_no']."' and `position` = '".$position."' order by rand() " );

									if($query){

										//$sizes = ($width && $height) ? "width:".$width."px;height:".$height."px;" : "";

										if($_COOKIE[$page_name."_banner_".$query['no']]!='done'){

										$result .= "<div id=\"".$ids."\" style=\"position:relative;".$sizes."\" class='banner_parent_div__'>\n";

											$result .= "<div id=\"".$page_name."_banner_".$query['no']."\">\n";

											$result .= $this->view_banner($query['no'], $query['type'], $query['position'], false, false, $width, $height);
											if($query['cookie']){
												$result .= "<p class=\"close\"><input type=\"checkbox\" value=\"".$query['no']."\"  name=\"more_no_view\" onclick=\"more_no_views(this, '".$query['cookie']."', '".$page_name."', '".$ids."');\"><span>".$query['cookie']."일간 보지 않기</span></p>\n";
												// <button class=\"btn\" onclick=\"more_no_views(documet.n, '".$query['cookie']."', '".$page_name."');\" type=\"button\">닫기</button>
											}

											$result .= "</div>\n";

										$result .= "</div>\n";

										}

									}
								}

							break;

							case 'main_platinum':			## 메인 플래티넘 
							case 'main_grand':				## 메인 그랜드
							case 'main_special':			## 메인 스페셜
							case 'main_focus':				## 메인 포커스
							case 'main_job_list':			## 메인 일반구인공고
							case 'main_indi_list_top':		## 메인 일반인재공고상단
							case 'main_indi_list_bottom':	## 메인 일반인재공고하단

							case 'alba_platinum':			## 서브 플래티넘
							case 'alba_grand':				## 서브 그랜드
							case 'alba_special':				## 서브 스페셜
							case 'alba_job_list':			## 서브 일반구인공고
							case 'alba_job_list_bottom':			## 서브 일반구인공고하단
							case 'resume_focus':				## 서브 포커스
							case 'resume_indi_list_top':		## 서브 일반인재공고상단
							case 'resume_indi_list_bottom':		## 서브 일반인재공고하단
							case 'board_main_top':			## 커뮤니티 메인 상단
							case 'board_main_bottom':			## 커뮤니티 메인 하단
							case 'board_sub_top':			## 게시판 상단
							case 'board_sub_bottom':			## 게시판 하단
							case 'board_view_top':			## 게시물 상단
							case 'board_view_bottom':		## 게시물 하단
							case 'etc_service_top':				## 광고안내 상단
							case 'etc_service_bottom':				## 광고안내 하단
							case 'etc_search_top':				## 통합검색 상단
							case 'etc_search_bottom':				## 통합검색 하단
							case 'etc_map_top':					## 지도검색 상단
							case 'etc_map_bottom':					## 지도검색 하단
							case 'etc_login_top':				## 로그인 상단


								$result = "";

								$get_group = $this->_group( $position );
								$group_list = $get_group['list'];
								$group_list_cnt = count($group_list);

								$g = 0;
								foreach($group_list as $group){	// 그룹 전체

									$ids = $utility->getOrderNumber(6);

									$p_no = $group['p_no'];
									$banner_list = $this->banner_list( " where `p_no` = '".$p_no."' and `view` = 1 " );

									if(!$banner_list['total_count']) continue;

									$banner_Pno = $this->banner_Pno($p_no);
									$roll_type = $banner_Pno['roll_type'];
									$roll_direction = $this->roll_direction[$banner_Pno['roll_direction']];
									$roll_time = $banner_Pno['roll_time'];
									$roll_turn = $banner_Pno['roll_turn'];

									$max_size = $this->query_fetch(" select `width`, `height` from `".$this->banner_table."` where `p_no` = '".$p_no."' order by `width` desc, `height` desc limit 1");

									$width = $max_size['width'];
									$height = $max_size['height'];

									//$sizes = ($width && $height) ? "width:".$width."px;height:".$height."px;" : "";

									//$rand_class = ($group_list_cnt-1 == $g) ? " Rend" : "";
									$rand_class = ($group_list_cnt-1 == $g && $g) ? " Rend" : "";
									$reverse_add = in_array($banner_Pno['roll_direction'], array(1,2)) ? 'data-cycle-reverse = true' : '';

									if($roll_type){	// 롤링배너
										
										$mr8 = ($width >= 476) ? 'mr8 ' : '';
										$result .= "<li class=\"".$mr8."mb8".$rand_class."\">\n";
										$result .= "<div id=\"".$ids."\" style=\"".$sizes."\"
											class='cycle-slideshow'
											data-cycle-fx=".$roll_direction."
											data-cycle-timeout=".$roll_time."000
											data-cycle-slides='.".$page_name."_banner_c'
											".$reverse_add."
										>\n";

										foreach($banner_list['result'] as $key => $val){

											$result .= "<div class='".$page_name."_banner_c' id=\"".$page_name."_banner_".$val['no']."\">";
												$result .= $this->view_banner($val['no'], $val['type'], $val['position'], false, false, $width, $height);
											$result .= "</div>\n";

										}

										$result .= "</div>\n";
										$result .= "</li>\n";

									} else {	 // 고정배너

										$query = $this->query_fetch(" select * from `".$this->banner_table."` where `view` = 1 and `p_no` = '".$p_no."' order by rand() " );

										//$sizes = ($width && $height) ? "style=\"width:".$width."px;height:".$height."px;\"" : "";

										$result .= "<li class=\"mr8 mb8".$rand_class."\">";
											$result .= $this->view_banner($query['no'], $query['type'], $query['position'], false, false, $width, $height);
										$result .= "</li>\n";

									}

								$g++;
								}

							break;


							## 메인 좌측, 우측 스크롤 배너
							case 'all_left_scroll':
							case 'all_right_scroll':

								$result = "";

								$get_group = $this->_group( $position );
								$group_list = $get_group['list'];

								foreach($group_list as $group){	// 그룹 전체

									$ids = $utility->getOrderNumber(6);

									$p_no = $group['p_no'];
									$banner_list = $this->banner_list( " where `p_no` = '".$p_no."' and `view` = 1 " );

									if(!$banner_list['total_count']) continue;

									$banner_Pno = $this->banner_Pno($p_no);
									$roll_type = $banner_Pno['roll_type'];
									$roll_direction = $this->roll_direction[$banner_Pno['roll_direction']];
									$roll_time = $banner_Pno['roll_time'];
									$roll_turn = $banner_Pno['roll_turn'];

									$max_size = $this->query_fetch(" select `width`, `height` from `".$this->banner_table."` where `p_no` = '".$p_no."' order by `width` desc, `height` desc limit 1");

									$width = $max_size['width'];
									$height = $max_size['height'];

									//$sizes = ($width && $height) ? "width:".$width."px;height:".$height."px;" : "";
									$reverse_add = in_array($banner_Pno['roll_direction'], array(1,2)) ? 'data-cycle-reverse = true' : '';
									if($roll_type){	// 롤링배너

										$result .= "<div  id=\"".$ids."\" style=\"".$sizes."\"
											class='cycle-slideshow'
											data-cycle-fx=".$roll_direction."
											data-cycle-timeout=".$roll_time."000
											data-cycle-slides='.".$page_name."_banner_c'
											".$reverse_add."
										>\n";

										foreach($banner_list['result'] as $key => $val){

											$result .= "<div class='".$page_name."_banner_c' id=\"".$page_name."_banner_".$val['no']."\">";
												$result .= $this->view_banner($val['no'], $val['type'], $val['position'], false, false, $width, $height);
											$result .= "</div>\n";

										}

										$result .= "</div>\n";

									} else {	 // 고정배너

										$query = $this->query_fetch(" select * from `".$this->banner_table."` where `view` = 1 and `p_no` = '".$p_no."' order by rand() " );

										//$sizes = ($width && $height) ? "style=\"width:".$width."px;height:".$height."px;\"" : "";

										$result .= "<div class=\"mt5\">";
											$result .= $this->view_banner($query['no'], $query['type'], $query['position'], false, false, $width, $height);
										$result .= "</div>\n";

									}

								}

							break;


							## 기타 위치 배너
							default:

							break;

						}	// switch end.

					
					return $result;

				}


				/**
				* 에러코드에 맞는 에러를 토해낸다.
				*/
				function _errors( $err_code ){

						$result = $this->fail_code[$err_code];

					return $result;

				}

				/**
				* 완료코드에 맞는 에러를 토해낸다.
				*/
				function _success( $success_code ){

						$result = $this->success_code[$success_code];

					return $result;

				}


		}	// class end.
?>