<?php
		/**
		* /application/nad/design/model/alice_logo_model.class.php
		* @author Harimao
		* @since 2013/06/14
		* @last update 2015/03/24
		* @Module v3.5 ( Alice )
		* @Brief :: Logo Model Class
		* @Comment :: 로고 설정 컨트롤 클래스
		*/
		class alice_logo_model extends DBConnection {

			var $logo_table				= "alice_logo";
			var $employ_logo_table	= "alice_employ_logo";	// 채용공고 기본 로고 저장 테이블


			var $logo_extension = array( 'jpg', 'gif', 'png', 'swf' );	// 업로드 가능 파일 확장자

			var $success_code = array(
					'0000' => '로고 등록이 완료 되었습니다.',
					'0001' => '채용공고 기본 로고 등록이 완료 되었습니다.',
					'0002' => '채용공고 기본 로고 삭제가 완료 되었습니다.',
					'0003' => '채용공고 기본 로고가 선택 되었습니다.',
			);

			var $fail_code = array(
					'0000' => '로고 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0001' => '로고는 이미지만 업로드 가능합니다.',
					'0002' => '채용공고 기본 로고 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0003' => '채용공고 기본 로고 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
					'0004' => '채용공고 기본 로고 선택중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
			);

				// 로고 정보 추출(단일)
				function get_logo( $no ){

						if($no=='' || !$no)
							return false;


						$query = " select * from `".$this->logo_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				/**
				* 채용공고 로고 리스트
				*/
				function __EmploylogoList( $page="", $page_rows="", $con="" ){

						$query = " select * from `".$this->employ_logo_table."` " . $con . " order by `no` desc ";

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
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				/**
				* 채용공고 로고 추출 (단일)
				*/
				function getEmployLogo( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->employ_logo_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				/**
				* 채용공고 사용중인 로고 추출
				*/
				function employ_logo(){

						$query = " select * from `".$this->employ_logo_table."` where `wr_logo` = '1' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				/**
				* 이미지 업로드시 확장자 구분
				*/
				function _img(){

						$result = implode('|',$this->logo_extension);

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