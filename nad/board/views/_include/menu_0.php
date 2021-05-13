<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
	<dl class="b nanum fon13 pd7">1차 메뉴설정</dl>
	<table width="100%" cellspacing="1" class="ln sep tf">
	<col width=25><col><col width=75>
	<tr align="center" class="bg b" height="25">
		<td class="fon11" title='출력유무'>V</td>
		<td class="fon11">항목</td>
		<td class="fon11">편집</td>
	</tr>

	<tbody id="menu_0_list">
	<?php 
	if($board_category) {
		foreach($board_category as $val) { 
		$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
	?>
	<tr class="wbg tc menu_0_lists lists" height="30" id="menu_<?php echo $val['no'];?>" onclick="menu_sels('menu_0','<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>" code="<?php echo $val['code'];?>">
		<td>
			<input name="view[]" type="checkbox" value="yes" id="view_<?php echo $val['no'];?>" <?php echo ($val['view']=='yes')?'checked':'';?> onclick="menu_view('<?php echo $val['no']?>',this);">
		</td>
		<td class="plr5">
			<input type='text' name="name[]" class="txt w100 menu_0_list" style="ime-mode:active;" value="<?php echo $name;?>" id="name_<?php echo $val['no'];?>" no="<?php echo $val['no'];?>" menu="menu_0"/>
		</td>
		<td>
		<a class='btn'><h1 class="btn19" style="width:21px" onclick="menu_update('menu_0','<?php echo $val['no'];?>');">수정</h1></a>
		<a class='btn'><h1 class="btn19" style="width:21px" onclick="menu_delete('menu_0','<?php echo $val['no'];?>');">삭제</h1></a>
		</td>
	</tr>
	<?php 
		}	// foreach end.
	} else { ?>
	<tr class="wbg tc">
		<td colspan='3' style="height:120px;" class="e">1차 메뉴를 생성해 주세요.</td>
	</tr>
	<?php } // if end. ?>
	</tbody>

	<form name="menu_0_Frm" method="post" id="menu_0_Frm" action="./process/menu.php">
	<input type="hidden" name="mode" value="insert"/>
	<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
	<input type="hidden" name="type" value="board_menu"/><!-- 카테고리 type -->
	<input type="hidden" name="multi_depth" value="1"/><!-- 다차원 카테고리 구분 -->
	<input type="hidden" name="menu" value="menu_0"/><!-- menu depth -->

		<tr class="bg_col tc" height="30" id="menu_0_input" style="display:none;">
			<td><input name="view" type="checkbox" value="yes" checked></td>
			<td class="plr5">
				<input type='text' name="name" class="txt w100 menu_name" style="ime-mode:active;" id="menu_0_name" hname='1차 메뉴명' required menu="menu_0">
			</td>
			<td>
				<a class='btn' onclick="menu_insert('menu_0');"><h1 class="btn19" style="width:21px">등록</h1></a>
				<a class='btn' onclick="menu_cancel('menu_0');"><h1 class="btn19" style="width:21px">취소</h1></a>
			</td>
		</tr> 

	</form>

	</table>
</dl>

<dl class="bg_col tl psr" style="margin:5px 5px 0;height:25px">
	<a class="cbtn gr2_org lnb2_org" onclick="change_rank('menu_0','up');"><h1 class="btn19 org">▲ 위 &nbsp; 로</h1></a>
	<a class="cbtn gr2_org lnb2_org" onclick="change_rank('menu_0','down');"><h1 class="btn19 org">▼ 아래로</h1></a>
	<a class="cbtn gr2_col lnb2_col" onclick="change_rank('menu_0','first');"><h1 class="btn19 col">▲ 맨처음</h1></a>
	<a class="cbtn gr2_col lnb2_col" onclick="change_rank('menu_0','last');"><h1 class="btn19 col">▼ 끝으로</h1></a>
	<dd class="prt"><a class="cbtn grf_col lnb_col" onclick="menu_input('menu_0');"><h1 class="btn19"><strong>+</strong>추가</h1></a></dd>
</dl>