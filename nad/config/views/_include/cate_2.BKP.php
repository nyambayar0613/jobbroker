<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
  <dl class="b nanum fon13 pd7">3차 <?php echo $type_arr[$type]['sub_name'];?> 분류</dl>
  <table width="100%" cellspacing="1" class="ln sep tf">
    <col width=25><?php if($is_job){ ?><col width=30><?php } ?><col><col width=75>
    <tr align="center" class="bg b" height="25">
      <td class="fon11" title='출력유무'>V</td>
      <?php if($is_job){ ?><td class="fon11" title="성인분류로 체크하시면 카테고리 사용시 성인인증을 요구합니다.">성인</td><?php } ?>
      <td class="fon11">항목</td>
      <td class="fon11">편집</td>
    </tr>

	<tbody id="cate_2_list">
	<tr class="wbg tc" style="height:150px;">
		<td colspan='<?php echo ($is_job)?'4':'3';?>'>2차 <?php echo $type_arr[$type]['sub_name'];?>을(를) 먼저 선택해 주세요.</td>
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
		<?php if($is_job){ ?><td><input name="etc_0" type="checkbox" value="1" id="cate_2_adult" title="성인분류로 체크하시면 카테고리 사용시 성인인증을 요구합니다."></td><?php } ?>
		<td class="plr5">
			<input type='text' name="name" class="txt w100 cate_name" style="ime-mode:active;" id="cate_2_name" hname='3차 분류명' required cate="cate_2">
		</td>
		<td>
			<a class='btn' onclick="cate_insert('cate_2');"><h1 class="btn19" style="width:21px">등록</h1></a>
			<a class='btn' onclick="cate_cancel('cate_2');"><h1 class="btn19" style="width:21px">취소</h1></a>
		</td>
	</tr> 

	</form>

  </table>
</dl>
<dl class="bg_col tl psr cate_2" style="margin:5px 5px 0;height:25px;display:none;">
	<a class="cbtn gr2_org lnb2_org" onclick="change_ranks('cate_2','up');"><h1 class="btn19 org">▲ 위 &nbsp; 로</h1></a>
	<a class="cbtn gr2_org lnb2_org" onclick="change_ranks('cate_2','down');"><h1 class="btn19 org">▼ 아래로</h1></a>
	<a class="cbtn gr2_col lnb2_col" onclick="change_ranks('cate_2','first');"><h1 class="btn19 col">▲ 맨처음</h1></a>
	<a class="cbtn gr2_col lnb2_col" onclick="change_ranks('cate_2','last');"><h1 class="btn19 col">▼ 끝으로</h1></a>
	<dd class="prt" id='cate_2_inputBtn'>
		<a class="cbtn grf_col lnb_col" onclick="cate_input('cate_2');"><h1 class="btn19"><strong>+</strong>추가</h1></a>
	</dd>
</dl>