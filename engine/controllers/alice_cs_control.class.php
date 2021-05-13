<?php
		/**
		* /application/nad/board/controller/alice_cs_control.class.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/10/01
		* @Module v3.5 ( Alice )
		* @Brief :: CS Control class
		* @Comment :: CS (1:1 문의, 광고/제휴, FAQ) 컨트롤 클래스
		*/
		class alice_cs_control extends alice_cs_model {


				/**
				* CS 정보 입력
				*/
				function insert_cs( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->cs_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* CS 정보 수정 :: no 기준
				*/
				function update_cs( $vals, $no ){

					global $utility;

						if($no=='' || !$no)
							return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->cs_table."` set " . $val . " where `no` = '" . $no . "' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* CS 정보 삭제
				*/
				function delete_cs( $no ){

					global $alice, $utility;

						if($no=='' || !$no)
							return false;

						// DB 삭제
						$query = " delete from `".$this->cs_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 순위조절
				*/
				function setRank( $cs_type='', $cs_cate='', $no, $next_no ){

						if($no=='' || !$no)
							return false;

						$get_cs = $this->_getCSRank($cs_type,$cs_cate,$no);				// 선택 no
						$next_cs = $this->_getCSRank($cs_type,$cs_cate,$next_no);	// 선택 다음 no

						$vals['rank'] = $next_cs['rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_cs($vals, $no);

						$vals['rank'] = $get_cs['rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_cs($vals, $next_no);


					return $result;

				}


				/**
				* hit up
				*/
				function hit_up( $no ){

						if($no=='' || !$no)
							return false;

						//$get_cs = $this->get_cs($no);

						$query = " update `".$this->cs_table."` set `wr_hit` = `wr_hit` + 1 where `no` = '".$no."' ";

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
						$get_cs = $this->get_cs($no);

						// 삭제
						$result = $this->delete_cs($no);
						
						$query = " update `".$this->cs_table."` set `rank` = rank-1 where `wr_type` = '".$get_cs['wr_type']."' and `wr_cate` = '".$get_cs['wr_cate']."' and `rank` > '".$get_cs['rank']."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* rank 정렬 :: no 기준
				*/
				function _noRank( $no ){

						if($no=='' || !$no)
							return false;

						// rank 값 구함
						$get_cs = $this->get_cs($no);

						$query = " update `".$this->cs_table."` set `rank` = rank-1 where `wr_type` = '".$get_cs['wr_type']."' and `wr_cate` = '".$get_cs['wr_cate']."' and `rank` > '".$get_cs['rank']."' ";


						$result = $this->_query($query);


					return $result;

				}


				/**
				* CS 메일 발송시 내용 치환
				* no 값으로 해당 게시물 정보를 추출한 후 치환한다.
				*/
				function _replaces( $no, $msg ){

					global $alice, $env;
					global $logo_control, $member_control;

						if($no=='' || !$no)
							return false;

						$urls = $alice['url'] . "/../" . $alice['data'] . "/logo/";

						$get_cs = $this->get_cs($no);

						$get_logo = $logo_control->get_logo(1);	// 로고정보
						$mail_logo = "<img src='" . $urls . $get_logo['mail'] . "'/>";
						$mail_bottom = "<img src='" . $urls . $get_logo['mail_bottom'] . "'/>";
						
						$get_member = $member_control->get_member($get_cs['wr_id']);	// 회원정보
						$mb_name = ($get_cs['wr_name']) ? $get_cs['wr_name'] : stripslashes($get_member['mb_name']);

						$trans = array(
							"{메일상단로고}" => $mail_logo,
							"{회원이름}" => $mb_name,
							"{사이트명}" => stripslashes($env['site_name']),
							"{문의등록일}" => $get_cs['wr_date'],
							"{문의답변일}" => $get_cs['wr_adate'],
							"{문의제목}" => stripslashes($get_cs['wr_subject']),
							"{문의내용}" => nl2br(stripslashes($get_cs['wr_content'])),
							"{답변내용}" => nl2br(stripslashes($get_cs['wr_acontent'])),
							"{메일하단로고}" => $mail_bottom,
							"{메일하단}" => nl2br(stripslashes($env['email_bottom'])),
							"{도메인}" => 'http://'.$_SERVER['HTTP_HOST'],
						);

						$result = strtr($msg, $trans);


					return $result;

				}

		}	// class end.
?>