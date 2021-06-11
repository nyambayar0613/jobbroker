<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class='pt5'>
	<dl class="srchb lnb4_col bg2_col">

	<form name="statisticsSearchFrm" method="GET" id="statisticsSearchFrm">
	<input type="hidden" name="mode" value="search" id="mode"/>
	<input type="hidden" name="type" value="<?php echo $type;?>"/>

	<dl class="tc pd7 wbg">
		<input name="start_day" type="text" class="tday" id='start_day' value="<?php echo ($_GET['start_day'])?$_GET['start_day']:$first_day;?>"> ~
		<input name="end_day" type="text" class="tday" id='end_day' value="<?php echo ($_GET['start_day'])?$_GET['end_day']:$to_day;?>">
		<a class="bbtn set_day" date='today'><h1 class="btn19">Өнөөдөр</h1></a>
		<a class="bbtn set_day" date='week'><h1 class="btn19">Энэ 7 хоног</h1></a>
		<a class="bbtn set_day" date='month'><h1 class="btn19">Энэ сар</h1></a>
		<a class="bbtn set_day" date='7day'><h1 class="btn19">1 долоо хоног</h1></a>
		<a class="bbtn set_day" date='15day'><h1 class="btn19">15 өдөр</h1></a>
		<a class="bbtn set_day" date='30day'><h1 class="btn19">1 сар</h1></a>
		<a class="bbtn set_day" date='60day'><h1 class="btn19">3 сар</h1></a>
		<a class="bbtn set_day" date='120day'><h1 class="btn19">6 сар</h1></a>
		&nbsp;
		<span class="cbtn grf_col lnb_col" style="width:40px"><input type='submit' class="btn19 b" onFocus="blur()" value='Хайх'/></span>
		<span class="btn"><input type='button' class="btn19 b" onFocus="blur()" onclick="$('#statisticsSearchFrm').resetForm();" value='Эхлэл'></span>
	</dl>

	</form>
	</dl>
</dl>