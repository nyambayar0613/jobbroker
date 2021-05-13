<?php
		/*
		* /application/nad/design/views/_load/category.php
		* @author Harimao
		* @since 2013/08/13
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Category Info
		* @Comment :: 직종 카테고리 정보 추출
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$type = $_POST['type'];
		$next_depth = $_POST['next_depth'];

		$cate = $_POST['cate'];
		$no = $_POST['no'];
		$code = $_POST['code'];

		$sel_cate = 'cate_' . $next_depth;

		switch($mode){

			## 하위 분류
			case 'next_cate':
				
				$category = $category_control->category_pcodeList($type,$code);
				$professional_indi = explode(',',$design['professional_indi']);	 // 전문인재정보

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
					}	// foreach end.
				}	// if end.
			break;

			## 선택 항목 지정
			case 'cate_sel':
			
				$result = array();

				$code_cnt = count($code);
				for($i=0;$i<$code_cnt;$i++){
					$cate_sel = $category_control->get_categoryCodeName($code[$i]);
					$result[] = $cate_sel;
				}

				echo @implode($result,', ');

			break;
		}

?>