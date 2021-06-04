<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
  <dl class="b nanum fon13 pd7">1-р хэсэг <?php echo ($type=='job_college')?'Их сургуулийн байршил':$type_arr[$type]['sub_name'];?> төрөл</dl>
  <table width="100%" cellspacing="1" class="ln sep tf">
    <col width=25><col><col width=75>
    <tr align="center" class="bg b" height="25">
      <td class="fon11">Сонгох</td>
      <td class="fon11">Утга</td>
    </tr>

	<tbody id="cate_0_list">
	<?php 
		if($category_list) {
			foreach($category_list as $val) { 
			$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
			$checked = (@in_array($val['code'],$professional_indi)) ? 'checked' : '';
	?>
	<tr class="wbg tc cate_0_lists lists hand" height="30" id="cate_<?php echo $val['no'];?>" onclick="cate_sels('cate_0','<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>">
		<!-- <td><input name="professional_indi[]" type="checkbox" value="yes" id="view_<?php echo $val['no'];?>" <?php echo ($val['view']=='yes')?'checked':'';?> onclick="cate_view('<?php echo $val['no']?>',this);"></td> -->
		<td><input name="professional_indi[]" type="checkbox" value="<?php echo $val['code'];?>" id="professional_<?php echo $val['no'];?>" onclick="professional_sel('<?php echo $val['no']?>',this,'cate_0');" class="cate_0" <?php echo $checked;?>></td>
		<td class="plr5" style="text-align:left;cursor:pointer;">
			<!-- <input type='text' name="name[]" class="txt w100 cate_0_list" style="ime-mode:active;" value="<?php echo $name;?>" id="name_<?php echo $val['no'];?>" no="<?php echo $val['no'];?>" cate="cate_0"/> -->
			<?php echo $name;?>
		</td>
	</tr>
	<?php 
			}	// foreach end.
		} else { ?>
	<tr class="wbg tc">
		<td colspan='2' style="height:120px;">1-р хэсэг <?php echo $type_arr[$type]['sub_name'];?>[Нийтлэг ангилал] - [Мэргэжлийн төрөл] ангилалд үүсгэнэ үү.</td>
	</tr>
	<?php } // if end. ?>
	</tbody>

  </table>
</dl>

