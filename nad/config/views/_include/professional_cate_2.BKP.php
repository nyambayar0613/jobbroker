<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
  <dl class="b nanum fon13 pd7">3차 <?php echo $type_arr[$type]['sub_name'];?> 분류</dl>
  <table width="100%" cellspacing="1" class="ln sep tf">
    <col width=25><col><col width=75>
    <tr align="center" class="bg b" height="25">
      <td class="fon11">선택</td>
      <td class="fon11">항목</td>
    </tr>

	<tbody id="cate_2_list">
	<tr class="wbg tc" style="height:150px;">
		<td colspan='2'>2차 <?php echo $type_arr[$type]['sub_name'];?>을(를) 먼저 선택해 주세요.</td>
	</tr>
	</tbody>

	<form name="cate_2_Frm" method="post" id="cate_2_Frm" action="./process/category.php">
	<input type="hidden" name="mode" value="insert"/>
	<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
	<input type="hidden" name="type" value="<?php echo $type;?>"/><!-- 카테고리 type -->
	<input type="hidden" name="multi_depth" value="1"/><!-- 다차원 카테고리 구분 -->
	<input type="hidden" name="p_code" id="cate_2_pcode"/><!-- parent code -->
	<input type="hidden" name="cate" value="cate_2"/><!-- cate depth -->

	<tr class="bg_col tc" height="30" id="cate_2_input" class="cate_2" style="display:none;">
		<td><input name="view" type="checkbox" value="yes" checked></td>
		<td class="plr5">
			<input type='text' name="name" class="txt w100 cate_name" style="ime-mode:active;" id="cate_2_name" hname='3차 분류명' required cate="cate_2">
		</td>
	</tr> 

	</form>

  </table>
</dl>