<?php
$_cate_['job_type'] = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = ''"));
$_cate_['area'] = $netfu_util->get_cate_array('area', array('where'=>" and `p_code` = ''"));
?>
<script type="text/javascript">
var search_func = function() {
	var form = document.forms['ftsearch'];
	form.submit();
}
</script>
<form name="ftsearch" action="<?=$_SERVER['PHP_SELF'];?>" method="get">
<input type="hidden" name="code" value="<?=$_GET['code'];?>" />
<div class="schbox_wrap cf">
	<div class="search_con search_box cf">
		<table class="search_tb">
		<!-- 검색유형1 -->
		<tr>
			<th class="sch_hd">
				<div>Ажлын төрөл</div>
			</th>
			<td class="sch_td1">
				<select name="job_type[]" sel="1" type="job_type" val="<?=$_GET['job_type'][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 1)">
				<option value="">Ажлын төрөл 1</option>
				<?php
				if(is_array($_cate_['job_type'])) { foreach($_cate_['job_type'] as $k=>$v) {
					$selected = $_GET['job_type'][0]==$v['code'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
			<td class="sch_td2">
				<select name="job_type[]" sel="2" type="job_type" val="<?=$_GET['job_type'][2];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)">
				<option value="">Ажлын төрөл 2</option>
				</select>
			</td>
			<td class="sch_td3">
				<select name="job_type[]">
				<option value="">Ажлын төрөл 3</option>
				</select>
			</td>
		</tr>
		<!-- 검색유형1 -->w
		<tr>
			<th class="sch_hd">
				<div>Бүс нутгаар</div>
			</th>
			<td class="sch_td1">
				<select name="area[]" sel="1" type="area" val="<?=$_GET['area'][1];?>" onChange="netfu_util1.ajax_cate(this, 'area', 1)">
				<option value="">хот·дүүрэг</option>
				<?php
				if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
					$selected = $v['code']==$_GET['area'][0] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
			<td class="sch_td2">
				<select name="area[]" sel="2" type="area" val="<?=$_GET['area'][2];?>" onChange="netfu_util1.ajax_cate(this, 'area', 2)">
				<option value="">хороо·гудам·тоот</option>
				</select>
			</td>
			<td class="sch_td3">
				<select name="area[]">
				<option value="">хороо·гудам·тоот</option>
				</select>
			</td>
		</tr>
		</table>
	</div>
	<div class="schbtn_con cf">
		<ul>
			<li class="search_bx sch_bt sch_bt2">
				<button type="button" class="sch_button" onClick="search_func()"><img src="/images/search_icon3.png" alt="Хайх">Хайх</button>
			</li>
			<li class="search_bx sch_bt">
				<a href="<?=NFE_URL;?>/recruit10.php" class="sch_button">Дэлгэрэнгүй хайх</a>
			</li>
		</ul>
	</div>
</div>
</form>