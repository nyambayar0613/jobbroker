<?php
		/*
		* /application/nad/board/views/_load/menu.php
		* @author Harimao
		* @since 2013/05/29
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Board menu listing
		* @Comment :: 게시판 메뉴 리스트
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

		$sel_cate = 'menu_' . $next_depth;

		switch($mode){

			## 하위 분류
			case 'next_menu':

				$category = $category_control->category_pcodeList($type,$code);

				if($category){
					foreach($category as $val) { 
					$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
?>
					<tr class="wbg tc <?php echo $sel_cate;?>_lists lists" height="30" id="menu_<?php echo $val['no'];?>" onclick="menu_sels('<?php echo $sel_cate;?>','<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>" code="<?php echo $val['code'];?>">
						<td><input name="view[]" type="checkbox" value="yes" id="view_<?php echo $val['no'];?>" <?php echo ($val['view']=='yes')?'checked':'';?> onclick="menu_view('<?php echo $val['no']?>',this);"></td>
						<td class="plr5">
							<input type='text' name="name[]" class="txt w100 <?php echo $sel_cate;?>_list" style="ime-mode:active;" value="<?php echo $name;?>" id="name_<?php echo $val['no'];?>" no="<?php echo $val['no'];?>" menu="<?php echo $sel_cate;?>"/>
						</td>
						<td>
							<a class='btn'><h1 class="btn19" style="width:21px" onclick="menu_update('<?php echo $sel_cate;?>','<?php echo $val['no'];?>');">수정</h1></a>
							<a class='btn'><h1 class="btn19" style="width:21px" onclick="menu_delete('<?php echo $sel_cate;?>','<?php echo $val['no'];?>');">삭제</h1></a>
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

				if($result){
					if($p_code)
						$category = $category_control->category_pcodeList($type,$p_code);// 2,3차 카테고리 리스트
					else
						$category = $category_control->category_codeList($type);	// 1차 카테고리 리스트

					foreach($category as $val) { 
					$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
					$sel_class = ($mode=='rank' && $val['no']==$no) ? 'dnbg ' : 'wbg ';
?>
					<tr class="wbg tc <?php echo $menu;?>_lists lists" height="30" id="menu_<?php echo $val['no'];?>" onclick="menu_sels('<?php echo $menu;?>','<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>">
						<td><input name="view[]" type="checkbox" value="yes" id="view_<?php echo $val['no'];?>" <?php echo ($val['view']=='yes')?'checked':'';?> onclick="menu_view('<?php echo $val['no']?>',this);"></td>
						<td class="plr5">
							<input type='text' name="name[]" class="txt w100 <?php echo $menu;?>_list" style="ime-mode:active;" value="<?php echo $name;?>" id="name_<?php echo $val['no'];?>" no="<?php echo $val['no'];?>" menu="<?php echo $menu;?>"/>
						</td>
						<td>
							<a class='btn'><h1 class="btn19" style="width:21px" onclick="menu_update('<?php echo $menu;?>','<?php echo $val['no'];?>');">수정</h1></a>
							<a class='btn'><h1 class="btn19" style="width:21px" onclick="menu_delete('<?php echo $menu;?>','<?php echo $val['no'];?>');">삭제</h1></a>
						</td>
					</tr>
<?php
					}	// foreach end.
				} else {
					echo "0017";	// 순위 조절중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
					exit;
				}
			break;

			## 선택 그룹 게시판 목록
			case 'next_board':
			
				$p_codes = $category_control->category_pcodeList("board_menu", $code, " `rank` asc ");

				$codes = array();
				foreach($p_codes as $vals){
					array_push($codes, "'".$vals['code']."'");
				}

				if($codes) {

					$board_list = $board_config_control->__BoardList("",""," where `code` in (".@implode($codes,", ").") ", " `b_rank` asc " );

					if($board_list['result']){
						foreach($board_list['result'] as $board) { 
							$bo_table = $board['bo_table'];
							$bo_no = $board['no'];
							$bo_print = $print_board[$bo_table];
?>
						<!--
						<input type="hidden" name="board[<?php echo $bo_table;?>]" value="<?php echo $bo_table;?>"/>
						<input type="hidden" name="board[<?php echo $bo_table;?>][no]" value="<?php echo $bo_no;?>"/>
						-->
						<tr class='board_list' no="<?php echo $board['no'];?>">
							<td class="none num3" >
								<a class="none" onclick="change_rank('up',this);">▲</a>
								<a class="none" onclick="change_rank('down',this);">▼</a>
							</td>
							<td class="tl"><?php echo stripslashes($board['bo_subject']);?></td>
							<td><input type="checkbox" name="board[<?php echo $bo_table;?>][view]" class="chk" value="1" <?php echo ($bo_print['view'])?'checked':'';?>/></td>
							<td><input name="board[<?php echo $bo_table;?>][subject_len]" type="text" class="tnum tc b" size="3" value="<?php echo ($bo_print['subject_len'])?$bo_print['subject_len']:"0";?>"></td>
							<td><input name="board[<?php echo $bo_table;?>][print_cnt]" type="text" class="tnum tc b" size="3" value="<?php echo ($bo_print['print_cnt'])?$bo_print['print_cnt']:"0";?>"></td>
							<td>
								<input name="board[<?php echo $bo_table;?>][img_width]" type="text" class="tnum tc b" size="3" value="<?php echo ($bo_print['img_width'])?$bo_print['img_width']:"0";?>"> x
								<input name="board[<?php echo $bo_table;?>][img_height]" type="text" class="tnum tc b" size="3" value="<?php echo ($bo_print['img_height'])?$bo_print['img_height']:"0";?>">
							</td>
							<td class="e">
								<select name="board[<?php echo $bo_table;?>][print_type]">
									<option value="text" <?php echo ($bo_print['print_type']=='text')?'selected':'';?>>텍스트형</option>
									<option value="image" <?php echo ($bo_print['print_type']=='image')?'selected':'';?>>이미지형</option>
									<option value="webzine" <?php echo ($bo_print['print_type']=='webzine')?'selected':'';?>>웹진형</option>
								</select>
							</td>
						</tr>
<?php 
						} // foreach end. 
					} else {
?>
					<tr>
						<td colspan='8' height='30' id="board_none" class="e"><?php echo $board_config_control->_errors('0013');?></td>
					</tr>
<?php
					}	// $board_list['result'] if end.

				} else {
?>
					<tr>
						<td colspan='8' height='30' id="board_none" class="e"><?php echo $board_config_control->_errors('0013');?></td>
					</tr>
<?php
				}	// codes if end.

			break;
		}
?>