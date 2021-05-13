<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<script>
$(function(){
	
	// 쿠키로 저장된 값 불러오기
	if($.cookie('paydsrch') == 'true'){
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
		$.cookie('paydsrch',sel, { expires:1, domain:domain, path:'/', secure:0});	// 쿠키 저장
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
			$('#pay_status_all').attr('checked',false);
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
	$('#pay_method :eq(0)').attr('selected',true);
	$('#search_keyword').val("");
	$("input[name='status[]']").attr('checked',false);
	$('#pay_status_all').attr('checked',true);
}

</script>
<dl class="srchb lnb4_col bg2_col">

<form name="paymentSearchFrm" method="GET" id="paymentSearchFrm" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="mode" value="search" id="mode"/>
<input type="hidden" name="page_rows" value="<?php echo $page_rows;?>" id="page_rows"/>
<!-- <input type="hidden" name="date_type" value="mb_wdate" id="date_type"/> -->

	<table class="bg_col" id="dsrch" style="display:none;">
	<col width=130><col><col width=90><col>
	<tr>
		<td class="ctlt">
			<select name="search_date" id="search_date">
				<option value="pay_sdate" <?php echo ($_GET['search_date']=='pay_sdate')?'selected':'';?>>입금완료일</option>
				<option value="pay_wdate" <?php echo ($_GET['search_date']=='pay_wdate')?'selected':'';?>>결제신청일</option>
				<option value="pay_cdate" <?php echo ($_GET['search_date']=='pay_cdate')?'selected':'';?>>취소신청일</option>
				<option value="pay_ccdate" <?php echo ($_GET['search_date']=='pay_ccdate')?'selected':'';?>>취소완료</option>
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
		<td class="pdlnb2">
			<label><input name="status[]" type="checkbox" value="all" class="check" id="pay_status_all" <?php echo (@in_array('all',$_GET['status']))?'checked':'';?>>전체</label> &nbsp;
			<?php foreach($pay_status as $key => $val){ ?>
			<label><input name="status[]" type="checkbox" value="0" class="check" <?php echo (@in_array($key,$_GET['status']))?'checked':'';?>><?php echo $val;?></label> &nbsp;
			<?php } ?>
		</td>
		<td class="ctlt">결제수단</td>
		<td class="pdlnb2">
			<select name="pay_method" id="pay_method">
			<option value="">::전체::</option>
			<option value="card" <?php echo ($_GET['pay_method']=='card')?'selected':'';?>>신용카드</option> 
			<option value="bank" <?php echo ($_GET['pay_method']=='bank')?'selected':'';?>>무통장입금</option> 
			<option value="online" <?php echo ($_GET['pay_method']=='online')?'selected':'';?>>계좌이체</option> 
			<option value="hp" <?php echo ($_GET['pay_method']=='hp')?'selected':'';?>>핸드폰</option>  
			<!-- <option value="phone" <?php echo ($_GET['pay_method']=='phone')?'selected':'';?>>일반전화</option>  -->
			<!-- <option value="admin" <?php echo ($_GET['pay_method']=='admin')?'selected':'';?>>관리자등록</option>   -->
			<!-- <option value="free" <?php echo ($_GET['pay_method']=='free')?'selected':'';?>>무료</option>  -->
			</select>
		</td>
	</tr>
	<tr>
		<td class="ctlt">구인정보 서비스</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="pay_service[]" type="checkbox" value="main_platinum" class="check" id="main_platinum" <?php echo (@in_array('main_platinum',$_GET['pay_service']))?'checked':'';?>>플래티넘</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="main_platinum_gold" class="check" id="main_platinum_gold" <?php echo (@in_array('main_platinum_gold',$_GET['pay_service']))?'checked':'';?>>플래티넘 Gold</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="main_platinum_logo" class="check" id="main_platinum_logo" <?php echo (@in_array('main_platinum_logo',$_GET['pay_service']))?'checked':'';?>>플래티넘 로고강조</label> &nbsp;

			<label><input name="pay_service[]" type="checkbox" value="main_grand" class="check" id="main_grand" <?php echo (@in_array('main_grand',$_GET['pay_service']))?'checked':'';?>>그랜드</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="main_grand_gold" class="check" id="main_grand_gold" <?php echo (@in_array('main_grand_gold',$_GET['pay_service']))?'checked':'';?>>그랜드 Gold</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="main_grand_logo" class="check" id="main_grand_logo" <?php echo (@in_array('main_grand_logo',$_GET['pay_service']))?'checked':'';?>>그랜드 로고강조</label> &nbsp;

			<label><input name="pay_service[]" type="checkbox" value="main_special" class="check" id="main_special" <?php echo (@in_array('main_special',$_GET['pay_service']))?'checked':'';?>>스페셜</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="main_special_gold" class="check" id="main_special_gold" <?php echo (@in_array('main_special_gold',$_GET['pay_service']))?'checked':'';?>>스페셜 Gold</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="main_special_logo" class="check" id="main_special_logo" <?php echo (@in_array('main_special_logo',$_GET['pay_service']))?'checked':'';?>>스페셜 로고강조</label> &nbsp;
			
			<label><input name="pay_service[]" type="checkbox" value="main_basic" class="check" id="main_basic" <?php echo (@in_array('main_basic',$_GET['pay_service']))?'checked':'';?>>구인 일반리스트</label> &nbsp;
		</td>
	</tr>
	<tr>
		<td class="ctlt">인재정보 서비스</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="pay_service[]" type="checkbox" value="main_focus" class="check" id="main_focus" <?php echo (@in_array('main_focus',$_GET['pay_service']))?'checked':'';?>>포커스</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="main_focus_gold" class="check" id="main_focus_gold" <?php echo (@in_array('main_focus_gold',$_GET['pay_service']))?'checked':'';?>>포커스 Gold</label> &nbsp;			
			<label><input name="pay_service[]" type="checkbox" value="main_resume_basic" class="check" id="main_resume_basic" <?php echo (@in_array('main_resume_basic',$_GET['pay_service']))?'checked':'';?>>인재 일반리스트</label> &nbsp;			
		</td>
	</tr>
	<tr>
		<td class="ctlt">구인정보 옵션서비스</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="pay_service[]" type="checkbox" value="alba_option_busy" class="check" id="alba_option_busy" <?php echo (@in_array('alba_option_busy',$_GET['pay_service']))?'checked':'';?>>급구</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="alba_option_neon" class="check" id="alba_option_neon" <?php echo (@in_array('alba_option_neon',$_GET['pay_service']))?'checked':'';?>>형광펜</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="alba_option_bold" class="check" id="alba_option_bold" <?php echo (@in_array('alba_option_bold',$_GET['pay_service']))?'checked':'';?>>굵은글자</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="alba_option_icon" class="check" id="alba_option_icon" <?php echo (@in_array('alba_option_icon',$_GET['pay_service']))?'checked':'';?>>아이콘</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="alba_option_color" class="check" id="alba_option_color" <?php echo (@in_array('alba_option_color',$_GET['pay_service']))?'checked':'';?>>글자색</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="alba_option_blink" class="check" id="alba_option_blink" <?php echo (@in_array('alba_option_blink',$_GET['pay_service']))?'checked':'';?>>반짝칼라</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="alba_option_jump" class="check" id="alba_option_jump" <?php echo (@in_array('alba_option_jump',$_GET['pay_service']))?'checked':'';?>>점프</label> &nbsp;
		</td>
	</tr>
	<tr>
		<td class="ctlt">구인정보 옵션서비스</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="pay_service[]" type="checkbox" value="resume_option_busy" class="check" id="resume_option_busy" <?php echo (@in_array('resume_option_busy',$_GET['pay_service']))?'checked':'';?>>급구</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="resume_option_neon" class="check" id="resume_option_neon" <?php echo (@in_array('resume_option_neon',$_GET['pay_service']))?'checked':'';?>>형광펜</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="resume_option_bold" class="check" id="resume_option_bold" <?php echo (@in_array('resume_option_bold',$_GET['pay_service']))?'checked':'';?>>굵은글자</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="resume_option_icon" class="check" id="resume_option_icon" <?php echo (@in_array('resume_option_icon',$_GET['pay_service']))?'checked':'';?>>아이콘</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="resume_option_color" class="check" id="resume_option_color" <?php echo (@in_array('resume_option_color',$_GET['pay_service']))?'checked':'';?>>글자색</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="resume_option_blink" class="check" id="resume_option_blink" <?php echo (@in_array('resume_option_blink',$_GET['pay_service']))?'checked':'';?>>반짝칼라</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="resume_option_jump" class="check" id="resume_option_jump" <?php echo (@in_array('resume_option_jump',$_GET['pay_service']))?'checked':'';?>>점프</label> &nbsp;
		</td>
	</tr>
	<tr>
		<td class="ctlt">기타 서비스</td>
		<td class="pdlnb2" colspan="3">
			<label><input name="pay_service[]" type="checkbox" value="etc_open" class="check" id="etc_open" <?php echo (@in_array('etc_open',$_GET['pay_service']))?'checked':'';?>>인재정보열람권</label> &nbsp;
			<label><input name="pay_service[]" type="checkbox" value="etc_alba" class="check" id="etc_alba" <?php echo (@in_array('etc_alba',$_GET['pay_service']))?'checked':'';?>>구인정보열람권</label> &nbsp;
		</td>
	</tr>
	</table>

	<dl class="tc pd7 wbg">
		<select name="search_field" class="s23" id="search_field">
			<option value="">통합검색</option>
			<option value="pay_uid" <?php echo ($_GET['search_field']=='pay_uid')?'selected':'';?>>회원아이디</option>
			<option value="pay_name" <?php echo ($_GET['search_field']=='pay_name')?'selected':'';?>>이름</option>
			<option value="pay_bank_name" <?php echo ($_GET['search_field']=='pay_bank_name')?'selected':'';?>>입금자명</option>
			<option value="pay_email" <?php echo ($_GET['search_field']=='pay_email')?'selected':'';?>>이메일</option>
		</select>
		<input type="text" name="search_keyword" value="<?php echo stripslashes($_GET['search_keyword']);?>" class="txt i23 w50" id="search_keyword">
		<span class="cbtn grf_col lnb_col" style="width:40px"><input type='submit' class="btn23 b" onFocus="blur()" value='검색'></span>
		<span class="bbtn" style="width:50px"><input type='button' class="btn23 b" onFocus="blur()" value='초기화' onclick="searchFrmInit();"></span>
		<span class="btn" id="dsrchType" enum="yes"><input type='button' class="btn23 b" onFocus="blur()" value='상세검색' id="searchBtn"></span>
		<!--<span onClick="MM_showHideLayers('dsrch','','hide')"  class="btn" style="width:60px"><input type='submit' class="btn23 b" onFocus="blur()" value='간편검색'></span> -->
	</dl>
</dl>
