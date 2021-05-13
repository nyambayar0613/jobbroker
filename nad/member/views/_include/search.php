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

	<table class="bg_col" id="dsrch" style="display:none;">
	<col width=90><col><col width=90><col>
	<tr>
		<td class="ctlt">
			<select name="date_type" id="date_type">
				<option value='mb_wdate' <?php echo (!$_GET['date_type']=='mb_wdate')?'selected':'';?>>가입일</option>
				<option value='mb_last_login' <?php echo ($_GET['date_type']=='mb_last_login')?'selected':'';?>>최종로그인</option>
			</select>
		</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="start_dayAll" type="checkbox" value="1" class="check" id='start_dayAll' <?php echo ($_GET['start_dayAll']=='1')?"checked":"";?>>전체</label> &nbsp;
			<input name="start_day" type="text" class="tday" id='start_day' <?php echo ($_GET['start_dayAll']=='1')?"disabled value=''":"value='".$_GET['start_day']."'";?>> ~
			<input name="end_day" type="text" class="tday" id='end_day' <?php echo ($_GET['start_dayAll']=='1')?"disabled value=''":"value='".$_GET['end_day']."'";?>>
			<a class="bbtn set_day" date='today'><h1 class="btn19">오늘</h1></a>
			<a class="bbtn set_day" date='week'><h1 class="btn19">이번주</h1></a>
			<a class="bbtn set_day" date='month'><h1 class="btn19">이번달</h1></a>
			<a class="bbtn set_day" date='7day'><h1 class="btn19">1주일</h1></a>
			<a class="bbtn set_day" date='15day'><h1 class="btn19">15일</h1></a>
			<a class="bbtn set_day" date='30day'><h1 class="btn19">1개월</h1></a>
			<a class="bbtn set_day" date='60day'><h1 class="btn19">3개월</h1></a>
			<a class="bbtn set_day" date='120day'><h1 class="btn19">6개월</h1></a>
		</td>
	</tr>
	<?php if($page_name=='company_member'){ ?>
	<input type="hidden" name="mb_type" value="company" id="mb_type"/>
	<tr>
		<td class="ctlt">방문수</td>
		<td class="pdlnb2">
			<label><input name="loginAll" type="checkbox" value="1" class="check" id='loginAll' <?php echo ($_GET['loginAll']=='1')?'checked':'';?>>전체</label> &nbsp;
			<input name="loginCnt_low" type="text" class="tnum tc" size="8" id='loginCnt_low' <?php echo ($_GET['loginAll']=='1')?"disabled value=''":"value='".$_GET['loginCnt_low']."'";?>> ~
			<input name="loginCnt_high" type="text" class="tnum tc" size="8" id='loginCnt_high' <?php echo ($_GET['loginAll']=='1')?"disabled value=''":"value='".$_GET['loginCnt_high']."'";?>>
		</td>
		<td class="ctlt">탈퇴구분</td>
		<td class="pdlnb2" <?php echo ($page_name!='member_bad_list')?"":"colspan='3'";?>>
			<label><input name="mb_left_request" type="checkbox" value="1" class="check" id='mb_left_request' <?php echo ($_GET['mb_left_request'])?'checked':'';?>>탈퇴요청</label> &nbsp;
			<label><input name="mb_left" type="checkbox" value="1" class="check" id='mb_left' <?php echo ($_GET['mb_left'])?'checked':'';?>>탈퇴완료</label> &nbsp;
		</td>
	</tr>
	<tr>
		<td class="ctlt">불량회원구분</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="mb_badness" type="checkbox" value="1" class="check" id='mb_badness' <?php echo ($_GET['mb_badness'])?'checked':'';?>>불량회원</label> &nbsp;
		</td>
	</tr>
	<?php } else { ?>
	<?php if($page_name=='individual_member') { ?>
	<input type="hidden" name="mb_type" value="individual" id="mb_type"/>
	<?php } ?>
	<tr>
		<td class="ctlt">방문수</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="loginAll" type="checkbox" value="1" class="check" id='loginAll' <?php echo ($_GET['loginAll']=='1')?'checked':'';?>>전체</label> &nbsp;
			<input name="loginCnt_low" type="text" class="tnum tc" size="8" id='loginCnt_low' <?php echo ($_GET['loginAll']=='1')?"disabled value=''":"value='".$_GET['loginCnt_low']."'";?>> ~
			<input name="loginCnt_high" type="text" class="tnum tc" size="8" id='loginCnt_high' <?php echo ($_GET['loginAll']=='1')?"disabled value=''":"value='".$_GET['loginCnt_high']."'";?>>
		</td>
	</tr>
	<tr>
		<?php if($page_name!='member_bad_list'){ ?>
		<td class="ctlt">불량회원구분</td>
		<td class="pdlnb2">
			<label><input name="mb_badness" type="checkbox" value="1" class="check" id='mb_badness' <?php echo ($_GET['mb_badness'])?'checked':'';?>>불량회원</label> &nbsp;
		</td>
		<?php } ?>
		<td class="ctlt">탈퇴구분</td>
		<td class="pdlnb2" <?php echo ($page_name!='member_bad_list')?"":"colspan='3'";?>>
			<label><input name="mb_left_request" type="checkbox" value="1" class="check" id='mb_left_request' <?php echo ($_GET['mb_left_request'])?'checked':'';?>>탈퇴요청</label> &nbsp;
			<label><input name="mb_left" type="checkbox" value="1" class="check" id='mb_left' <?php echo ($_GET['mb_left'])?'checked':'';?>>탈퇴완료</label> &nbsp;
		</td>
	</tr>
	<?php } ?>
	</table>
	<dl class="tc pd7 wbg">
		<select name="search_field" class="s23" id="search_field">
			<option value="">통합검색</option>
			<option value="mb_id" <?php echo ($_GET['search_field']=='mb_id')?'selected':'';?>>아이디</option>
			<option value="mb_name" <?php echo ($_GET['search_field']=='mb_name')?'selected':'';?>>이름</option>
			<option value="mb_email" <?php echo ($_GET['search_field']=='mb_email')?'selected':'';?>>이메일</option>
		</select>
		<input type="text" name="search_keyword" value="<?php echo stripslashes($_GET['search_keyword']);?>" class="txt i23 w50" id="search_keyword">
		<span class="cbtn grf_col lnb_col" style="width:40px"><input type='submit' class="btn23 b" onFocus="blur()" value='검색'></span>
		<span class="bbtn"><input type='button' class="btn23 b" onFocus="blur()" value='초기화' onclick="searchFrmInit();"></span>
		<span class="btn" id="dsrchType" enum="yes"><input type='button' class="btn23 b" onFocus="blur()" value='상세검색' id="searchBtn"></span>
		<!--<span onClick="MM_showHideLayers('dsrch','','hide')"  class="btn"><input type='submit' class="btn23 b" onFocus="blur()" value='간편검색'></span> -->
	</dl>

</form>
</dl>