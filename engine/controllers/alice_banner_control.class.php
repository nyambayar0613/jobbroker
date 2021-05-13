<?php
		/**
		* /application/nad/design/controller/alice_banner_control.class.php
		* @author Harimao
		* @since 2013/06/12
		* @last update 2015/03/30
		* @Module v3.5 ( Alice ) - b1.0
		* @Brief :: Banner Control class
		* @Comment :: 배너 컨트롤 클래스
		*/
		class alice_banner_control extends alice_banner_model {

			
				/**
				* 배너 정보 입력
				*/
				function insert_banner( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->banner_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 배너 정보 수정
				*/
				function update_banner( $vals, $no ){

					global $utility;

						if($no=='' || !$no)
							return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->banner_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 배너 정보 수정
				* p_no 기준 수정
				*/
				function update_bannerP_no( $vals, $p_no ){

					global $utility;

						if($p_no=='' || !$p_no)
							return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->banner_table."` set " . $val . " where `p_no` = '".$p_no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 배너 정보 삭제
				*/
				function delete_banner( $no ){

					global $alice, $utility;

						if($no=='' || !$no)
							return false;

						$banner = $this->get_banner($no);

						// 파일 삭제
						if($banner['file_type'])	// file_type 이 존재하는 경우 (이미지를 업로드한 경우다)
							@unlink($alice['data_banner_path'] . "/" . $banner['content']);

						// DB 삭제
						$query = " delete from `".$this->banner_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 삭제 후 rank 정렬 :: no 기준
				*/
				function delete_noRank( $no ){

						if($no=='' || !$no)
							return false;

						// rank 값 구함
						$get_banner = $this->get_banner($no);

						// 삭제
						$result = $this->delete_banner($no);
						
						//$query = " update `".$this->banner_table."` set `rank` = rank-1 where `position` = '".$get_banner['position']."' and `rank` > '".$get_banner['rank']."' ";
						$result = $this->_query(" update `".$this->banner_table."` set `g_rank` = g_rank-1 where `position` = '".$get_banner['position']."' and `p_no` = '".$get_banner['p_no']."' and `g_rank` > ".$get_banner['g_rank']." ");


					return $result;

				}

				/**
				* 그룹 삭제 후 rank 정렬 :: no 기준
				*/
				function delete_Group_noRank( $no ){

					global $alice;

						if($no=='' || !$no) return false;

						// rank 값 구함
						$get_banner = $this->get_banner($no);

						// 그룹 순서 수정
						$this->_query(" update `".$this->banner_table."` set `rank` = `rank` - 1 where `position` = '".$get_banner['position']."' and `rank` > ".$get_banner['rank']." ");

						// 그룹 소속 배너 리스트
						$p_no_query = $this->query_fetch_rows(" select * from `".$this->banner_table."` where `p_no` = '".$no."' ");

						// 그룹 소속 배너 파일 삭제
						foreach($p_no_query as $val){
							if($val['file_type'])	// file_type 이 존재하는 경우 (이미지를 업로드한 경우다)
								@unlink($alice['data_banner_path'] . "/" . $val['content']);
							$this->_query(" delete from `".$this->banner_table."` where `no` = '".$val['no']."' ");
						}


					return true;

				}


				/**
				* 배너 보기(단수)
				*/
				function view_banner( $no, $type, $position="", $path="", $admins=false, $banner_width="", $banner_height="" ){

					global $alice, $utility;

						if($no=='' || !$no)
							return false;

						$val = $this->get_banner($no);

						$content = stripslashes($val['content']);

						if($type=='image'){	// 이미지

							if($val['file_type'] > 3){	// swf 파일

								if($admins){

									$swf_file = ($path) ? $path . "/" . $content : $alice['data_banner_path'] . "/" . $content;

									$result  = "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' width='" . $val['width'] . "' height='" . $val['height'] . "' codebase='http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0'>\n";
									$result .= "<param name='movie' value='" . $swf_file . "'>\n";
									$result .= "<param name='wmode' value='opaque'>\n";
									$result .= "<param name='play' value='true'>\n";
									$result .= "<param name='loop' value='true'>\n";
									$result .= "<param name='quality' value='high'>\n";
									$result .= "<embed src='" . $swf_file . "' width='" . $val['width'] . "' height='" . $val['height'] . "' play='true' loop='true' quality='high' pluginspage='http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>\n";
									$result .= "</object>";

								} else {
								
									$result = "<div style=\"height:".$val['height']."px;\"><iframe frameborder=\"0\" leftmargin=\"0\" topmargin=\"0\" width=\"".$val['width']."\" height=\"".$val['height']."\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\" src=\"".$alice['include_path']."/embed.php?no=".$no."\"></iframe></div>";

								}

							} else {	 // 일반 이미지

								$fix_width = 700;		// 고정 가로 사이즈
								$fix_height = 160;		// 고정 세로 사이즈

								if($path)
									$getResizeImg = $utility->getResizeImg($path . "/" . $content, $fix_width, $fix_height);
								else
									$getResizeImg = $utility->getResizeImg($alice['data_banner_path'] . "/" . $content, $fix_width, $fix_height);

								// 가로/세로 사이즈를 고정으로 볼때
								//echo $val['width']." @ " . $val['height'];
								$width = ($val['width'] > $fix_width) ? $getResizeImg['width'] : $val['width'];
								$height = ($val['height'] > $fix_width) ? $getResizeImg['height'] : $val['height'];

								$target = ($val['target']=='_blank') ? "target='".$val['target']."'" : "";
								$result = ($val['url']) ? 
									"<a href='".$utility->set_http($val['url'])."' ".$target." ".$class." id=\"".$val['no']."\"><img src='" . $alice['data_banner_path'] . "/" . $content . "'  class='banner_div__' width='".$val['width']."' height='".$val['height']."'/></a>" :
									"<img src='" . $alice['data_banner_path'] . "/" . $content . "' width='".$val['width']."' height='".$val['height']."'  class='banner_div__'/>";

							}

						} else if($type=='self') {	 // 직접

							$result = "<div style=\"text-align:left;\">\n".$content."\n</div>";

						} else if($type=='adsense'){	// 에드센스

							//echo $banner_width." @ ".$banner_height;
							//echo "<xmp>".$result."</xmp>";

							if($admins)
								$result = $content;
							else
								$result = "<iframe frameborder=\"0\" leftmargin=\"0\" topmargin=\"0\" width=\"".$banner_width."\" height=\"".$banner_height."\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\" src=\"".$alice['include_path']."/addsense.php?no=".$no."\"></iframe>";

							
						}

					
					return $result;

				}


				/**
				* 단순 순위조절
				*/
				function setRank( $position='', $no, $next_no ){

						if($no=='' || !$no)
							return false;

						$get_banner = $this->_getBanner($position,$no);				// 선택 no
						$next_banner = $this->_getBanner($position,$next_no);	// 선택 다음 no

						$vals['rank'] = $next_banner['rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_banner($vals, $no);

						$vals['rank'] = $get_banner['rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_banner($vals, $next_no);


					return $result;

				}

				/**
				* 그룹 순위조절
				* p_no 를 기준하기 때문에 계산 잘해야됨
				*/
				function group_setRank( $position='', $p_no, $next_no ){

						if($p_no=='' || !$p_no) return false;

						$get_banner = $this->_getBanner($position,$p_no);			// 선택 p_no
						$next_banner = $this->_getBanner($position,$next_no);	// 선택 다음 no

						$query = " update `".$this->banner_table."` set `rank` = '".$next_banner['rank']."' where `p_no` = '".$p_no."' ";
						$result = $this->_query($query);

						$query = " update `".$this->banner_table."` set `rank` = '".$get_banner['rank']."' where `p_no` = '".$next_no."' ";
						$result = $this->_query($query);
						

					return $result;


				}

				/**
				* 그룹 내 배너 순위조절
				*/
				function banner_setRank( $position='', $no, $next_no ){

						if($no=='' || !$no)
							return false;

						$get_banner = $this->_getBanner($position,$no);				// 선택 no
						$next_banner = $this->_getBanner($position,$next_no);	// 선택 다음 no

						$vals['g_rank'] = $next_banner['g_rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_banner($vals, $no);

						$vals['g_rank'] = $get_banner['g_rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_banner($vals, $next_no);
						

					return $result;

				}


				/**
				* 그룹 변경시 순위 변경
				*/
				function banner_rankChange( $no, $p_no, $up_no ){

						// g_rank 값 구함
						$get_banner = $this->get_banner($no);

						// p_no 를 기준으로 변경할 배너 정보 추출
						$get_p_no = $this->get_banner($p_no);

						$max_g_rank = $this->get_GroupMaxRank($get_banner['position'], $p_no);

						$result = $this->_query(" update `".$this->banner_table."` set `rank` = '".$get_p_no['rank']."', `g_rank` = '".($max_g_rank['g_rank']+1)."', `g_name` = '".$get_p_no['g_name']."' where `no` = '".$no."' ");

						$up_banner = $this->get_banner($up_no);

						$this->_query(" update `".$this->banner_table."` set `g_rank` = g_rank-1 where `position` = '".$up_banner['position']."' and `p_no` = '".$up_banner['p_no']."' and `g_rank` > ".$get_banner['g_rank']." ");


					return $result;

				}

		}	// class end.
?>