<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="wbg" style="padding:0 5px 5px;margin:3px"> 
	<dl class="b nanum fon13 pd7">2차 메뉴설정</dl>
	<table width="100%" cellspacing="1" class="ln sep tf">
	<col width=25><col><col width=75>
	<tr align="center" class="bg b" height="25">
		<td class="fon11" title='출력유무'>V</td>
		<td class="fon11">항목</td>
		<td class="fon11">편집</td>
	</tr>

	<tbody id="menu_1_list">
	<tr class="wbg tc">
		<td colspan='3' style="height:120px;" class="e">1차 메뉴를 먼저 선택해 주세요.</td>
	</tr>
	</tbody>

	<form name="menu_1_Frm" method="post" id="menu_1_Frm" action="./process/menu.php">
	<input type="hidden" name="mode" value="insert"/>
	<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
	<input type="hidden" name="type" value="board_menu"/><!-- 카테고리 type -->
	<input type="hidden" name="multi_depth" value="1"/><!-- 다차원 카테고리 구분 -->
	<input type="hidden" name="p_code" id="menu_1_pcode"/><!-- parent code -->
	<input type="hidden" name="menu" value="menu_1"/><!-- menu depth -->

		<tr class="bg_col tc" height="30" id="menu_1_input" style="display:none;">
			<td><input name="view" type="checkbox" value="yes" checked></td>
			<td class="plr5"><input type='text' name="name" class="txt w100" style="ime-mode:active;" id="menu_1_name" hname='1차 메뉴명' required menu="menu_1"></td>
			<td>
				<a class='btn' onclick="menu_insert('menu_1');"><h1 class="btn19" style="width:21px">등록</h1></a>
				<a class='btn' onclick="menu_cancel('menu_1');"><h1 class="btn19" style="width:21px">취소</h1></a>
			</td>
		</tr> 

	</form>

	</table>
</dl>

<dl class="bg_col tl psr menu_1" style="margin:5px 5px 0;height:25px;display:none;">
	<a class="cbtn gr2_org lnb2_org" onclick="change_rank('menu_1','up');"><h1 class="btn19 org">▲ 위 &nbsp; 로</h1></a>
	<a class="cbtn gr2_org lnb2_org" onclick="change_rank('menu_1','down');"><h1 class="btn19 org">▼ 아래로</h1></a>
	<a class="cbtn gr2_col lnb2_col" onclick="change_rank('menu_1','first');"><h1 class="btn19 col">▲ 맨처음</h1></a>
	<a class="cbtn gr2_col lnb2_col" onclick="change_rank('menu_1','last');"><h1 class="btn19 col">▼ 끝으로</h1></a>
	<dd class="prt" id='menu_1_inputBtn'>
		<a class="cbtn grf_col lnb_col" onclick="menu_input('menu_1');"><h1 class="btn19"><strong>+</strong>추가</h1></a>
	</dd>
</dl>