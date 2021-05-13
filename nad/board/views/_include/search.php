<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>
<script>
$(function(){

	// 쿠키로 저장된 값 불러오기
	if($.cookie('<?php echo $dsrch_cookie;?>dsrch') == 'true'){
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
		$.cookie('<?php echo $dsrch_cookie;?>dsrch',sel, { expires:1, domain:domain, path:'/', secure:0});	// 쿠키 저장
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
	// pin 등록기간 전체 체크
	$('#start_dayAll').click(function(){
		var checked_trues = $(this).is(':checked');
		if(checked_trues==true){
			$('#start_day').val('');
			$('#end_day').val('');
		}
		$('#start_day').attr('disabled',checked_trues);
		$('#end_day').attr('disabled',checked_trues);
	});

});
// 검색폼 초기화
var searchFrmInit = function(){
	$('#start_dayAll').attr('checked',false);
	$('#start_day, #end_day').attr('disabled',false);
	$('#start_day, #end_day').val('');
	$('#wr_type :eq(0)').attr('selected',true);
	$('#search_field :eq(0)').attr('selected',true);
	$('#search_keyword').val('');
}
</script>

<dl class="srchb lnb4_col bg2_col mt7">

	<form name="SearchFrm" method="GET" id="SearchFrm" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="mode" value="search" id="mode"/>
	<input type="hidden" name="page_rows" value="<?php echo $page_rows;?>" id="page_rows"/>

	<table class="bg_col" id="dsrch" style="display:none">
	<col width=85><col>
	<tr>
		<td class="ctlt">기간</td>
		<td class="pdlnb2">
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
		<td class="ctlt">분류</td>
		<td class="pdlnb2">
			<select name="wr_type" id="wr_type">
			<option value=''>전체</option>
			<?php echo $search_category;?>
			</select>
		</td>
	</tr>
	</table>

	<dl class="tc pd7 wbg">
		<select name="search_field" class="s23" id="search_field">
			<option value="">통합검색</option>
			<option value="wr_subject" <?php echo ($_GET['search_field']=='wr_subject')?'selected':'';?>>제목</option>
			<option value="wr_content" <?php echo ($_GET['search_field']=='wr_content')?'selected':'';?>>내용</option>
			<option value="wr_subject||wr_content" <?php echo ($_GET['search_field']=='wr_subject||wr_content')?'selected':'';?>>제목+내용</option>
			<option value="wr_name" <?php echo ($_GET['search_field']=='wr_name')?'selected':'';?>>작성자</option>
		</select>
		<input type="text" name="search_keyword" value="<?php echo stripslashes($_GET['search_keyword']);?>" class="txt i23 w50" id="search_keyword">
		<span class="cbtn grf_col lnb_col" style="width:40px"><input type='submit' class="btn23 b" onFocus="blur()" value='검색'></span>
		<span class="bbtn"><input type='button' class="btn23 b" onFocus="blur()" value='초기화' onclick="searchFrmInit();"></span>
		<span class="btn" id="dsrchType" enum="yes"><input type='button' class="btn23 b" onFocus="blur()" value='상세검색' id="searchBtn"></span>
	</dl>
	
	</form>

</dl>