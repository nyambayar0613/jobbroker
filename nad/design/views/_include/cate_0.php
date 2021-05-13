<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
  <table width="100%" cellspacing="1" class="ln sep tf">
    <col width=35><col>
    <tr align="center" class="bg b" height="25">
      <td class="fon11" title='출력선택'>선택</td>
      <td class="fon11">항목</td>
    </tr>

	<tbody id="cate_0_list">
	<?php 
		if($category_list) {
			foreach($category_list as $val) { 
			$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
			$checked = (@in_array($val['code'],$professional_indi)) ? 'checked' : '';
	?>
	<tr class="wbg tc cate_0_lists lists hand" height="30" id="cate_<?php echo $val['no'];?>" onclick="cate_sels('cate_0','<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>">
		<td><input name="professional_indi[]" type="checkbox" value="<?php echo $val['code'];?>" id="professional_<?php echo $val['no'];?>" onclick="professional_sel('<?php echo $val['no']?>',this,'cate_0');" class="cate_0" <?php echo $checked;?>></td>
		<td class="pl5 fl pt5">
			<span id="professional_txt_<?php echo $val['no'];?>" code="<?php echo $val['code'];?>"><?php echo $name;?></span>
		</td>
	</tr>
	<?php 
			}	// foreach end.
		} else { ?>
	<tr class="wbg tc">
		<td colspan='2' style="height:120px;">직종을 생성해 주세요.</td>
	</tr>
	<?php } // if end. ?>
	</tbody>

  </table>
</dl>