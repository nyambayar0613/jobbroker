<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<script>
var status = [];
<?php if($status){
	for($i=0;$i<$status_cnt;$i++){
?>
status.push("<?php echo $status[$i];?>");
<?php 
	}
} else { 
?>
var status = [];
<?php } ?>

$(function(){
	
	// 결제일 전체 체크
	$('#start_dayAll').click(function(){
		var checked_trues = $(this).is(':checked');
		if(checked_trues==true){
			$('#start_day').val('');
			$('#end_day').val('');
		}
		$('#start_day').attr('disabled',checked_trues);
		$('#end_day').attr('disabled',checked_trues);
	});

	$("input[name='status[]']").click(function(){
		var status_sel = $(this).val();
		if(status_sel!='all'){	// 전체가 아닐때만
			$('#wr_status_all').attr('checked',false);
		} else {	 // 전체 일때
			var status_all = $(this).is(':checked');
			if(status_all==true){
				$("input[name='status[]']").attr('checked',true);
			} else {
				$("input[name='status[]']").attr('checked',false);
			}
		}
	});

	var pay_status_all = $('#pay_status_all').is(':checked');
	if(pay_status_all==true)
		$("input[name='status[]']").attr('checked',true);

});
// 검색폼 초기화
var searchFrmInit = function(){
	$('#search_date :eq(0)').attr('selected',true);
	$('#start_dayAll').attr('checked',false);
	$('#start_day, #end_day').attr('disabled',false);
	$('#start_day, #end_day').val('');
	$('#search_field :eq(0)').attr('selected',true);
	$('#search_keyword').val("");
	$("input[name='status[]']").attr('checked',false);
}
var page_rowss = function(sels){	// 출력 갯수
	var sel = sels.value, send_url = "<?php echo $tax_list['send_url'];?>";
	location.href = "./tax.php?"+send_url+"&page_rows=" + sel + "&status="+status;
}
</script>
<dl class="srchb lnb4_col bg2_col">

<form name="paymentSearchFrm" method="GET" id="paymentSearchFrm" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="mode" value="search" id="mode"/>
<!-- <input type="hidden" name="page_rows" value="<?php echo $page_rows;?>" id="page_rows"/> -->
<!-- <input type="hidden" name="date_type" value="mb_wdate" id="date_type"/> -->

	<table class="bg_col" id="dsrch" style="display:;">
	<col width=90><col><col width=90><col>
	<tr>
		<td class="ctlt tc">
			<select name="search_date" id="search_date">
				<option value="wdate" <?php echo ($_GET['search_date']=='wdate')?'selected':'';?>>신청일</option>
				<option value="wr_pay_date" <?php echo ($_GET['search_date']=='wr_pay_date')?'selected':'';?>>결제일</option>
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
		<td class="ctlt">진행상태</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="status[]" type="checkbox" value="all" class="check" id="wr_status_all" <?php echo (@in_array('all',$status))?'checked':'';?>>전체</label> &nbsp;
			<label><input name="status[]" type="checkbox" value="0" class="check" <?php echo (@in_array('0',$status))?'checked':'';?>>신청중</label> &nbsp;
			<label><input name="status[]" type="checkbox" value="1" class="check" <?php echo (@in_array('1',$status))?'checked':'';?>>처리완료</label> &nbsp;
			<label><input name="status[]" type="checkbox" value="2" class="check" <?php echo (@in_array('2',$status))?'checked':'';?>>취소</label> &nbsp;
			<label><input name="status[]" type="checkbox" value="3" class="check" <?php echo (@in_array('3',$status))?'checked':'';?>>불가</label>
		</td>
	</tr>
	</table>

	<dl class="tc pd7 wbg">
		<select name="search_field" class="s23" id="search_field">
			<option value="">통합검색</option>
			<option value="wr_name" <?php echo ($_GET['search_field']=='wr_name')?'selected':'';?>>신청자명</option>
			<option value="wr_id" <?php echo ($_GET['search_field']=='wr_id')?'selected':'';?>>신청회원ID</option>
			<option value="wr_company_name" <?php echo ($_GET['search_field']=='wr_company_name')?'selected':'';?>>회사명</option>
			<option value="wr_ceo_name" <?php echo ($_GET['search_field']=='wr_ceo_name')?'selected':'';?>>대표자명</option>
		</select>
		<input type="text" name="search_keyword" value="<?php echo stripslashes($_GET['search_keyword']);?>" class="txt i23 w50" id="search_keyword">
		<span class="cbtn grf_col lnb_col" style="width:40px"><input type='submit' class="btn23 b" onFocus="blur()" value='검색'></span>
		<span class="bbtn" style="width:50px"><input type='button' class="btn23 b" onFocus="blur()" value='초기화' onclick="searchFrmInit();"></span>
		<!--<span onClick="MM_showHideLayers('dsrch','','hide')"  class="btn" style="width:60px"><input type='submit' class="btn23 b" onFocus="blur()" value='간편검색'></span> -->
	</dl>
</dl>
