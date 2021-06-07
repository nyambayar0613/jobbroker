<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>
<script>
$(function(){
	// 가입일 전체 체크
	$('#start_dayAll').click(function(){
		var checked_trues = $(this).is(':checked');
		if(checked_trues==true){
			$('#start_day').val('');
			$('#end_day').val('');
		}
		$('#start_day').attr('disabled',checked_trues);
		$('#end_day').attr('disabled',checked_trues);
	});
	// 방문수 전체 체크
	$('#loginAll').click(function(){
		var checked_trues = $(this).is(':checked');
		if(checked_trues==true){
			$('#loginCnt_low').val('');
			$('#loginCnt_high').val('');
		}
		$('#loginCnt_low').attr('disabled',checked_trues);
		$('#loginCnt_high').attr('disabled',checked_trues);
	});
	// Pin수 전체 체크
	$('#pinAll').click(function(){
		var checked_trues = $(this).is(':checked');
		if(checked_trues==true){
			$('#pinCnt_low').val('');
			$('#pinCnt_high').val('');
		}
		$('#pinCnt_low').attr('disabled',checked_trues);
		$('#pinCnt_high').attr('disabled',checked_trues);
	});
});
// 검색폼 초기화
var searchFrmInit = function(){
	$('#date_type :eq(0)').attr('selected',true);
	$('#start_dayAll').attr('checked',false);
	$('#start_day, #end_day').attr('disabled',false);
	$('#start_day, #end_day').val('');
	$("input[name='mb_group']").filter("input[value='all']").attr('checked',true);
	$("input[name='mb_sns[]']").attr('checked',false);
	$('#loginAll, #pinAll').attr('checked',false);
	$('#loginCnt_low, #loginCnt_high, #pinCnt_low, #pinCnt_high').attr('disabled',false);
	$('#loginCnt_low, #loginCnt_high, #pinCnt_low, #pinCnt_high').val('');
	$('#search_field :eq(0)').attr('selected',true);
	$("input[name='mb_type']").filter("input[value='all']").attr('checked',true);
	$("input[name='mb_email_receive']").filter("input[value='all']").attr('checked',true);
}
</script>
<dl class="srchb lnb4_col bg2_col">

<form name="MemberSearchFrm" method="GET" id="MemberSearchFrm" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="mode" value="search" id="mode"/>
<input type="hidden" name="page_rows" value="<?php echo $page_rows;?>" id="page_rows"/>

	<table width="100%" class="bg_col">
	<col width=90><col><col width=90><col>
	<tr>
		<td class="ctlt tc">
			<select name="date_type" id="date_type">
				<option value='mb_wdate'>가입일</option>
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
	<tr>
		<td class="ctlt">회원구분</td>
		<td class="pdlnb2">
			<label><input name="mb_type" type="radio" value="all" class="radio" checked>전체</label> &nbsp;
			<label><input name="mb_type" type="radio" value="individual" class="radio" <?php echo ($_GET['mb_type']=='individual')?'checked':'';?>>개인</label> &nbsp;
			<label><input name="mb_type" type="radio" value="company" class="radio" <?php echo ($_GET['mb_type']=='company')?'checked':'';?>>기업</label> &nbsp;
		</td>
		<td class="ctlt">방문수</td>
		<td class="pdlnb2">
			<label><input name="loginAll" type="checkbox" value="1" class="check" id='loginAll' <?php echo ($_GET['loginAll']=='1')?'checked':'';?>>전체</label> &nbsp;
			<input name="loginCnt_low" type="text" class="tnum tc" size="8" id='loginCnt_low' <?php echo ($_GET['loginAll']=='1')?"disabled value=''":"value='".$_GET['loginCnt_low']."'";?>> ~
			<input name="loginCnt_high" type="text" class="tnum tc" size="8" id='loginCnt_high' <?php echo ($_GET['loginAll']=='1')?"disabled value=''":"value='".$_GET['loginCnt_high']."'";?>>
		</td>
	</tr>
	<tr>
		<td class="ctlt">메일수신여부</td>
		<td class="pdlnb2" colspan='3'>
			<label><input name="mb_email_receive" type="radio" value="all" class="radio" checked>전체</label> &nbsp;
			<label><input name="mb_email_receive" type="radio" value="1" class="radio" <?php echo ($_GET['mb_email_receive']=='1')?'checked':'';?>>허용</label> &nbsp;
			<label><input name="mb_email_receive" type="radio" value="0" class="radio" <?php echo ($_GET['mb_email_receive']=='0')?'checked':'';?>>거부</label>
		</td>
		<!-- <td class="ctlt">SMS수신여부</td>
		<td class="pdlnb2">
			<label><input name="mb_sms_receive" type="radio" value="all" class="radio" checked>전체</label> &nbsp;
			<label><input name="mb_sms_receive" type="radio" value="1" class="radio" <?php echo ($_GET['mb_sms_receive']=='1')?'checked':'';?>>허용</label> &nbsp;
			<label><input name="mb_sms_receive" type="radio" value="0" class="radio" <?php echo ($_GET['mb_sms_receive']=='0')?'checked':'';?>>거부</label>
		</td> -->
	</tr>
	</table>
	<dl class="tc pd7 wbg">
		<select name="search_field" class="s23" id="search_field">
			<option value="">통합검색</option>
			<option value="mb_id" <?php echo ($_GET['search_field']=='mb_id')?'selected':'';?>>아이디</option>
			<option value="mb_name" <?php echo ($_GET['search_field']=='mb_name')?'selected':'';?>>이름</option>
			<option value="mb_nick" <?php echo ($_GET['search_field']=='mb_nick')?'selected':'';?>>닉네임</option>
			<option value="mb_email" <?php echo ($_GET['search_field']=='mb_email')?'selected':'';?>>이메일</option>
		</select>
		<input type="text" name="search_keyword" value="<?php echo stripslashes($_GET['search_keyword']);?>" class="txt i23 w50" id="search_keyword">
		<span class="cbtn grf_col lnb_col" style="width:40px"><input type='submit' class="btn23 b" onFocus="blur()" value='검색'></span>
		<span class="bbtn"><input type='button' class="btn23 b" onFocus="blur()" value='초기화' onclick="searchFrmInit();"></span>
	</dl>

</form>
</dl>