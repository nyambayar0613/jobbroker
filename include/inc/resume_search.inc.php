<?php
$_cate_['job_type'] = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = ''"));
$_cate_['area'] = $netfu_util->get_cate_array('area', array('where'=>" and `p_code` = ''"));
$_cate_['indi_ability'] = $netfu_util->get_cate_array('indi_ability', array('where'=>" and `p_code` = ''"));
$_cate_['alba_date'] = $netfu_util->get_cate_array('alba_date', array('where'=>" and `p_code` = ''"));
$_cate_['alba_week'] = $netfu_util->get_cate_array('alba_week', array('where'=>" and `p_code` = ''"));
$_cate_['alba_time'] = $netfu_util->get_cate_array('alba_time', array('where'=>" and `p_code` = ''"));
?>
<style type="text/css">
    <?php
    if($_GET['code']!='search') {
    ?>
    .search_tb tr { display:none; }
    <?php }?>
    .search_tb tr._view { display:table-row; }
    .search_tb tr._<?=$_GET['code'];?> { display:table-row; }
</style>
<form name="ftsearch" action="<?=$_SERVER['PHP_SELF'];?>" method="get">
    <input type="hidden" name="code" value="<?=$_GET['code'];?>" />
    <div class="schbox_wrap cf">
        <div class="search_con search_box">
            <table class="search_tb">
                <!-- 검색유형1 -->
                <tr class="_view">
                    <th class="sch_hd">
                        <div>Байгууллагын байршил</div>
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
                        <select name="area[]" sel="2" type="area" this="<?=$_GET['area'][1];?>" val="<?=$_GET['area'][2];?>" onChange="netfu_util1.ajax_cate(this, 'area', 2)">
                            <option value="">хороо·тоот·гудамж</option>
                        </select>
                    </td>
                    <td class="sch_td3">
                        <select name="area[]">
                            <option value="">зам·орц·дугаар</option>
                        </select>
                    </td>
                </tr>
                <!-- 검색유형2 -->
                <tr class="_view">
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
                        <select name="job_type[]" sel="2" type="job_type" this="<?=$_GET['job_type'][1];?>" val="<?=$_GET['job_type'][2];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)">
                            <option value="">Ажлын төрөл 2</option>
                        </select>
                    </td>
                    <td class="sch_td3">
                        <select name="job_type[]">
                            <option value="">Ажлын төрөл 3</option>
                        </select>
                    </td>
                </tr>
                <!-- 검색유형7 -->
                <tr>
                    <th class="sch_hd">
                        <div>Туршлага</div>
                    </th>
                    <td class="sch_td1">
                        <select name="wr_career">
                            <option value="">Туршлага сонгох</option>
                            <?php
                            for($i=1; $i<=50; $i++) {
                                $selected = $_GET['wr_career']==$i ? 'selected' : '';
                                ?>
                                <option value="<?=$i;?>" <?=$selected;?>><?=$i;?>жил↑</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td class="sch_td2" colspan="2">
                        <fieldset>
                            <legend>Туршлага сонгох</legend>
                            <label><input type="radio" name="wr_career_use" id="unrelated" value="0" <?=$_GET['wr_career_use']=='0' ? 'checked' : '';?> />Хамааралгүй</label>
                            <label><input type="radio" name="wr_career_use" id="new-recruit" value="1" <?=$_GET['wr_career_use']=='1' ? 'checked' : '';?> />Шинэ ажилтан</label>
                            <label><input type="radio" name="wr_career_use" id="career" value="2" <?=$_GET['wr_career_use']=='2' ? 'checked' : '';?> />Туршлага</label>
                        </fieldset>
                    </td>
                </tr>
                <!-- 검색유형8 -->
                <tr>
                    <th class="sch_hd">
                        <div>Боловсрол</div>
                    </th>
                    <td class="sch_td1" colspan="3">
                        <select name="wr_school_ability">
                            <option value="">Сонгох</option>
                            <?php
                            if(is_array($_cate_['indi_ability'])) { foreach($_cate_['indi_ability'] as $k=>$v) {
                                $selected = $v['code']."/".$v['rank']==$_GET['wr_school_ability'] ? 'selected' : '';
                                ?>
                                <option value="<?=$v['code']."/".$v['rank'];?>" <?=$selected;?>><?=$v['name'];?></option>
                                <?php
                            } }
                            ?>
                        </select>
                    </td>
                </tr>
                <!-- 검색유형9 -->
                <tr>
                    <th class="sch_hd">
                        <div>Хүйс</div>
                    </th>
                    <td class="sch_td1" colspan="3">
                        <select name="wr_gender">
                            <option value="">Хүйс сонгох</option>
                            <option value="0" <?=$_GET['wr_gender']=='0' ? 'selected' : '';?>>Эр</option>
                            <option value="1" <?=$_GET['wr_gender']=='1' ? 'selected' : '';?>>Эм</option>
                        </select>
                    </td>
                </tr>
                <!-- 검색유형10 -->
                <tr class="_date">
                    <th class="sch_hd sch_hd1-1">
                        <div>Хүсч буй ажлын нөхцөл</div>
                    </th>
                    <td class="sch_td1 sch_td1-1" colspan="3">
                        <select name="wr_date">
                            <option value="">Ажиллах хугацаа</option>
                            <?php
                            if(is_array($_cate_['alba_date'])) { foreach($_cate_['alba_date'] as $k=>$v) {
                                $selected = $v['code']==$_GET['wr_date'] ? 'selected' : '';
			?>
			<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
			<?php
			} }
			?>
			</select>
			<select name="wr_week">
			<option value="">Ажлын өдөр</option>
			<?php
			if(is_array($_cate_['alba_week'])) { foreach($_cate_['alba_week'] as $k=>$v) {
				$selected = $v['code']==$_GET['wr_week'] ? 'selected' : '';
			?>
			<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
			<?php
			} }
			?>
			</select>
			<select name="wr_time" style="border-bottom:0">
			<option value="">Ажлын цаг</option>
			<?php
			if(is_array($_cate_['alba_time'])) { foreach($_cate_['alba_time'] as $k=>$v) {
				$selected = $v['code']==$_GET['wr_time'] ? 'selected' : '';
			?>
			<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
			<?php
			} }
			?>
			</select>
		</td>
	</tr>
	<!-- 검색어 입력 -->
	<tr>
		<th class="sch_hd" style="background:#fff;border-right:0">
			<div>Хайх</div>
		</th>
		<td class="sch_td2 sch_word" colspan="3" style="border-left:0;padding-right:5px">
			<input type="text" name="search_keyword" value="<?=$_GET['search_keyword'];?>" class="sch_in">
		</td>
	</tr>
	</table>
	</div>
	<div class="schbtn_con cf">
	<ul>
		<li class="search_bx sch_bt sch_bt2" style="width:100%">
			<button type="button" class="sch_button" onClick="document.forms['ftsearch'].submit()"><img src="<?=NFE_URL;?>/images/search_icon3.png" alt="검색">Хайх</button>
		</li>
	</ul>
	</div>
</div>
</form>