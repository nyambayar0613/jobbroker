<?php
		/**
		* /application/nad/design/model/alice_design_model.class.php
		* @author Harimao
		* @since 2013/06/13
		* @last update 2015/03/10
		* @Module v3.5 ( Alice )
		* @Brief :: Design Model Class
		* @Comment :: 디자인 설정 컨트롤 클래스
		*/
		class alice_design_model extends DBConnection {

			var $design_table			= "alice_design";
			var $mail_skin_table		= "alice_mail_skin";

			var $success_code = array(
					'0000' => '메일스킨이 저장 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '메일스킨 저장중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
			);

			var $mail_skin_name = array( "member_regist" => "회원가입", "member_find" => "아이디/비밀번호찾기", "qna" => "고객센터 상담문의", "concert" => "광고/제휴문의", "email_alba_employ" => "정규직 공고 메일전달", "email_alba_resume" => "정규직 이력서 메일전달", "email_become" => "이메일 입사지원", "online_become" => "온라인 입사지원", "proposal_meet" => "면접 제의", "proposal_become" => "입사 제의", "member_mailing" => "회원 메일링" );	// "news_letter" => "뉴스레터"

			var $mail_skin_var = array( "{메일상단로고}", "{메일하단로고}", "{메일하단}", "{사이트명}", "{회원이름}", "{회원아이디}", "{비밀번호}", "{가입일시}", "{문의등록일}", "{문의답변일}", "{문의제목}", "{문의내용}", "{답변내용}", "{기업명}","{보낸사람}", "{전달메시지}", "{도메인}", "{오늘날짜}");	
			// "{상단배너}", "{하단배너}"

			var $mail_become_var = array( "{정규직 공고}", "{정규직 이력서}", "{지원자아이디}", "{지원자명}", "{지원자전화번호}", "{지원자휴대폰}", "{지원자이메일}", "{지원자홈페이지}", "{자사양식}", "{지원첨부파일}", "{파일첨부}", "{지원일}", "{사전질문답변}, {입사지원내용}" );
			var $mail_alba_employ_var = array( "{담당자명}", "{담당자전화번호}", "{담당자휴대폰}", "{담당자이메일}", "{면접제의내용}" );
			//var $mail_alba_resume_var = array( "{정규직 이력서}" , "{지원자명}", "{지원자전화번호}", "{지원자휴대폰}", "{지원자이메일}", "{자사양식}", "{첨부파일}", "{지원일}" );


				// 디자인 정보 추출(단일)
				function get_design( $no ){

						$query = " select * from `".$this->design_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 메일 스킨 디자인 정보 추출(단일)
				function get_mail_skin( $skin_name ){

						$query = " select * from `".$this->mail_skin_table."` where `skin_name` = '".$skin_name."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 브라우저별 스타일 적용
				function get_userAgent_style( $position ){

					global $alice, $utility, $design;


						## 사이트 배경색
						if($position=='site_background'){
							
							if($design['site_background']=='1'){	// 배경색

								if($design['bgcolor_set']){	// 그라데이션

									switch($utility->user_agent()){	// 브라우저별 스타일 적용
										## IE
										case 'IE':
											$style = "filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=".$design['bgcolor_direction'].",StartColorStr=#".$design['bgcolor_begin'].",EndColorStr=#".$design['bgcolor_end'].");";
										break;
										## Chrome, Safari
										case 'Chrome': case 'Safari':
											$directions = ($design['bgcolor_direction']=='1') ? '0% 0%, 100% 0%' : '0% 0%, 0% 100%';
											$style = "background:-webkit-gradient(linear, ".$directions.", from(#".$design['bgcolor_begin']."), to(#".$design['bgcolor_end']."));";
										break;
										case 'FF':	// Firefox
											$directions = ($design['bgcolor_direction']=='1') ? 'left' : 'top';
											$style = "background:-moz-linear-gradient(".$directions.", #".$design['bgcolor_begin'].", #".$design['bgcolor_end'].");";
										break;
										case 'Opera':	// Opera
										break;
											$directions = ($design['bgcolor_direction']=='1') ? 'left' : 'top';
											$style = "background:-o-linear-gradient(".$directions.", #".$design['bgcolor_begin'].", #".$design['bgcolor_end'].");";
									}

									$result = $style;

								} else {	 // 단색

									$result = "background:url() no-repeat top left #".$design['bgcolor'].";";

								}

							} else if($design['site_background']=='2'){	// 배경이미지

								$result = "background:url('".$alice['data_design_path']."/".$design['bgimage_file']."') ".$design['bgimage_pattern']." ".$design['bgimage_position'].";";

							} else {	 // 배경없음
								return false;
							}

						## 메뉴 배경색
						} else if($position=='menu_background'){

							if($design['menu_background']=='1'){	// 배경색

								if($design['topcolor_set']){	// 그라데이션

									switch($utility->user_agent()){	// 브라우저별 스타일 적용
										## IE
										case 'IE':
											$style = "filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=".$design['topcolor_direction'].",StartColorStr=#".$design['topcolor_begin'].",EndColorStr=#".$design['topcolor_end'].");";
										break;
										## Chrome, Safari
										case 'Chrome': case 'Safari':
											$directions = ($design['topcolor_direction']=='1') ? '0% 0%, 100% 0%' : '0% 0%, 0% 100%';
											$style = "background:-webkit-gradient(linear, ".$directions.", from(#".$design['topcolor_begin']."), to(#".$design['topcolor_end']."));";
										break;
										case 'FF':	// Firefox
											$directions = ($design['topcolor_direction']=='1') ? 'left' : 'top';
											$style = "background:-moz-linear-gradient(".$directions.", #".$design['topcolor_begin'].", #".$design['topcolor_end'].");";
										break;
										case 'Opera':	// Opera
										break;
											$directions = ($design['topcolor_direction']=='1') ? 'left' : 'top';
											$style = "background:-o-linear-gradient(".$directions.", #".$design['topcolor_begin'].", #".$design['topcolor_end'].");";
									}

									$result = $style;

								} else {	 // 단색

									$result = "background:url() no-repeat top left #".$design['topcolor'].";";

								}

							} else if($design['menu_background']=='2'){	// 배경이미지

								$result = "background:url('".$alice['data_design_path']."/".$design['topimage_file']."') ".$design['topimage_pattern']." ".$design['topimage_position'].";";

							} else {	 // 배경없음
								return false;
							}

						}

					return $result;

				}

				// 쇼핑몰 메인상품 리스트
				function get_Main_items( $con="", $order="" ){
					
						$_order = ($order) ? $order : " `rank` asc ";

						$query = " select * from `".$this->shop_main_table."` ".$con." order by " . $_order;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}

				// 쇼핑몰 메인상품 추출(단수) :: no 기준
				function get_Main_item( $no ){

						if(!$no) return false;

						$query = " select * from `".$this->shop_main_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 쇼핑몰 메인상품 rank 최대값 구함
				function get_MaxRank( $_add="" ){

						$query = " select max(`rank`) as `rank` from `".$this->shop_main_table."` " . $_add;

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

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