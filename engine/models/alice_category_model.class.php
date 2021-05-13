<?php
		/**
		* /application/nad/config/model/alice_category_model.class.php
		* @author Harimao
		* @since 2013/05/26
		* @last update 2013/09/25
		* @Module v3.5 ( Alice )
		* @Brief :: Category Model class
		* @Comment :: 카테고리 모델 클래스
		*/
		class alice_category_model extends DBConnection {

			var $cate_table	 = "alice_category";

			var $success_code = array(
					'0000' => '분류가 입력되었습니다.',
					'0001' => '분류가 수정되었습니다.',
					'0002' => '회원등급 수정이 완료 되었습니다.',
					'0003' => '회원등급이 일괄 수정이 되었습니다.',
					'0004' => '성인 분류 설정이 변경 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '카테고리명을 입력해 주세요.',
					'0001' => '상위 분류가 존재하지 않습니다.',
					'0002' => '분류를 선택해 주세요.',
					'0003' => '분류명을 입력해 주세요.',
					'0004' => '분류 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0005' => '분류 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0006' => '분류 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0007' => '해당 분류에 소속된 하위 분류가 있습니다.\\n\\n분류를 삭제하시려면 소속된 하위 분류 먼저 삭제하세요.',
					'0008' => '순위 조절할 분류를 선택해 주세요.',
					'0009' => '이동할 분류를 선택해 주세요.\\n\\n분류 필드를 클릭하시면 선택됩니다.',
					'0010' => '삭제할 분류를 선택해 주세요.',
					'0011' => '일괄적용할 분류를 선택해 주세요.',
					'0012' => '레벨을 입력해 주세요.',
					'0013' => '포인트를 입력해 주세요.',
					'0014' => '회원등급 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0015' => '회원등급 일괄 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0016' => '회원등급 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0017' => '회원등급 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0018' => '기본포인트 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0019' => '성인 분류로 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',

			);

			var $pay_level = array( "under" => "미만", "exceed" => "초과", "high" => "이상", "low" => "이하" );


				// type에 따른 카테고리 리스트 출력
				// 기본적으로 rank 순
				function __CategoryList( $type, $order=" `rank` asc " ){

						if(!$type) return false;

						$query = " select * from `".$this->cate_table."` where `type` = '".$type."' order by " . $order;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}
				
				// 1차 카테고리만 추출 :: type 기준
				function category_codeList( $type, $order='', $view='' ){

						if(!$type) return false;

						$_order = ($order) ? $order : " `rank` asc ";

						$_view = ($view) ? " and `view` = '".$view."' " : "";

						$query = " select * from `".$this->cate_table."` where `type` = '".$type."' and `p_code` = '' ".$_view." order by " . $_order;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}

				// 1차 카테고리만 추출 :: type 기준 (추가 정보 검색)
				function category_codeLists( $type, $con="", $order='' ){

						if(!$type) return false;

						$_order = ($order) ? $order : " `rank` asc ";

						$query = " select * from `".$this->cate_table."` where `type` = '".$type."' " . $con . " order by " . $_order;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 2차 카테고리만 추출 :: type, p_code 기준
				function category_pcodeList( $type, $p_code, $order='', $con="" ){

						if(!$type || !$p_code) return false;

						$_order = ($order) ? $order : " `rank` asc ";

						$query = " select * from `".$this->cate_table."` where `type` = '".$type."' and `p_code` = '".$p_code."' ".$con." order by " . $_order;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 2차 카테고리 존재 유무 :: no 기준 (count 로 넘긴다.)
				function is_pcode( $no ){

						if(!$no) return false;

						$get_category = $this->get_category($no);

						$query = " select * from `".$this->cate_table."` where `p_code` = '".$get_category['code']."' ";

						$result = $this->_queryR($query);

					
					return $result;

				}


				// p_code 기준 추출
				function pcode_List( $p_code, $order="`rank` asc" ){

						if(!$p_code) return false;

						$query = " select * from `".$this->cate_table."` where `p_code` = '".$p_code."' order by " . $order;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 카테고리 정보 추출(단수) :: no 기준
				function get_category( $no ){

						if(!$no) return false;

						$query = " select * from `".$this->cate_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				
				// 카테고리 정보 추출(단수) :: code 기준
				function get_categoryCode( $code, $_con="" ){

						if(!$code) return false;

						$query = " select * from `".$this->cate_table."` where `code` = '".$code."' " . $_con;

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 카테고리 정보 추출(단수) :: p_code 기준
				function get_categoryPCode( $p_code, $_con="" ){

						if(!$p_code) return false;

						$query = " select * from `".$this->cate_table."` where `p_code` = '".$p_code."' " . $_con;

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 카테고리 type 에 따른 rank 최대값 구함
				function get_MaxRank( $type, $_con="" ){

						if(!$type) return false;

						$query = " select max(`rank`) as `rank` from `".$this->cate_table."` where `type` = '".$type."' " . $_con;

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

				}


				// 카테고리 정보 추출(단수) :: rank 기준
				function get_categoryRank( $rank, $_con="" ){

						if(!$rank) return false;

						$query = " select * from `".$this->cate_table."` where `rank` = '".$rank."' " . $_con;

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 카테고리 option 형태 출력
				function getOption( $type, $value="" ){

						if(!$type) return false;

						$query = " select * from `".$this->cate_table."` where `type` = '".$type."' order by `rank` asc ";

						$options = $this->query_fetch_rows($query);

						$result = "";
						foreach($options as $val){
							$selected = ($val['code']==$value) ? 'selected' : '';
							$result .= "<option value='".$val['code']."' ".$selected.">".stripslashes($val['name'])."</option>";
						}
					
					return $result;

				}


				// 카테고리 option 형태 출력
				function getOption_add( $type, $_con="", $value="" ){

						if(!$type) return false;

						$query = " select * from `".$this->cate_table."` where `type` = '".$type."' " . $_con . " order by `rank` asc ";

						$options = $this->query_fetch_rows($query);

						$result = "";
						foreach($options as $val){
							$selected = ($val['code']==$value) ? 'selected' : '';
							$result .= "<option value='".$val['code']."' ".$selected.">".stripslashes($val['name'])."</option>";
						}
					
					return $result;

				}


				// 카테고리 검색
				function search_category( $type ){
					
						$que = array();

						// 검색 방식에 따른 구분
						switch($type){
							// post 방식
							case 'post':
							
								$type = ($_POST['type']=='success') ? 'graduate' : $_POST['type'];
								$keyword = urldecode($_POST['keyword']);

								if(preg_match("/[a-zA-Z]/", $search_keyword))
									$search_que = " INSTR(LOWER(`name`), LOWER('".$keyword."')) ";
								else
									$search_que = " INSTR(`name`, '".$keyword."') ";
								
								array_push($que, $search_que);

							break;

							// get 방식
							case 'get':

							break;
						}
						
						$query  = " select * from `".$this->cate_table."` where `type` = '".$type."' and `p_code` = '' and `view` = 'yes' ";

						$que = is_array($que) ? implode(' and ',$que) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';

						$query .= $que;
						$query .= "order by rank asc ";

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 단어 검색시 강조
				function search_font($stx, $str) {

						// 문자앞에 \ 를 붙입니다.
						$src = array("/", "|");
						$dst = array("\/", "\|");

						if (!trim($stx)) return $str;

						// 검색어 전체를 공란으로 나눈다
						$s = explode(" ", $stx);

						// "/(검색1|검색2)/i" 와 같은 패턴을 만듬
						$pattern = "";
						$bar = "";
						for ($m=0; $m<count($s); $m++):
							if (trim($s[$m]) == "") continue;
							$tmp_str = quotemeta($s[$m]);
							$tmp_str = str_replace($src, $dst, $tmp_str);
							$pattern .= $bar . $tmp_str . "(?![^<]*>)";
							$bar = "|";
						endfor;

						// 지정된 검색 폰트의 색상, 배경색상으로 대체
						$replace = "<strong class=\"text_blue\">\\1</strong>";	// 강조


					return preg_replace("/($pattern)/i", $replace, $str);

				}



				// 카테고리 정보 추출(단수) :: code 기준
				// name 값 리턴
				function get_categoryCodeName( $code, $_con="" ){

						if(!$code) return false;

						$query = " select * from `".$this->cate_table."` where `code` = '".$code."' " . $_con;

						$result = $this->query_fetch($query);

					
					return stripslashes($result['name']);

				}


				// 성인 직종 분류 확인
				function is_adult_type( $type ){

						if(!$type || $type=='') return false;

						$result = array();

						$count_query = " select * from `".$this->cate_table."` where `type` = '".$type."' and `p_code` = '' and `etc_0` = 1 ";

						$result['is_adult'] = $this->_queryR($count_query);	

						$cate_query = " select * from `".$this->cate_table."` where `type` = '".$type."' and `etc_0` = 1 order by `rank` asc limit 1 ";

						$adult = $this->query_fetch($cate_query);

						$result['adult'] = $adult['code'];

					
					return $result;

				}


				//  code 가 성인 직종인것
				function code_is_adult_type( $code ){

						if(!$code || $code=='') return false;

						$query = " select * from `".$this->cate_table."` where `code` = '".$code."' and `etc_0` = 1  ";

						$result = $this->_queryR($query);


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