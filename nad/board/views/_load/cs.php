<?php
		/*
		* /application/nad/board/views/_load/cs.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: CS layer load
		* @Comment :: CS 답변시 출력되는 layer 창
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];
		$wr_type = $_POST['wr_type'];

		$get_cs = $cs_control->get_cs($no);

		if($mode=='faq_insert'){
			$wr_id = $admin_info['uid'];	// 작성자 id
			$wr_name = $admin_info['nick'];	 // 작성자 nick
			$category = $category_control->getOption($wr_type,$_POST['wr_cate']);	// cs 에 등록된 카테고리 정보 추출
		} else if($mode=='faq_update'){
			$wr_id = $get_cs['wr_id'];
			$wr_name = $get_cs['wr_name'];
			$category = $category_control->getOption($wr_type,$get_cs['wr_cate']);	// cs 에 등록된 카테고리 정보 추출
		} else {
			$wr_id = $admin_info['uid'];
			$wr_name = $admin_info['nick'];	
		}

		switch($mode){
			
			## FAQ 등록/수정
			case 'faq_insert':
			case 'faq_update':
?>
				<div id="add_form" class="bocol lnb_col" style="top:3%;left:28%;display:none;">
				<form name="faqFrm" method="post" id="faqFrm" action="./process/cs.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="<?php echo $mode;?>"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<?php if($mode=='faq_update'){ // 수정일때만 사용?> 
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<?php } ?>
				<input type="hidden" name="wr_id" value="<?php echo $wr_id;?>"/>
				<input type="hidden" name="wr_type" value="2"/><!-- faq :: 2 -->

					<dl class="ntlt lnb_col m0 hand" id="noticeFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">FAQ <?php echo ($mode=='faq_insert')?'등록':'수정';?>
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="750" class="bg_col">
					<col width=65><col>
					<tr>
						<td class="ctlt">제목</td>
						<td class="pdlnb2">
							<input type="text" class="txt"  name="wr_subject" style="width:98%" value="<?php echo stripslashes($get_cs['wr_subject']);?>" required hname='제목'> &nbsp;
						</td>
					</tr>
					<!-- 분류없으면 비노출 -->
					<tr>
						<td class="ctlt">분류</td>
						<td class="pdlnb2">
							<select name="wr_cate" id="wr_cate" required hname='분류'>
							<option value="">분류</option>
							<?php echo $category;?>
							</select>
						</td>
					</tr>

					<!-- 공지사항 /faq 에 비노출 -->
					<tr>
						<td class="ctlt">작성자</td>
						<td class="pdlnb2">
							<input type="text" class="txt" size="20" name="wr_name" value="<?php echo $wr_name;?>" required hname='작성자'> &nbsp;
						</td>
					</tr>

					<tr>
						<td class="ctlt">내용</td>
						<td class="pdlnb2">
							<?php echo $utility->make_cheditor('wr_content', $get_cs['wr_content']);	// 에디터 생성?>
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

			## 1:1 문의 관리 답변
			case 'cs_reply':
			case 'advert_reply':
			case 'concert_reply':
				if($wr_type=='on2on')
					$wr_types = "고객문의";
				else if($wr_type=='advert')
					$wr_types = "광고문의";
				else if($wr_type=='concert')
					$wr_types = "제휴문의";
?>
				<div id="add_form" class="bocol lnb_col" style="top:2%;left:28%;display:none;">
				<form name="csFrm" method="post" id="csFrm" action="./process/cs.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="<?php echo $mode;?>"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="wr_aid" value="<?php echo $wr_id;?>"/>

					<dl class="ntlt lnb_col m0 hand" id="csFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t"><?php echo $wr_types;?> 글보기
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<table width="750" class="bg_col tf">
					<col width=80><col><col width=80><col>
					<tr>
						<td class="ctlt">제목</td>
						<td class="pdlnb2" colspan="3"><?php echo stripslashes($get_cs['wr_subject']);?></td>
					</tr>
					<tr>
						<?php if($wr_type=='advert'){ ?>
						<td class="ctlt">담당자</td>
						<?php } else { ?>
						<td class="ctlt">작성자</td>
						<?php } ?>
						<td class="pdlnb2"><?php echo stripslashes($get_cs['wr_name']);?></td>
						<td class="ctlt">작성일</td>
						<td class="pdlnb2 num3"><?php echo $get_cs['wr_date'];?></td>
					</tr>
					<?php if($wr_type=='advert'){ ?>
					<tr>
						<td class="ctlt">회사명</td>
						<td class="pdlnb2" colspan="3"><?php echo stripslashes($get_cs['wr_biz_name']);?></td>
					</tr>
					<tr>
						<td class="ctlt">휴대폰</td>
						<td class="pdlnb2"><?php echo $get_cs['wr_hphone'];?></td>
						<td class="ctlt">전화번호</td>
						<td class="pdlnb2"><?php echo $get_cs['wr_phone'];?></td>
					</tr>
					<tr>
						<td class="ctlt">주요사업</td>
						<td class="pdlnb2"><?php echo stripslashes($get_cs['wr_biz']);?></td>
						<td class="ctlt">사업제휴부분</td>
						<td class="pdlnb2"><?php echo stripslashes($get_cs['wr_biz_type']);?></td>
					</tr>
					<tr>
						<td class="ctlt">이메일</td>
						<td class="pdlnb2"><a onClick="pop_email('<?php echo $no;?>');"><?php echo stripslashes($get_cs['wr_email']);?></a></td>
						<td class="ctlt">홈페이지</td>
						<td class="pdlnb2"><a href="<?php echo $get_cs['wr_site'];?>" target="_blank"><?php echo $get_cs['wr_site'];?></a></td>
					</tr>
					<?php } ?>
					<tr>
						<td class="ctlt">내용</td>
						<td class="pdlnb2 h20" colspan="3"><?php echo stripslashes($get_cs['wr_content']);?></td>
					</tr>
					</table>

					<dl class="ntlt lnb_col"><img src="../../images/comn/bul_10.png" class="t"><?php echo $wr_types;?> 답변쓰기</dl>
					<table width="750" class="bg_col">
					<col width=65><col>
					<tr>
						<td class="ctlt">작성자</td>
						<td class="pdlnb2"><input type="text" class="txt" size="20" name="wr_aname" value="<?php echo $wr_name;?>"></td>
					</tr>
					<tr>
					<td class="ctlt">내용</td>
					<td class="pdlnb2">
						<?php echo $utility->make_cheditor('wr_acontent', $get_cs['wr_acontent']);	// 에디터 생성?>
					</td>
					</tr>
					</table>

					<dl class="pbtn">  
						<input type="image" src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

				</form>
				</div>
<?
			break;
			
		}

?>