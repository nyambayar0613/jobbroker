<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
  <dl class="b nanum fon13 pd7">2-р хэсэг <?php echo $type_arr[$type]['sub_name'];?> төрөл</dl>
  <table width="100%" cellspacing="1" class="ln sep tf">
    <col width=25><col><col width=75>
    <tr align="center" class="bg b" height="25">
      <td class="fon11">Сонгох</td>
      <td class="fon11">Утга</td>
    </tr>

	<tbody id="cate_1_list">
	<tr class="wbg tc" style="height:150px;">
		<td colspan='2'>1-р хэсгийг <?php echo $type_arr[$type]['sub_name'];?>эхлээд сонгоно уу.</td>
	</tr>
	</tbody>

	<form name="cate_1_Frm" method="post" id="cate_1_Frm" action="./process/category.php">
	<input type="hidden" name="mode" value="insert"/>
	<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
	<input type="hidden" name="type" value="<?php echo $type;?>"/><!-- 카테고리 type -->
	<input type="hidden" name="multi_depth" value="1"/><!-- 다차원 카테고리 구분 -->
	<input type="hidden" name="p_code" id="cate_1_pcode"/><!-- parent code -->
	<input type="hidden" name="cate" value="cate_1"/><!-- cate depth -->

	<tr class="bg_col tc" height="30" id="cate_1_input" class="cate_1" style="display:none;">
		<td><input name="view" type="checkbox" value="yes" checked></td>
		<td class="plr5">
			<input type='text' name="name" class="txt w100 cate_name" style="ime-mode:active;" id="cate_1_name" hname='2-р хэсгийн нэр' required cate="cate_1">
		</td>
	</tr> 

	</form>

  </table>
</dl>