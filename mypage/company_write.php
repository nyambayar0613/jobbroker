<?php
$editor_use = true;
$page_code = 'mypage';
include_once "../include/top.php";
include_once NFE_PATH."/engine/netfu_map.class.php";
$netfu_map = new netfu_map();

echo $netfu_map->js_script;

$use_map = $env['use_map'];	// 사용 지도 api
$daum_local_key = $env['daum_map_key'];	// 다음 지도 local 검색 key
$naver_map_key = $env['naver_map_key'];	// 네이버 지도 key

$category_list = $category_control->category_codeList('company_form', " `rank` asc ");

if($_GET['no'])
	$get_company = $member_control->get_company_memberNo($_GET['no']);	 // 기업 정보

$company_logo = $alba_user_control->get_logo($get_company);
$mb_biz_phone = explode('-', $get_company['mb_biz_phone']);
$mb_biz_hphone = explode('-', $get_company['mb_biz_hphone']);
$biz_fax = explode('-', $get_company['mb_biz_fax']);
$map_latlng = explode(',', $get_company['mb_latlng']);
//$mb_homepage = $get_company ? $get_company['mb_homepage'] : $member['mb_homepage'];
$mb_homepage = $get_company['mb_homepage'];
$mb_email = explode('@', $get_company['mb_biz_email']);	 // 이메일
$biz_no = explode('-', $get_company['mb_biz_no']);

$phone_num_option = $config->get_tel_num($mb_biz_phone[0]); // 전화번호
$hphone_num_option = $config->get_hp_num($mb_biz_hphone[0]); // 휴대폰 번호
$fax_num_option = $config->get_tel_num($biz_fax[0]);		// 팩스번호
$biz_type_option = $config->get_biz_type($get_company['mb_biz_type']); // 업종
$email_option = $config->get_email();		// 이메일
$biz_success_option = $config->get_biz_success($get_company['mb_biz_success']);	// 상장여부
$biz_form_option = $config->get_biz_form($get_company['mb_biz_form']);	// 기업형태

//NFE_URL.'/images/no-img.png';
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/map/<?=$use_map;?>.js?time=<?=time();?>"></script>
<form name="fwrite" action="../regist.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="company_write" />
<input type="hidden" name="no" value="<?=$_GET['no'];?>" />
<section class="cont_box add1_info">
<h2>Байгууллагын мэдээлэл нэмэх</h2>
	<ul class="info3_con">

		<li class="row1">
			<label for="logo_bx">Байгууллагын лого<span class="check"></span></label>
			<div class="logo_pic">
				<div class="logo_bx"><img src="<?=$company_logo;?>" alt="No Image"></div>
				<div class="bt_group">
					<div><input type="file" name="mb_logo" hname="Байгууллагын лого" onChange="netfu_util1.filesize_check(this, '100')"></div>
					<p>gif, jpg, png format, 135 × 65 пикселээс бага, 100кб-аас бага файлыг бүртгэх боломжтой.</p>
				</div>
			</div>
		</li>
		<li class="row3">
			<label for="company_name">Байгууллагын нэр<span class="check"></span></label>
			<input type="text" id="company_name" name="mb_company_name" value="<?php echo $get_company['mb_company_name'];?>" hname="Байгууллага/Jump нэр" required>
		</li>
		<li class="row2">
			<label for="ceo_name">Хариуцсан хүний нэр<span class="check"></span></label>
			<input type="text" id="ceo_name" name="mb_ceo_name" value="<?php echo $get_company['mb_ceo_name'];?>" hname="Хариуцсан хүний нэр" required>
		</li>
		<li class="row4">
			<label for="classify">Байгууллагын төрөл<span class="check"></span></label>
			<select id="classify" name="mb_biz_type" title="Байгууллагын төрөл сонгох" required hname="Байгууллагын төрөл" option="select">
				<option value="">Байгууллагын төрөл сонгох</option>
				<?php echo $biz_type_option; ?>
			</select>
		</li>
		<li class="row5">
			<fieldset>
				<legend>Холбогдох дугаар<span class="check"></span></legend>
				<select name="mb_biz_phone[]" title="Сонгох" required hname="Улсын дугаар">
					<?php echo $phone_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_phone[]" required hname="전화번호 앞자리" value="<?php echo $mb_biz_phone[1];?>" class="tel1 phone2">
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_phone[]" required hname="전화번호 뒷자리" value="<?php echo $mb_biz_phone[2];?>" class="tel2 ">
			</fieldset>
		</li>
		<li class="row6">
			<fieldset>
			<legend>Утасны дугаар</legend>
				<select name="mb_biz_hphone[]" title="Сонгох">
				<?php echo $hphone_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_hphone[]" hname="휴대폰 앞자리" value="<?php echo $mb_biz_hphone[1];?>" class="cel1 phone1">
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_hphone[]" hname="휴대폰 뒷자리" value="<?php echo $mb_biz_hphone[2];?>" class="cel2 ">
			</fieldset>
		</li>
		<li class="row7">
			<script type="text/javascript">
			var form = document.forms['fwrite'];
			</script>
			<?php
			$map_use = true;
			include NFE_PATH.'/include/inc/post.inc.php';
			?>
			<script type="text/javascript">
			daum_map.map_basic('address_map');
			daum_map.map_click(form);
			</script>
			<input type="hidden" name="map_latlng[]" value="<?=$map_latlng[0];?>" />
			<input type="hidden" name="map_latlng[]" value="<?=$map_latlng[1];?>" />
			<fieldset>
				<legend>Хаяг<span class="check"></span></legend>
				<input type="text" size="4" maxlength="4" id="mb_doro_post" name="mb_doro_post" readonly required hname="Гудамжны нэр" value="<?php echo $get_company['mb_biz_doro_post'];?>" class="post">
				<input type="text" maxlength="" name="mb_address0" id="mb_address0" required hname="Хаяг" value="<?php echo $get_company['mb_biz_address0'];?>"  class="address1">
				<button type="botton" class="form_bt form_bt2" onClick="post_click(); return false;">Шуудангын дугаар</button>
				<div class="cf">
				<input type="text" name="mb_address1" required hname="Дэлгэрэнгүй хаяг" value="<?php echo $get_company['mb_biz_address1'];?>" class="address2" placeholder="Дэлгэрэнгүй хаяг оруулна уу.">
				</div>
			</fieldset>
		</li>

		<?php
		if(is_array($category_list)) { foreach($category_list as $k=>$v) {
			if($v['view']=='no') continue; // : 사용안함
			$_check = $v['etc_0']==1 ? '<span class="check"></span>' : '';
			$_required = $v['etc_0']==1 ? 'required' : '';

			switch($v['name']) {
				case "Компанийн бүртгэлийн дугаар":
		?>
		<li class="row8">
			<fieldset>
				<legend>사업자번호<?=$_check;?></legend>
				<input type="text" name="mb_biz_no[]" hname="Компанийн бүртгэлийн дугаар" <?=$_required;?> value="<?=$biz_no[0];?>">
				<p>-</p>
				<input type="text" name="mb_biz_no[]" hname="Компанийн бүртгэлийн дугаар" <?=$_required;?> value="<?=$biz_no[1];?>">
				<p>-</p>
				<input type="text" name="mb_biz_no[]" hname="Компанийн бүртгэлийн дугаар" <?=$_required;?> value="<?=$biz_no[2];?>">
			</fieldset>
		</li>
		<?php
					break;



				case "Факсын дугаар":
		?>
		<li class="row9">
			<legend>Факсын дугаар<?=$_check;?></legend>
			<select name="mb_biz_fax[]" hname="Факсын дугаар">
			<?=$fax_num_option;?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_fax[]" hname="Факсын дугаар" <?=$_required;?> value="<?=$biz_fax[1];?>" class="fax1 phone2">
			<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_fax[]" hname="Факсын дугаар" <?=$_required;?> value="<?=$biz_fax[2];?>" class="fax2 ">
			</fieldset>
		</li>
		<?php
					break;



				case "Вэб сайт":
		?>
		<li class="row10">
			<label for="homepage">Вэб сайт<?=$_check;?></label>
			<span>http://</span><input type="text" name="mb_homepage" hname="Вэб сайт" <?=$_required;?> value="<?=$utility->remove_http($mb_homepage);?>" class="">
		</li>
		<?php
					break;




				case "И-мэйл":
		?>
		<li class="row11">
		<fieldset>
			<legend>И-мэйл<?=$_check;?></legend>
			<input type="text" name="mb_email[]" hname="И-мэйл" <?=$_required;?> value="<?=$mb_email[0];?>" class="email" hname="И-мэйл" >
			<p>@</p><input type="text" name="mb_email[]" hname="И-мэйл" value="<?=$mb_email[1];?>" id="mb_email_put" class="email" hname="И-мэйл" >
			<select onChange="netfu_util1.put_text(this, $('#mb_email_put'))">
			<option value="">мэйл</option>
			<?=$email_option;?>
			</select>
		</fieldset>
		</li>
		<?php
					break;



				case "Жагсаалтанд орсон эсэх":
		?>
		<li class="row12">
			<label for="listed">Жагсаалтанд орсон эсэх<?=$_check;?></label>
			<select id="listed" name="mb_biz_success" hname="Жагсаалтанд орсон эсэх" <?=$_required;?>>
				<option value="">Сонгох</option>
				<?=$biz_success_option;?>
			</select>
		</li>
		<?php
					break;




				case "Байгууллагын хэлбэр":
		?>
		<li class="row13">
			<label for="type">Байгууллагын хэлбэр<?=$_check;?></label>
			<select id="type" name="mb_biz_form" hname="Байгууллагын хэлбэр" <?=$_required;?>>
				<option value="">Сонгох</option>
				<?=$biz_form_option;?>
			</select>
		</li>
		<?php
					break;




				case "Бизнесийн үндсэн мэдээлэл":
		?>
		<li class="row14">
			<label for="business">Бизнесийн үндсэн мэдээлэл<?=$_check;?></label>
			<input type="text" id="business" name="mb_biz_content" hname="Бизнесийн үндсэн мэдээлэл" <?=$_required;?> value="<?=$get_company['mb_biz_content'];?>" />
		</li>
		<?php
					break;




				case "Байгуулагдсан он":
		?>
		<li class="row15">
			<label for="f_year">Байгуулагдсан он<?=$_check;?></label>
			<select id="f_year" name="mb_biz_foundation" hname="Байгуулагдсан он" <?=$_required;?>>
				<option value="">Сонгох</option>
				<?php
				$foundation_option = "";
				for($i=date('Y');$i>=1900;--$i){
					$selected = ($get_company['mb_biz_foundation']==$i) ? 'selected' : '';
					$foundation_option .= "<option value='".$i."' ".$selected.">".$i." жил</option>";
				}
				?>
				<?=$foundation_option;?>
			</select>
            Байгуулагдсан он
		</li>
		<?php
					break;




				case "Ажилчдын тоо":
		?>
		<li class="row16">
			<label for="employee">Ажилчдын тоо<?=$_check;?></label>
			<input type="text" id="employee" name="mb_biz_member_count" hname="Ажилчдын тоо" <?=$_required;?> value="<?=$get_company['mb_biz_member_count'];?>" hname="Ажилчдын тоо">хүн
		</li> 
		<?php
					break;




				case "Үндсэн хөрөнгө":
		?>
		<li class="row17">
			<label for="capital">Үндсэн хөрөнгө<?=$_check;?></label>
			<input type="text" id="capital" name="mb_biz_stock" hname="Үндсэн хөрөнгө" <?=$_required;?> value="<?=$get_company['mb_biz_stock'];?>" hname="Үндсэн хөрөнгө" />
		</li>
		<?php
					break;




				case "Ашиг":
		?>
		<li class="row18">
			<label for="sales">Ашиг<?=$_check;?></label>
			<input type="text" id="sales" name="mb_biz_sale" hname="Ашиг" <?=$_required;?> value="<?=$get_company['mb_biz_sale'];?>" hname="Ашиг">төгрөг
		</li> 
		<?php
					break;




				case "Компанийн тойм, алсын хараа":
		?>
		<li class="row19">
            Компанийн тойм, алсын хараа<?=$_check;?>
			<textarea type="editor" name="mb_biz_vision" rows="9" hname="Компанийн тойм, алсын хараа" <?=$_required;?>><?=stripslashes($get_company['mb_biz_vision']);?></textarea>
		</li> 
		<?php
					break;




				case "Компанийн түүх, гүйцэтгэл":
		?>
		<li class="row20">
            Компанийн түүх, гүйцэтгэл<?=$_check;?>
			<textarea type="editor" name="mb_biz_result" rows="9" hname="Компанийн түүх, гүйцэтгэл" <?=$_required;?>><?=stripslashes($get_company['mb_biz_result']);//$utility->make_cheditor('mb_biz_result',stripslashes($get_company['mb_biz_result']))?></textarea>
		</li> 
		<?php
					break;
			}
		?>
		<?php
		} }
		?>
	</ul>
</section>

<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="netfu_util1.ajax_submit(document.forms['fwrite'])">Хадгалах</a><a href="#none;" onClick="document.forms['fwrite'].reset()" class="bottom_btn02">Цуцлах</a>
</div>
</form>

<?php
include "../include/tail.php";
?>