<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
  <dl class="b nanum fon13 pd7">1차 <?php echo ($type=='job_college')?'대학지역':$type_arr[$type]['sub_name'];?> 분류</dl>
  <table width="100%" cellspacing="1" class="ln sep tf">
    <col width=25><?php if($is_job){ ?><col width=30><?php } ?><col><col width=75>
    <tr align="center" class="bg b" height="25">
      <td class="fon11" title='출력유무'>V</td>
      <?php if($is_job){ ?><td class="fon11" title="성인분류로 체크하시면 카테고리 사용시 성인인증을 요구합니다.">성인</td><?php } ?>
      <td class="fon11">항목</td>
      <td class="fon11">편집</td>
    </tr>

	<tbody id="cate_0_list">
	<?php 
		if($category_list) {
			foreach($category_list as $val) { 
			$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
	?>
	<tr class="wbg tc cate_0_lists lists" height="30" id="cate_<?php echo $val['no'];?>" onclick="cate_sels('cate_0','<?php echo $val['no'];?>','<?php echo $val['code'];?>');" data_no="<?php echo $val['no'];?>">
		<td><input name="view[]" type="checkbox" value="yes" id="view_<?php echo $val['no'];?>" <?php echo ($val['view']=='yes')?'checked':'';?> onclick="cate_view('<?php echo $val['no']?>',this);"></td>
		<?php if($is_job){ ?><td><input name="etc_0[]" type="checkbox" value="<?php echo $val['etc_0'];?>" id="adult_<?php echo $val['no'];?>" <?php echo ($val['etc_0'])?'checked':'';?> onclick="adult_view('<?php echo $val['no']?>',this);" title="성인분류로 체크하시면 해당 카테고리 사용시 성인인증을 요구합니다."></td><!-- 성인분류 --><?php } ?>
		<td class="plr5">
			<input type='text' name="name[]" class="txt w100 cate_0_list" style="ime-mode:active;" value="<?php echo $name;?>" id="name_<?php echo $val['no'];?>" no="<?php echo $val['no'];?>" cate="cate_0"/>
		</td>
		<td>
			<a class='btn'><h1 class="btn19" style="width:21px" onclick="cate_update('cate_0','<?php echo $val['no'];?>');">수정</h1></a>
			<a class='btn'><h1 class="btn19" style="width:21px" onclick="cate_delete('cate_0','<?php echo $val['no'];?>');">삭제</h1></a>
		</td>
	</tr>
	<?php 
			}	// foreach end.
		} else { ?>
	<tr class="wbg tc">
		<td colspan='<?php echo ($is_job)?'4':'3';?>' style="height:120px;">1차 <?php echo $type_arr[$type]['sub_name'];?>을(를) 생성해 주세요.</td>
	</tr>
	<?php } // if end. ?>
	</tbody>

	<form name="cate_0_Frm" method="post" id="cate_0_Frm" action="./process/category.php">
	<input type="hidden" name="mode" value="insert"/>
	<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
	<input type="hidden" name="type" value="<?php echo $type;?>"/><!-- 카테고리 type -->
	<input type="hidden" name="multi_depth" value="1"/><!-- 다차원 카테고리 구분 -->
	<input type="hidden" name="cate" value="cate_0"/><!-- cate depth -->

	<tr class="bg_col tc" height="30" id="cate_0_input" style="display:none;">
		<td><input name="view" type="checkbox" value="yes" checked></td>
		<?php if($is_job){ ?><td><input name="etc_0" type="checkbox" value="1" id="cate_0_adult" title="성인분류로 체크하시면 카테고리 사용시 성인인증을 요구합니다."></td><?php } ?>
		<td class="plr5">
			<input type='text' name="name" class="txt w100 cate_name" style="ime-mode:active;" id="cate_0_name" hname='1차 분류명' required cate="cate_0">
		</td>
		<td>
			<a class='btn' onclick="cate_insert('cate_0');"><h1 class="btn19" style="width:21px">등록</h1></a>
			<a class='btn' onclick="cate_cancel('cate_0');"><h1 class="btn19" style="width:21px">취소</h1></a>
		</td>
	</tr> 

	</form>

  </table>
</dl>
  
<dl class="bg_col tl psr" style="margin:5px 5px 0;height:25px">
	<a class="cbtn gr2_org lnb2_org" onclick="change_ranks('cate_0','up');"><h1 class="btn19 org">▲ 위 &nbsp; 로</h1></a>
	<a class="cbtn gr2_org lnb2_org" onclick="change_ranks('cate_0','down');"><h1 class="btn19 org">▼ 아래로</h1></a>
	<a class="cbtn gr2_col lnb2_col" onclick="change_ranks('cate_0','first');"><h1 class="btn19 col">▲ 맨처음</h1></a>
	<a class="cbtn gr2_col lnb2_col" onclick="change_ranks('cate_0','last');"><h1 class="btn19 col">▼ 끝으로</h1></a>
	<dd class="prt">
		<a class="cbtn grf_col lnb_col" onclick="cate_input('cate_0');"><h1 class="btn19"><strong>+</strong>추가</h1></a>
	</dd>
</dl>
