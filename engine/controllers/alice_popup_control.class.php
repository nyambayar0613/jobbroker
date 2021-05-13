<?php
		/**
		* /application/nad/design/controller/alice_popup_control.class.php
		* @author Harimao
		* @since 2013/06/12
		* @last update 2013/06/17
		* @Module v3.5 ( Alice )
		* @Brief :: Popup Control class
		* @Comment :: 팝업 컨트롤 클래스
		*/
		class alice_popup_control extends alice_popup_model {

			
				/**
				* 팝업 정보 입력
				*/
				function insert_popup( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->popup_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 팝업 정보 수정
				*/
				function update_popup( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->popup_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 팝업 스킨 정보 입력
				*/
				function insert_popupSkin( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->popup_skin_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 팝업 스킨 정보 수정
				*/
				function update_popupSkin( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->popup_skin_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 팝업 정보 삭제
				*/
				function delete_popup( $no ){

					global $alice, $utility;

						// DB 삭제
						$query = " delete from `".$this->popup_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 팝업 스킨 정보 삭제
				*/
				function delete_popupSkin( $no ){

					global $alice, $utility;

						// DB 삭제
						$query = " delete from `".$this->popup_skin_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 삭제 후 rank 정렬 :: no 기준
				*/
				function delete_noRank( $no ){

						// rank 값 구함
						$get_popup = $this->get_popup($no);

						// 삭제
						$result = $this->delete_popup($no);
						
						$query = " update `".$this->popup_table."` set `rank` = rank-1 where `rank` > '".$get_popup['rank']."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 순위조절
				*/
				function setRank($no, $next_no){

						$get_popup = $this->get_popup($no);				// 선택 no
						$next_popup = $this->get_popup($next_no);	// 선택 다음 no
						
						$vals['rank'] = $next_popup['rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_popup($vals, $no);

						$vals['rank'] = $get_popup['rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_popup($vals, $next_no);


					return $result;

				}


				/**
				* 팝업 스킨 이미지 :: 내용에 삽입
				*/
				function _imageUpload( $vals, $no='' ){

					global $utility;

						$val = $utility->QueryString($vals);

						if($no)

							$query = " insert into `".$this->popup_skin_table."` set " . $val;

						else

							$query = " update `".$this->popup_skin_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}





		}	// class end.
?>