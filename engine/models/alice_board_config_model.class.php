<?php
		/**
		* /application/nad/board/model/alice_board_config_model.class.php
		* @author Harimao
		* @since 2013/05/29
		* @last update 2015/03/06
		* @Module v3.5 ( Alice )
		* @Brief :: Baord Config Model Class
		* @Comment :: 게시판 환경설정 모델 클래스 (게시판 메인설정, 환경설정 등)
		*/
		class alice_board_config_model extends DBConnection {

			var $board_table	= "alice_board";
			var $config_table	= "alice_board_config";	// 게시판 환경 설정 테이블
			var $main_table		= "alice_board_main";	// 게시판 메인 설정 테이블

			var $board_skins		= array( "default" => "텍스트형", "image" => "이미지형", "webzine" => "웹진형", "on2on" => "1:1상담형", "mix" => "혼합형" );

			var $success_code = array(
					'0000' => '게시판 설정이 완료 되었습니다.',
					'0001' => '게시판 정보가 입력 되었습니다.',
					'0002' => '메뉴가 입력되었습니다.',
					'0003' => '메뉴가 수정되었습니다.',
					'0004' => '게시판 출력형태(스킨)이 변경 되었습니다.\\n\\n게시판 출력형태(스킨)를 변경하시면 게시판 정보를 출력형태(스킨)에 맞게 수정하셔야 합니다.',
					'0005' => '게시판 출력 설정이 변경 되었습니다.',
					'0006' => '게시판 권한 설정이 변경 되었습니다.',
					'0007' => '게시판 분류명이 수정 되었습니다.',
					'0008' => '게시판 분류 출력 설정이 변경 되었습니다.',
					'0009' => '커뮤니티 설정/출력수 수정이 완료 되었습니다.',
					'0010' => '게시판 메인출력 설정이 변경 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '게시판 설정중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '게시판 정보 입력중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '게시판 정보 수정중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '메뉴 입력중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0004' => '해당 메뉴에 소속된 하위 메뉴가 있습니다.\\n\\n메뉴를 삭제하시려면 소속된 하위 메뉴 먼저 삭제하세요.',
					'0005' => '메뉴를 선택해 주세요.',
					'0006' => '메뉴명을 입력해 주세요.',
					'0007' => '메뉴 수정중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0008' => '일괄적용할 메뮤를 선택해 주세요.',
					'0009' => '메뉴 삭제중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0010' => '순위 조절할 메뉴를 선택해 주세요.',
					'0011' => '이동할 메뉴를 선택해 주세요.\\n\\n메뉴 필드를 클릭하시면 선택됩니다.',
					'0012' => '2차 메뉴를 먼저 선택해 주세요.',
					'0013' => '생성된 게시판이 없습니다.',
					'0014' => '생성될 게시판의 소속 메뉴를 먼저 선택해 주세요.',
					'0015' => '게시판 DB Table 생성중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0016' => '게시판 생성중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0017' => '게시판 순위 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0018' => '게시판 출력형태(스킨) 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0019' => '게시판 출력설정 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0020' => '게시판 권한 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0021' => '게시판 분류 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0022' => '게시판 분류 순위 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0023' => '게시판 분류 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0024' => '게시판 분류 출력 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0025' => '게시판 분류 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0026' => '해당 메뉴에 소속된 게시판이 있습니다.\\n\\n메뉴만 삭제하시면 게시판 정보는 남아 있습니다.\\n\\n그래도 삭제하시겠습니까?',
					'0027' => '게시판 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0028' => '게시판 이동중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0029' => '커뮤니티 설정/출력수 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);
		

				// 관리자 => code(메뉴) 별 게시판 리스트
				function __BoardList( $page="", $page_rows="", $con="", $order="" ){

						$order = ($order) ? $order : " `no` desc ";

						$query = " select * from `".$this->board_table."` " . $con . $_add['que'] . " order by " . $order;

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/* 질의문 확인
						echo "<div style='color:#fff;'>";
						echo $query."<br/>";
						echo "</div><br/>";
						*/

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['q'] = $query;
					
					return $result;

				}


				// 게시판 정보 추출(단수) :: no 기준
				function get_board( $no ){

						if(!$no) return false;

						$query = " select * from `".$this->board_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 게시판 정보 추출(단수) :: bo_table 기준
				function get_boardTable( $bo_table ){

						if(!$bo_table) return false;

						$query = " select * from `".$this->board_table."` where `bo_table` = '".$bo_table."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 게시판 정보 추출(단수) :: code 기준
				function get_boardCode( $code, $con="" ){

						if(!$code) return false;

						$query = " select * from `".$this->board_table."` where `code` = '".$code."' " . $con;

						$result = $this->query_fetch($query);

					
					return $result;

				}



				// 상위 code 기준 게시판 리스트 추출
				function boCode_list( $code, $order=" order by `rank` asc " ){

						if(!$code) return false;

						$query = " select * from `".$this->board_table."` where `code` = '".$code."' " . $order;

						$result = $this->query_fetch_rows($query);


					return $result;

				}

				// 상위 메뉴 code 에 따른 rank 최대값 구함
				function get_MaxRank( $code, $_add="" ){

						if(!$code) return false;

						$query = " select max(`rank`) as `rank` from `".$this->board_table."` where `code` = '".$code."' " . $_add;

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

				}


				// 생성 게시판 Scheme
				function board_scheme( $bo_table ){

					global $alice;

						/* 
							생성게시판 스키마
							table prefix :: alice_write_{code}
							field prefix :: wr_{name}
						*/
						$_scheme = "
							CREATE TABLE `".$alice['write_prefix'].$bo_table."` (
							  `wr_no` int(11) unsigned NOT NULL auto_increment,
							  `wr_num` int(11) NOT NULL default '0',
							  `wr_reply` varchar(10) NOT NULL default '',
							  `wr_parent` int(11) NOT NULL default '0',
							  `wr_is_comment` tinyint(4) NOT NULL default '0',
							  `wr_comment` int(11) NOT NULL default '0',
							  `wr_comment_reply` varchar(5) NOT NULL default '',
							  `wr_category` varchar(255) NOT NULL default '' COMMENT '카테고리',
							  `wr_option` varchar(50) NOT NULL default '',
							  `wr_secret` tinyint(4) NOT NULL default '0',
							  `wr_subject` varchar(255) NOT NULL default '',
							  `wr_content` text NOT NULL,
							  `wr_link1` text NOT NULL,
							  `wr_link2` text NOT NULL,
							  `wr_link1_hit` int(11) NOT NULL default '0',
							  `wr_link2_hit` int(11) NOT NULL default '0',
							  `wr_trackback` varchar(255) NOT NULL default '',
							  `wr_hit` int(11) NOT NULL default '0',
							  `wr_good` int(11) NOT NULL default '0',
							  `wr_nogood` int(11) NOT NULL default '0',
							  `wr_id` varchar(255) NOT NULL default '' COMMENT '작성자ID',
							  `wr_password` varchar(255) NOT NULL default '',
							  `wr_name` varchar(255) NOT NULL default '',
							  `wr_email` varchar(255) NOT NULL default '',
							  `wr_homepage` varchar(255) NOT NULL default '',
							  `wr_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
							  `wr_last` varchar(19) NOT NULL default '',
							  `wr_ip` varchar(255) NOT NULL default '',
							  `wr_del` tinyint(4) NOT NULL default '0' COMMENT '삭제여부',
							  `wr_reply_cnt` int(11) NOT NULL default '0',
							  `wr_is_admin` tinyint(4) NOT NULL default '0' COMMENT '관리자작성유무',
							  `wr_0` varchar(255) NOT NULL default '',
							  `wr_1` varchar(255) NOT NULL default '',
							  `wr_2` varchar(255) NOT NULL default '',
							  `wr_3` varchar(255) NOT NULL default '',
							  `wr_4` varchar(255) NOT NULL default '',
							  `wr_5` varchar(255) NOT NULL default '',
							  `wr_6` varchar(255) NOT NULL default '',
							  `wr_7` varchar(255) NOT NULL default '',
							  `wr_8` varchar(255) NOT NULL default '',
							  `wr_9` varchar(255) NOT NULL default '',
							  PRIMARY KEY  (`wr_no`),
							  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
							  KEY `wr_is_comment` (`wr_is_comment`,`wr_no`)
							) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COMMENT '".$bo_table." 게시판';
						";

					
					return $_scheme;

				}

				// 게시판 메인 정보 추출(단수) :: no 기준
				function get_main( $no ){

						$query = " select * from `".$this->main_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
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