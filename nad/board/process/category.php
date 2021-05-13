<?php
		/*
		* /application/nad/board/process/category.php
		* @author Harimao
		* @since 2013/05/24
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Category control
		* @Comment :: 카테고리 정보 컨트롤
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax			= $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode			= $_POST['mode'];
		$type			= $_POST['type'];				// 카테고리 구분값
		$multi_depth	= $_POST['multi_depth'];	// 다차원 카테고리 구분값
		$p_code		= $_POST['p_code'];			// 다차원 카테고리의 경우 parent code 값 필요
		$cate				= $_POST['cate'];				// 카테고리 depth
		$is_job			= ($type=='job_type') ? true : false;

		// 순위조절시 사용 변수
		$no = $_POST['no'];
		$next_no = $_POST['next_no'];

		switch($mode){

			## 카테고리 입력
			case 'insert':

				$vals['type'] = $type;
				$vals['etc_0'] = $_POST['etc_0'];	 // 성인 카테고리 유무

				if($multi_depth){	// 다중 카테고리

					$vals['code'] = $utility->get_unique_code();
					$vals['p_code'] = $p_code;
					$vals['name'] = $_POST['name'];
					$vals['view'] = $_POST['view'];

					if($cate=='cate_0')	 // 1차 분류
						$get_LastRank = $category_control->get_MaxRank($type);	// rank 최대값 구함
					else	 // 2/3차분류
						$get_LastRank = $category_control->get_MaxRank($type," and `p_code` = '".$p_code."' ");	// rank 최대값 구함

					$vals['rank'] = $get_LastRank + 1;

					$vals['wdate'] = $now_date;
					
					$result = $category_control->insert_category($vals);

					if($result){
						if($p_code)
							$category = $category_control->category_pcodeList($type,$p_code);// 2,3차 카테고리 리스트
						else
							$category = $category_control->category_codeList($type);	// 1차 카테고리 리스트

						foreach($category as $val) { 
						$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
						$sel_class = ($mode=='rank' && $val['no']==$no) ? 'dnbg ' : 'wbg ';
?>
						<tr class="wbg tc <?php echo $cate;?>_lists lists" height="30" id="cate_<?php echo $val['no'];?>" onclick="cate_sels('<?php echo $cate;?>','<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>">
							<td><input name="view[]" type="checkbox" value="yes" id="view_<?php echo $val['no'];?>" <?php echo ($val['view']=='yes')?'checked':'';?> onclick="cate_view('<?php echo $val['no']?>',this);"></td>
							<?php if($is_job){ ?><td><input name="etc_0[]" type="checkbox" value="yes" id="adult_<?php echo $val['no'];?>" <?php echo ($val['etc_0'])?'checked':'';?> onclick="adult_view('<?php echo $val['no']?>',this);" title="성인분류로 체크하시면 카테고리 사용시 성인인증을 요구합니다."></td><?php } ?>
							<td class="plr5">
								<input type='text' name="name[]" class="txt w100 <?php echo $cate;?>_list" style="ime-mode:active;" value="<?php echo $name;?>" id="name_<?php echo $val['no'];?>" no="<?php echo $val['no'];?>" cate="<?php echo $cate;?>"/>
							</td>
							<td>
								<a class='btn'><h1 class="btn19" style="width:21px" onclick="cate_update('<?php echo $cate;?>','<?php echo $val['no'];?>');">수정</h1></a>
								<a class='btn'><h1 class="btn19" style="width:21px" onclick="cate_delete('<?php echo $cate;?>','<?php echo $val['no'];?>');">삭제</h1></a>
							</td>
						</tr>
<?php
						}	// foreach end.

					} else {
						echo "0004";	// 분류 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
						exit;
					}

				} else {	 // 단순 카테고리

					$get_LastRank = $category_control->get_MaxRank($type);	// rank 최대값 구함

					$vals['code'] = $utility->get_unique_code();
					$vals['name'] = $_POST['name'];

					$vals['rank'] = $get_LastRank + 1;
					$vals['wdate'] = $now_date;

					$result = $category_control->insert_category($vals);
	
					if($result){
						echo "0000";	// 분류가 입력되었습니다.
						exit;
					} else {
						echo "0004";	// 분류 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
						exit;
					}

				}
				
			break;

			## 카테고리 수정
			case 'update':
				
				$vals['name'] = $_POST['name'];
				$vals['view'] = ($_POST['view']=='true') ? 'yes' : 'no';
				$vals['etc_0'] = ($_POST['etc_0']=='true') ? 1 : 0;

				$result = $category_control->update_category($vals, $no);

				echo $result;

			break;

			## 카테고리 출력 설정
			case 'view':

				$vals['view'] = ($_POST['view']=='true') ? 'yes' : 'no';

				$result = $category_control->update_category($vals, $no);

				echo $result;

			break;

			## 성인 분류 설정
			case 'adult_view':

				$vals['etc_0'] = ($_POST['view']=='true') ? 1 : 0;

				$result = $category_control->update_category($vals, $no);

				echo $result;

			break;

			## 카테고리 삭제
			case 'delete':

				$is_pcode = $category_control->is_pcode($no);
				if($is_pcode){
					echo "0006";	// 해당 분류에 소속된 하위 분류가 있습니다.\\n\\n분류를 삭제하시려면 소속된 하위 분류 먼저 삭제하세요.
					exit;
				}

				$result = $category_control->delete_noRank($no,$type);

				echo $result;

			break;

			## 카테고리 선택 삭제
			case 'sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){

					$result = $category_control->delete_noRank($nos[$i], $type);

				}

				echo $result;

			break;


			## 순위 조절
			case 'rank':

				$direction = $_POST['direction'];	// 방향

				$next_no = $_POST['next_no'];

					if($direction=='first' || $direction=='last'){	// 맨처음/끝으로
						
						$get_cate = $category_control->get_category($no);				// 선택 no
						$rank = $get_cate['rank'];
						$con = ($p_code) ? "and `p_code` = '".$p_code."'" : "";
						if($direction=='first'){	// 처음으로
							$result = $db->_query(" update `alice_category` set `rank` = `rank`+1 where `type` = '".$type."' ".$con." and `rank` < ".$rank." ");
							$result = $db->_query(" update `alice_category` set `rank` = 1 where `no` = '".$no."' ");
						} else if($direction=='last'){	// 끝으로
							$rank_max = $category_control->get_MaxRank($type," and `p_code` = '".$p_code."' ");
							$rank2 = $rank_max['rank'];
							$result = $db->_query(" update `alice_category` set `rank`= `rank`-1 where `type` = '".$type."' ".$con."  and `rank` > ".$rank."");
							$result = $db->_query(" update `alice_category` set `rank`= '".$rank2."' where `type` = '".$type."' and `no` = '".$no."' ");
						}

					} else {

						$result = $category_control->setRank($type,$no,$next_no);

					}

				echo $result;

			break;

			## 카테고리 일괄 적용
			case 'sel_category':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				$names = explode(',',$name);
				for($i=0;$i<$no_cnt;$i++){

					$vals['name'] = $names[$i];

					$result = $category_control->update_category($vals, $nos[$i]);

				}

				echo $result;

			break;


		}	// switch end.
?>