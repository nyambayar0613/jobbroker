<?php
		/**
		* /application/nad/alba/model/alice_alba_file_model.class.php
		* @author Harimao
		* @since 2015/01/13
		* @last update 2015/01/13
		* @Module v3.5 ( Alice )
		* @Brief :: Alba file Model Class
		* @Comment :: 관리자측 이력서 파일 관리 모델 클래스
		*/
		class alice_alba_file_model extends DBConnection {

			var $file_table	= "alice_alba_file";


			var $success_code = array(
					'0000' => '파일 등록이 완료 되었습니다.',
					'0001' => '파일 삭제가 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '파일 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '파일 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '파일 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '업로드하신 파일의 확장자는 업로드 불가능합니다.\\n\\n업로드 파일 확장자를 확인해 주세요.',
			);


				// 리스팅
				function __FileList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->file_table."` " . $_add['que'] . $con . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/* 질의문 확인 
						echo "<div style='color:#fff;'>";
						echo $query;
						echo "</div>";
						*/

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// 파일 검색
				function _Search( ){

					global $utility, $config;

						$mode = $_GET['mode'];

						$order = " `no` ";

						$sort = $_GET['sort'];

						if($sort) $order = " `" . $sort . "` ";

						$flag = $_GET['flag'];

						$order .= ($flag) ? " ".$flag." " : " desc ";

						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드
						}

						array_push($url, 'sort='.$sort);
						array_push($url, 'page_rows='.$page_rows);

						$que = is_array($que) ? implode(' and ',$que) : '';

						if($page_rows) array_push( $url, "page_rows=" . $page_rows );
						if($view_type) array_push( $url, "view_type=" . $view_type );
						if($sort) array_push( $url, "sort=" . $sort );
						if($flag) array_push( $url, "flag=" . $flag );

						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " where ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 파일 정보 추출 (단수)
				function get_file( $no ){

						if( !$no || $no == '' ) return false;

						$query = " select * from `".$this->file_table."` where `no` = '".$no."' ";

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