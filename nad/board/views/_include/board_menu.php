<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
	<dl class="b nanum fon13 pd7">게시판 소속 상위 메뉴설정</dl>
	<table width="100%" cellspacing="1" class="ln sep tf">
	<col width=25><col><col width=75>
	<tr align="center" class="bg b" height="25">
		<td class="fon11" title='출력유무'>V</td>
		<td class="fon11">항목</td>
		<td class="fon11">편집</td>
	</tr>

	<tbody>
	<?php 
	if($board_category) {
		foreach($board_category as $val) { 
		$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
	?>
	<tr class="wbg tc menu_0_lists lists" height="30" id="menu_<?php echo $val['no'];?>" onclick="menu_sels('<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>" code="<?php echo $val['code'];?>">
		<td>
			<input name="view[]" type="checkbox" value="yes" id="view_<?php echo $val['no'];?>" <?php echo ($val['view']=='yes')?'checked':'';?> onclick="menu_view('<?php echo $val['no']?>',this);">
		</td>
		<td class="plr5">
			<input type='text' name="name[]" class="txt w100" style="ime-mode:active;" value="<?php echo $name;?>" id="name_<?php echo $val['no'];?>" no="<?php echo $val['no'];?>"/>
		</td>
		<td>
			<a class='btn'><h1 class="btn19" style="width:21px" onclick="menu_update('<?php echo $val['no'];?>');">수정</h1></a>
			<a class='btn'><h1 class="btn19" style="width:21px" onclick="menu_delete('<?php echo $val['no'];?>');">삭제</h1></a>
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

	</table>
</dl>