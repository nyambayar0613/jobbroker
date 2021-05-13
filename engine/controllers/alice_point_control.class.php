<?php
		/**
		* /application/nad/member/controller/alice_point_control.class.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2015/05/13
		* @Module v3.5 ( Alice )
		* @Brief :: Point Control class
		* @Comment :: 포인트 관리 컨트롤 클래스
		*/
		class alice_point_control extends alice_point_model {

				// 설정된 포인트대로 적립/차감
				function point_insert( $mb_id, $point, $content="", $rel_table, $rel_id, $rel_action ){

					global $alice, $config, $env;
					global $member_control;

						$use_point = $env['use_point'];

						if(!$mb_id || $mb_id=="") return false;

						// 포인트를 사용하지 않는다면 패스
						if(!$use_point) return false;

						// 포인트가 없다면 패스
						if(!$point || $point==0) return false;

						$mb = $member_control->get_member($mb_id);

						// 아이디가 없다면 패스
						if(!$mb['mb_id'] || $mb['mb_id']=='') return false;

						// 이미 지급된 내역이 있다면 패스
						if($rel_table || $rel_id || $rel_action){
							$get_point_cnt = $this->get_point_cnt($mb_id, $rel_table, $rel_id, $rel_action);

							if($get_point_cnt['cnt']) return -1;	// -1 리턴

							$this->_query(" insert into `".$this->point_table."` set `mb_id` = '".$mb_id."', `point_datetime` = '".$alice['time_ymdhis']."', `point_content` = '".addslashes($content)."', `point_point` = '".$point."', `point_rel_table` = '".$rel_table."', `point_rel_id` = '".$rel_id."', `point_rel_action` = '".$rel_action."' ");

							// 포인트 내역 합산
							$query = $this->query_fetch(" select sum(`point_point`) as sum_po_point from `".$this->point_table."` where `mb_id` = '".$mb_id."' ");
							$sum_point = $query['sum_po_point'];

							// 회원 포인트 업데이트
							$mb_val['mb_point'] = $sum_point;
							$member_control->update_member($mb_val,$mb_id);

							// 관리자가 설정한 자동등급 조절
							if($mb_id != 'guest'){
								if($env['auto_level']){
									$query = $this->query_fetch(" select * from `".$this->category_table."` where `type` = 'mb_level' and `etc_0` <= ".$sum_point." order by `rank` desc limit 1 ");
									$level_val['mb_level'] = $query['rank'];
									$member_control->update_member($level_val,$mb_id);	// 레벨 업데이트
								}
							}
						}


					return 1;
						
				}


				// 설정된 % 대로 적립/차감
				function point_insert_percent( $mb_id, $price, $content="", $rel_table, $rel_id, $rel_action ){

					global $alice, $config, $env;
					global $member_control;

						$use_point = $env['use_point'];	// 포인트 사용 유무

						if($rel_table=="@employ"){					// 작업 테이블이 채용공고 테이블일 경우
							$point_percent = $env['employ_point_percent'];
						} else if($rel_table=="@resume"){			// 작업 테이블이 이력서 테이블일 경우
							$point_percent = $env['resume_point_percent'];
						} else if($rel_table=="@alba"){				// 작업 테이블이 알바 테이블일 경우
							$point_percent = $env['alba_point_percent'];
						} else if($rel_table=="@alba_resume"){	// 작업 테이블이 알바 이력서 등록일 경우
							$point_percent = $env['alba_resume_point_percent'];
						}

						// 포인트를 사용하지 않는다면 패스
						if(!$use_point) return false;

						// 금액이 없다면 패스
						if(!$price) return false;

						// 포인트 % 가 0 이하 (false) 라면 패스
						if($point_percent <= 0) return false;

						$mb = $member_control->get_member($mb_id);

						// 아이디가 없다면 패스
						if(!$mb['mb_id'] || $mb['mb_id']=='') return false;

						// 이미 지급된 내역이 있다면 패스
						if($rel_table || $rel_id || $rel_action){

							$get_point_cnt = $this->get_point_cnt($mb_id, $rel_table, $rel_id, $rel_action);

							if($get_point_cnt['cnt']) return -1;	// -1 리턴

							$point = ($price * $point_percent) / 100;	// 백분율(%) 계산하여 포인트 산정
							
							$this->_query(" insert into `".$this->point_table."` set `mb_id` = '".$mb_id."', `point_datetime` = '".$alice['time_ymdhis']."', `point_content` = '".addslashes($content)."', `point_point` = '".$point."', `point_rel_table` = '".$rel_table."', `point_rel_id` = '".$rel_id."', `point_rel_action` = '".$rel_action."' ");

							// 포인트 내역 합산
							$query = $this->query_fetch(" select sum(`point_point`) as sum_po_point from `".$this->point_table."` where `mb_id` = '".$mb_id."' ");
							$sum_point = $query['sum_po_point'];

							// 회원 포인트 업데이트
							$mb_val['mb_point'] = $sum_point;
							$member_control->update_member($mb_val,$mb_id);

							// 관리자가 설정한 자동등급 조절
							if($env['auto_level']){
								$query = $this->query_fetch(" select * from `".$this->category_table."` where `type` = 'mb_level' and `etc_0` <= ".$sum_point." order by `rank` desc limit 1 ");
								$level_val['mb_level'] = $query['rank'];
								$member_control->update_member($level_val,$mb_id);	// 레벨 업데이트
							}

						}


					return 1;

				}


				// 포인트 내역 삭제
				function point_delete( $mb_id, $rel_table, $rel_id, $rel_action ){
					
					global $alice, $env;
					global $member_control;

						$result = false;

						if($rel_table || $rel_id || $rel_action){

							$result = $this->_query(" delete from `".$this->point_table."` where `mb_id` = '".$mb_id."' and `point_rel_table` = '".$rel_table."' and `point_rel_id` = '".$rel_id."' and `point_rel_action` = '".$rel_action."' ", false);

							// 포인트 내역 합산
							$query = $this->query_fetch(" select sum(`point_point`) as sum_po_point from `".$this->point_table."` where `mb_id` = '".$mb_id."' ");
							$sum_point = $query['sum_po_point'];

							// 회원 포인트 업데이트
							$mb_val['mb_point'] = $sum_point;
							$member_control->update_member($mb_val,$mb_id);

							// 관리자가 설정한 자동등급 조절
							if($env['auto_level'] && $sum_point){
								$query = $this->query_fetch(" select * from `".$this->category_table."` where `type` = 'mb_level' and `etc_0` <= ".$sum_point." order by `rank` desc limit 1 ");
								$level_val['mb_level'] = $query['rank'];
								$member_control->update_member($level_val,$mb_id);	// 레벨 업데이트
							}

						}

					
					return 1;

				}


				// 포인트 선택 삭제
				function sel_point_delete( $no ){

						if(!$no || $no=='') return false;

						$get_point = $this->get_point($no);

						$result = $this->point_delete($get_point['mb_id'],$get_point['point_rel_table'],$get_point['point_rel_id'],$get_point['point_rel_action']);


					return $result;

				}


		}	// class end.
?>