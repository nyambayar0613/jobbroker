<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<script>
$(function(){
	// 쿠키로 저장된 값 불러오기
	if($.cookie('dsrch') == 'true'){
		$("input[name='alwaysDsrch']").attr('checked',true);
		$('#searchBtn').val('간편검색');
		$('#dsrch').show();
		$('#dsrchType').attr('enum','no');
	} else {
		$('#searchBtn').val('상세검색');
		$('#dsrch').hide();
		$('#dsrchType').attr('enum','yes');
	}
	// 상세/간편검색 버튼 클릭
	$('#searchBtn').click(function(){
		var dsrchType = $('#dsrchType').attr('enum');
		if(dsrchType=='yes'){
			$(this).val('간편검색');
			$('#dsrch').show();
			$('#dsrchType').attr('enum','no');
		} else {
			$(this).val('상세검색');
			$('#dsrch').hide();
			$('#dsrchType').attr('enum','yes');
			searchFrmInit();
		}

	});
	// 항상 상세검색 체크
	$("input[name='alwaysDsrch']").click(function(){
		var sel = $(this).is(':checked');
		$.cookie('dsrch',sel, { expires:1, domain:domain, path:'/', secure:0});	// 쿠키 저장
		if(sel==true){
			$('#searchBtn').val('간편검색');
			$('#dsrch').show();
			$('#dsrchType').attr('enum','no');
		} else {
			$('#searchBtn').val('상세검색');
			$('#dsrch').hide();
			$('#dsrchType').attr('enum','yes');
			searchFrmInit();
		}
	});
	// 가입일 전체 체크
	$('#start_dayAll').click(function(){
		var checked_trues = $(this).is(':checked');
		if(checked_trues==true){
			$('#start_day').val('');
			$('#end_day').val('');
		}
		//$('#start_day').attr('disabled',checked_trues);
		//$('#end_day').attr('disabled',checked_trues);
	});
	// 방문수 전체 체크
	$('#loginAll').click(function(){
		var checked_trues = $(this).is(':checked');
		if(checked_trues==true){
			$('#loginCnt_low').val('');
			$('#loginCnt_high').val('');
		}
		//$('#loginCnt_low').attr('disabled',checked_trues);
		//$('#loginCnt_high').attr('disabled',checked_trues);
	});
});
// 검색폼 초기화
var searchFrmInit = function(){
	$('#start_dayAll').attr('checked',false);
	$('#start_day, #end_day').attr('disabled',false);
	$('#start_day, #end_day').val('');
	//$("input[name='mb_type']").filter("input[value='all']").attr('checked',true);
	$('#loginAll').attr('checked',false);
	$('#loginCnt_low, #loginCnt_high').attr('disabled',false);
	$('#loginCnt_low, #loginCnt_high').val('');
	$('#mb_badness, #mb_left_request, #mb_left').attr('checked',false);
	$('#search_field :eq(0)').attr('selected',true);
	$('#search_keyword').val('');
}
</script>

<dl class="srchb lnb4_col bg2_col">

<form name="MemberSearchFrm" method="GET" id="MemberSearchFrm" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="mode" value="search" id="mode"/>
<input type="hidden" name="page_rows" value="<?php echo $page_rows;?>" id="page_rows"/>

	<table class="bg_col">
	<col width=90><col><col width=90><col>
	<tr>
		<td class="ctlt">회사분류</td>
		<td class="pdlnb2">
			<?php foreach($biz_types as $val){ ?>
			<label><input type="checkbox" name="mb_biz_type[]" class="check" value="<?php echo $val['code'];?>"/><?php echo $val['name'];?></label>&nbsp;
			<?php } ?>
		</td>
		<td class="ctlt">상장여부</td>
		<td class="pdlnb2">
			<?php foreach($biz_success as $val){ ?>
			<label><input type="checkbox" name="mb_biz_success[]" class="check" value="<?php echo $val['code'];?>"/><?php echo $val['name'];?></label>&nbsp;
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td class="ctlt">기업형태</td>
		<td class="pdlnb2" colspan="3">
			<?php foreach($biz_forms as $val){ ?>
			<label><input type="checkbox" name="mb_biz_form[]" class="check" value="<?php echo $val['code'];?>"/><?php echo $val['name'];?></label>&nbsp;
			<?php } ?>
		</td>
	</tr>
	</table>
	<dl class="tc pd7 wbg">
		<select name="search_field" class="s23" id="search_field">
			<option value="">통합검색</option>
			<option value="mb_id" <?php echo ($_GET['search_field']=='mb_id')?'selected':'';?>>아이디</option>
			<option value="mb_ceo_name" <?php echo ($_GET['search_field']=='mb_ceo_name')?'selected':'';?>>대표자명</option>
			<option value="mb_company_name" <?php echo ($_GET['search_field']=='mb_company_name')?'selected':'';?>>회사명</option>
			<option value="mb_biz_no" <?php echo ($_GET['search_field']=='mb_biz_no')?'selected':'';?>>사업자등록번호</option>
			<option value="mb_biz_phone" <?php echo ($_GET['search_field']=='mb_biz_phone')?'selected':'';?>>전화번호</option>
			<option value="mb_biz_hphone" <?php echo ($_GET['search_field']=='mb_biz_hphone')?'selected':'';?>>휴대폰번호</option>
			<option value="mb_biz_fax" <?php echo ($_GET['search_field']=='mb_biz_fax')?'selected':'';?>>팩스번호</option>
			<option value="mb_biz_email" <?php echo ($_GET['search_field']=='mb_biz_email')?'selected':'';?>>이메일</option>
		</select>
		<input type="text" name="search_keyword" value="<?php echo stripslashes($_GET['search_keyword']);?>" class="txt i23 w50" id="search_keyword">
		<span class="cbtn grf_col lnb_col" style="width:40px"><input type='submit' class="btn23 b" onFocus="blur()" value='검색'></span>
		<span class="bbtn"><input type='button' class="btn23 b" onFocus="blur()" value='초기화' onclick="searchFrmInit();"></span>
	</dl>

</form>
</dl>