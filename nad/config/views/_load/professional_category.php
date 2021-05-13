<?php
		/*
		* /application/nad/config/views/_load/professional_category.php
		* @author Harimao
		* @since 2014/03/05
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Professional category listing
		* @Comment :: 전문인재정보 분류 리스트
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$type = $_POST['type'];
		$no = $_POST['no'];
		$code = $_POST['code'];
		$p_code = $_POST['p_code'];
		$next_depth = $_POST['next_depth'];
		$is_job = ($type=='job_type') ? true : false;
		$is_pay = ($type=='alba_pay') ? true : false;

		$sel_cate = 'cate_' . $next_depth;
		$pay_level = $category_control->pay_level;


		switch($mode){

			## 하위 분류
			case 'next_cate':

				$category = $category_control->category_pcodeList($type,$code);
				$types = $_POST['types'];
				$professional_indi = ($types=='indi_profesional') ? explode(',',$design['professional_indi']) : explode(',',$design['professional_alba']);

				if($category){
					foreach($category as $val) { 
					$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
					$checked = (@in_array($val['code'],$professional_indi)) ? 'checked' : '';
?>
					<tr class="wbg tc <?php echo $sel_cate;?>_lists lists hand" height="30" id="cate_<?php echo $val['no'];?>" onclick="cate_sels('<?php echo $sel_cate;?>','<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>">
						<td><input name="professional_indi[]" type="checkbox" value="<?php echo $val['code'];?>" id="professional_<?php echo $val['no'];?>" onclick="professional_sel('<?php echo $val['no']?>',this,'<?php echo $sel_cate;?>');" class="<?php echo $sel_cate;?>" <?php echo $checked;?>></td>
						<td class="pl5 fl pt5">
							<span id="professional_txt_<?php echo $val['no'];?>" code="<?php echo $val['code'];?>"><?php echo $name;?></span>
						</td>
					</tr>
<?php
					}
				} else {
					echo '0001';
					exit;
				}

			break;

			## 순위 리스트
			case 'rank':

				$direction = $_POST['direction'];	// 방향

				$next_no = $_POST['next_no'];

				if($direction=='first' || $direction=='last'){	// 맨처음/끝으로
					
					$get_cate = $category_control->get_category($no);				// 선택 no
					$rank = $get_cate['rank'];
					$con = ($p_code) ? "and `p_code` = '".$p_code."'" : "and `p_code` = ''";
					if($direction=='first'){	// 처음으로
						$result = $db->_query(" update `alice_category` set `rank` = `rank`+1 where `type` = '".$type."' ".$con." and `rank` < ".$rank." ");
						$result = $db->_query(" update `alice_category` set `rank` = 1 where `no` = '".$no."' ");
					} else if($direction=='last'){	// 끝으로
						$rank_max = $category_control->get_MaxRank($type, $con);
						$result = $db->_query(" update `alice_category` set `rank`= `rank`-1 where `type` = '".$type."' ".$con."  and `rank` > ".$rank."");
						$result = $db->_query(" update `alice_category` set `rank`= '".$rank_max."' where `type` = '".$type."' and `no` = '".$no."' ");
					}

				} else {

					$result = $category_control->setRank($type,$no,$next_no);

				}

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
						<?php if($is_pay){ ?>
							<td>
								<select name="etc_0" id="etc_0_<?php echo $val['no'];?>">
								<option value="">조건</option>
								<?php foreach($pay_level as $pay_level_key => $pay_level_val){?>
								<option value="<?php echo $pay_level_key;?>" <?php echo ($pay_level_key==$val['etc_0'])?'selected':'';?>><?php echo $pay_level_val;?></option>
								<?php } ?>
								</select>
							</td>
						<?php } ?>
						<td>
							<a class='btn'><h1 class="btn19" style="width:21px" onclick="cate_update('<?php echo $cate;?>','<?php echo $val['no'];?>');">수정</h1></a>
							<?php if( stristr($val['code'],'all') === false ){ // 전체가 아닐때만 삭제가능 ?>
							<a class='btn'><h1 class="btn19" style="width:21px" onclick="cate_delete('<?php echo $cate;?>','<?php echo $val['no'];?>');">삭제</h1></a>
							<?php } ?>
						</td>
					</tr>
<?php
					}	// foreach end.
				} else {
					echo "0017";	// 순위 조절중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
					exit;
				}
			break;
		}
?>