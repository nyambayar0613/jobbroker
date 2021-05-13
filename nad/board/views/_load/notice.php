<?php
		/*
		* /application/nad/board/views/_load/notice.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Notice layer load process
		* @Comment :: Notice (공지사항) 등록/수정시 출력되는 layer 창
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$wr_type = $_POST['wr_type'];
		$no = $_POST['no'];

		$notice = $notice_control->get_notice($no);	// 수정시 notice 정보 추출

		if($mode=='insert'){
			$wr_id = $admin_info['uid'];	// 작성자 id
			$wr_name = $admin_info['nick'];	 // 작성자 nick
			$category = $category_control->getOption('notice',$wr_type);	// notice 에 등록된 카테고리 정보 추출
			$wr_file = "";
		} else {
			$wr_id = $notice['wr_id'];
			$wr_name = $notice['wr_name'];
			$category = $category_control->getOption('notice',$notice['wr_type']);
			$wr_file = unserialize($notice['wr_file']);
		}

		switch($mode){
			## 공지사항 등록/수정
			case 'insert':
			case 'update':
?>
				<div id="add_form" class="bocol lnb_col" style="top:3%;left:28%;display:none;">
				<form name="noticeFrm" method="post" id="noticeFrm" action="./process/notice.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="<?php echo $mode;?>"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<?php if($mode=='update'){ // 수정일때만 사용?> 
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<?php } ?>
				<input type="hidden" name="wr_id" value="<?php echo $wr_id;?>"/>
				<input type="hidden" name="wr_name" value="<?php echo $wr_name;?>"/>

					<dl class="ntlt lnb_col m0 hand" id="noticeFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">공지사항 <?php echo ($mode=='insert')?'등록':'수정';?>
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="750" class="bg_col">
					<col width=65><col>
					<tr>
						<td class="ctlt">제목</td>
						<td class="pdlnb2">
							<input type="text" class="txt" name="wr_subject" style="width:98%" value="<?php echo stripslashes($notice['wr_subject']);?>"> &nbsp;
						</td>
					</tr>
					<!-- 분류없으면 비노출 -->
					<?php if($category){?>
					<tr>
						<td class="ctlt">분류</td>
						<td class="pdlnb2">
							<select name="wr_type" id="wr_type" required hname='분류'>
							<option value="">분류</option>
							<?php echo $category;?>
							</select>
						</td>
					</tr>
					<?php } ?>
					<!-- 공지사항 /faq 에 비노출 -->
					<tr>
						<td class="ctlt">작성자</td>
						<td class="pdlnb2">
							<input type="text" class="txt" size="20" name="wr_name" value="<?php echo $wr_name;?>"> &nbsp;
						</td>
					</tr>

					<tr>
						<td class="ctlt">내용</td>
						<td class="pdlnb2">
							<?php echo $utility->make_cheditor('wr_content', $notice['wr_content']);	// 에디터 생성?>
						</td>
					</tr>
					<tr>
						<td class="ctlt">파일첨부</td>
						<td class="pdlnb2">
						<?php for($i=0;$i<5;$i++){?>
							<input type='file' name='wr_file[<?php echo $i;?>]' class="txt w50 mdbt3">
							<?php if($mode=='update'){?> <label><!-- <input type='checkbox' name="wr_file_del[<?php echo $i;?>]" value="<?php echo $i;?>"/> --> <?php echo $wr_file[$i];?> <!-- 파일삭제 --></label> <?php } ?>
						<?php } ?>
						</td>
					</tr>
					</table>

					<dl class="pbtn">  
						<input type="image" src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>
<?php
			break;
		}
?>