<?php
		/**
		* /application/nad/design/model/alice_popup_model.class.php
		* @author Harimao
		* @since 2013/06/12
		* @last update 2014/01/07
		* @Module v3.5 ( Alice )
		* @Brief :: Popup Model Class
		* @Comment :: 팝업 설정 컨트롤 클래스
		*/
		class alice_popup_model extends DBConnection {

			var $popup_table			= "alice_popup";
			var $popup_skin_table	= "alice_popup_skin";
			var $poup_extension = array( 'jpg', 'gif', 'png', 'swf' );	// 업로드 가능 파일 확장자

			var $success_code = array(
					'0000' => '팝업 입력이 완료 되었습니다.',
					'0001' => '팝업 수정이 완료 되었습니다.',
					'0002' => '팝업 삭제가 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '이미지만 업로드 가능합니다.',
					'0001' => '팝업스킨 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0002' => '팝업스킨 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0003' => '팝업스킨 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0004' => '삭제할 팝업스킨을 선택해 주세요.',
					'0005' => '팝업 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0006' => '팝업 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0007' => '팝업 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0008' => '팝업 출력 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
			);
			var $cookie_arr = array("hour" => "시간", "day" => "일", "week" => "주일", "month" => "개월");
				
				// 팝업 리스트
				function __PopupList( $page="", $page_rows="" ){

						$query = " select * from `".$this->popup_table."` order by `rank` asc ";
						
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


				// 팝업 스킨 리스트
				function __PopupSkinList( $page="", $page_rows="" ){

						$query = " select * from `".$this->popup_skin_table."` order by `no` desc ";
						
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


				// 팝업 정보 추출(단일) :: no 기준
				function get_popup( $no ){

						$query = " select * from `".$this->popup_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 팝업 스킨 정보 추출(단일) :: no 기준
				function get_popupSkin( $no ){

						$query = " select * from `".$this->popup_skin_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 파일 업로드시 확장자 구분
				function _file(){

						$result = implode('|',$this->poup_extension);


					return $result;

				}


				// 팝업 rank 최대값 구함
				function get_MaxRank( ){

						$query = " select max(`rank`) as `rank` from `".$this->popup_table."` ";

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

				}


				// 출력할 팝업이 있는지 확인
				function is_printPopup(){
						
						$unlimit_cnt = $this->_queryR(" select * from `".$this->popup_table."` where `popup_view` = 1 and `popup_unlimit` = 1 ");	// 무제한 팝업 출력 갯수

						$popup_cnt = $this->_queryR(" select * from `".$this->popup_table."` where `popup_view` = 1 and `popup_begin` <= now() and `popup_end` >= now() "); // 기간에 맞는 팝업 출력 갯수

						$result = $unlimit_cnt + $popup_cnt;


					return $result;

				}

				
				// 사용자측 팝업 추출
				function get_PopList($page_name){

					global $alice;
					global $popup_control;

						$popup_list = $this->__PopupList();
						
						$result = "";
						$pop_no = 0;
						foreach($popup_list['result'] as $val){

							if($page_name!='main' && !$val['popup_sub_view'])	// 메인이 아니고, 서브 페이지에서 출력 안할때
								continue;

							$no = $val['no'];
							$skin = $this->get_popupSkin($val['popup_skin']);
							$background = "";
							if($skin['bgimage_file']){
								$background .= "background:";
								$background .= "url('".$alice['data_popup_path']."/".$skin['bgimage_file']."') ".$skin['bgimage_pattern']." ".$skin['bgimage_position'];
								$background .= " #".$skin['border_color'];
							} else {
								$background .= "background:#fff";
							}

							$subject_color = $skin['subject_color'];

							if(!$_COOKIE['popupClose_'.$no]){	// 쿠키 확인

								if(($val['popup_view'] && $val['popup_begin'] <= $alice['time_ymdhis'] && $val['popup_end'] >= $alice['time_ymdhis']) || $val['popup_unlimit']){	// 출력 확인

									if($val['popup_type']){	// 레이어

										echo "<script>$(function(){ $('#popup_".$no."').draggable({ handle: '#popupHandle_".$no."' }); });</script>";

										$result .= "<div id='popup_".$no."' style='position:absolute;width:".$val['popup_width']."px;height:".$val['popup_height']."px;top:".$val['popup_top']."px;left:".$val['popup_left']."px;z-index:9999;'>";

										$result .= "<table width=\"100%\" height=\"100%\" style=\"border:".$skin['border_size']."px solid #".$skin['border_color'].";background:#".$skin['border_color'].";\">";
										if($val['popup_title_view'])	// 제목 출력 유무
											$result .= "<tr><td style='height:25px;line-height:25px;text-align:left;font-size:1rem;padding:2px 5px;cursor:move;color:#".$subject_color."' class='popupLayer' id='popupHandle_".$no."'>".stripslashes($val['popup_title'])."</td></tr>";
										$result .= "<tr>";
										$result .= "<td class=\"pcontents\" style=\"".$background.";\">".stripslashes($val['popup_content'])."</td>";
										$result .= "</tr>";
										if($skin['cookie_time']){
											$result .= "<tr>";
											$result .= "<td class=\"pclose\" style='height:30px;line-height:30px'>";
											$result .= "<dl>";
											$font_color = ($subject_color=='ffffff' || $subject_color=='FFFFFF') ? 'ffffff' : '000000';
											$result .= "<label class='hand' style='color:#".$font_color.";position:relative;padding-left:25px;letter-spacing:-0.03rem'><input name=\"popupCloseNo[]\" type=\"checkbox\" value=\"".$no."\" class=\"check\" id='popupClose_".$no."' style='width:15px;vertical-align:middle;float:left;position:absolute;left:5px;top:1px'>".strtr($val['cookie_time'],$popup_control->cookie_arr)."하루동안 열지 않기</label>";
											$result .= "<span class=\"bar\" style='float:right;cursor:pointer'><a onclick=\"popup_Close('".$no."');\" style='color:#fff'>close<b class=\"pl2\" style='margin:0 5px'>x</b></a></span>";
											$result .= "</dl>";
											$result .= "</td>";
											$result .= "</tr>";
										}
										$result .= "</table>";

										$result .= "</div>";

									} else {	 // 일반 팝업

										/*
										$result .= "<table width=\"100%\" height=\"100%\" style=\"border:0px solid #0;background:#0;\">";
										$result .= "<tr>";
										$result .= "<td class=\"pcontents\" style=\"\">".nl2br(stripslashes($val['popup_content']))."</td>";
										$result .= "</tr>";
										if($val['cookies']){
											$result .= "<tr>";
											$result .= "<td class=\"pclose\">";
											$result .= "<dl>";
											$result .= "<label><input name=\"popupCloseNo[]\" type=\"checkbox\" value=\"".$no."\" class=\"check\">하루동안 열지 않기</label>";
											$result .= "<span class=\"bar\"><a href=\"#\">close<b class=\"pl2\">x</b></a></span>";
											$result .= "</dl>";
											$result .= "</td>";
											$result .= "</tr>";
										}
										$result .= "</table>";
										*/

										$result .= "<script>window.open('".$alice['include_path']."/popup.php?no=".$no."','popupWin_".$no."', 'width=".$val['popup_width'].",height=".$val['popup_height'].",top=".$val['popup_top'].",left=".$val['popup_left'].",scrollbars=no,resizeagle=no,status=no');</script>";

									}

								}	// 출력 확인 if end.
							}

						$pop_no++;
						}	// foeach end.


					echo $result;

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