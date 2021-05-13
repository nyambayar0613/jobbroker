<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<script>
// 검색폼 초기화
var searchFrmInit = function(){
	$('#start_dayAll').attr('checked',false);
	$('#start_day, #end_day').attr('disabled',false);
	$('#start_day, #end_day').val('');
	$('#search_field :eq(0)').attr('selected',true);
	$('#search_keyword').val('');
}
</script>

<dl class="srchb lnb4_col bg2_col">

<form name="MemberPointSearchFrm" method="GET" id="MemberPointSearchFrm" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="mode" value="search" id="mode"/>
<input type="hidden" name="page_rows" value="<?php echo $page_rows;?>" id="page_rows"/>

	<table class="bg_col" id="dsrch" style="display:;">
	<col width=80><col><col width=90><col>
	<tr>
		<td class="ctlt">일시</td>
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
	</table>
	<dl class="pd7 tc wbg">
		<select name="search_field" class="s23" id="search_field">
			<option value="">통합검색</option>
			<option value="mb_id" <?php echo ($_GET['search_field']=='mb_id')?'selected':'';?>>아이디</option>
			<option value="point_content" <?php echo ($_GET['search_field']=='point_content')?'selected':'';?>>내용</option>
		</select>
		<input type="text" name="search_keyword" value="<?php echo stripslashes($_GET['search_keyword']);?>" class="txt i23 w50" id="search_keyword">
		<span class="cbtn grf_col lnb_col" style="width:40px"><input type='submit' class="btn23 b" onFocus="blur()" value='검색'></span>
		<span class="bbtn"><input type='button' class="btn23 b" onFocus="blur()" value='초기화' onclick="searchFrmInit();"></span>
	</dl>

</form>
</dl>