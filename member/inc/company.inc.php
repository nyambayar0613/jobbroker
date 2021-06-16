<?php
// : 실명인증해서 넘어간 값은 _core.php에 합니다.

$_cate_['biz_type'] = $netfu_util->get_cate_array('biz_type', array('where'=>" and `p_code` = ''"));
$_cate_['biz_success'] = $netfu_util->get_cate_array('biz_success', array('where'=>" and `p_code` = ''"));
$_cate_['biz_form'] = $netfu_util->get_cate_array('biz_form', array('where'=>" and `p_code` = ''"));

include_once NFE_PATH."/engine/netfu_map.class.php";
$netfu_map = new netfu_map();

echo $netfu_map->js_script;

$_html = $netfu_util->input_htmlspecialchars($member);
$_html_c = $netfu_util->input_htmlspecialchars($member_com);
$_map_latlng = explode(",", $member_com['mb_latlng']);
$_mb_biz_no = explode("-", $member_com['mb_biz_no']);

$_mb_phone = explode("-", $member['mb_phone']);
$_mb_hphone = explode("-", $_mb_hphone);
$_mb_biz_fax = explode("-", $member_com['mb_biz_fax']);

$use_map = $env['use_map'];	// 사용 지도 api
$daum_local_key = $env['daum_map_key'];	// 다음 지도 local 검색 key
$naver_map_key = $env['naver_map_key'];	// 네이버 지도 key

$_GET['kind'] = $_GET['kind'] ? $_GET['kind'] : 'company';


$category_list = $category_control->category_codeList('company_form', " `rank` asc ");
?>

<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/map/<?=$use_map;?>.js?time=<?=time();?>"></script>
<style>
.info2_con .row9 .smschk{clear:both;height:32px;line-height:32px;padding-left:23%;color:#666}
.info2_con .row9 .smschk input{margin-top:9px;width:20px;margin-right:5px;}
.info2_con .row17 .smschk{clear:both;height:32px;line-height:32px;padding-left:23%;color:#666}
.info2_con .row17 .smschk input{margin-top:9px;width:20px;margin-right:5px;}
</style>
<section class="cont_box join_con">
	<ul class="info2_con">
		<?php
		if(!$member['mb_id']) {
		?>
		<li class="row1">
			<label for="member_id">ID<span class="check"></span></label>
			<input type="text" id="member_id" name="mb_id" maxlength="41">
			<input type="hidden" name="member_check" id="member_check" value="" message="ID-гаа давхар шалгана уу." required nofocus style="display:none;" />
			<button type="button" class="form_bt" onClick="netfu_member.dupl_mid($('#member_id').val())">Давхар шалгалт</button>
		</li>
		<?php }?>

		<?php
		if(!$member['mb_id']) {
		?>
		<li class="row2">
			<label for="pw">Нууц үг<span class="check"></span></label>
			<input type="password" id="pw" name="mb_password" hname="Нууц үг" required maxlength="16">
		</li>
		<li class="row3">
			<label for="pw2">Нууц үг батлах<span class="check"></span></label>
			<input type="password" id="pw2" name="mb_password_re" hname="Нууц үг батлах" required maxlength="16">
		</li>
		<?php }?>
		<li class="row4">
			<label for="name2">Нэвтрэх нэр<span class="check"></span></label>
			<?php
			if($member['mb_id'] || $_SESSION['certify_info']) {
				echo $_mb_name;
				if($_member_write_input_view) {
				?>
				<input type="hidden" id="name2" name="mb_name" value="<?=$_mb_name;?>" hname="Нэвтрэх нэр" required maxlength="41">
				<?php
				}
			} else {
			?>
			<input type="text" id="name2" name="mb_name" value="<?=$_html['mb_name'];?>" hname="Нэвтрэх нэр" required maxlength="41">
			<?php }?>
		</li>
		<li class="row5">
			<label for="ceo">Хариуцсан хүн<span class="check"></span></label>
			<input type="text" name="mb_ceo_name" value="<?=$_html_c['mb_ceo_name'];?>" hname="Хариуцсан хүн" required maxlength="41">
		</li>
		<li class="row6">
			<label for="nickname">Nickname<span class="check"></span></label>
			<input type="text" id="nickname" name="mb_nick" value="<?=$_html['mb_nick'];?>" hname="Nickname" required maxlength="41">
			<input type="hidden" name="nick_check" id="nick_check" value="<?=$member['mb_id'] ? 1 : '';?>" message="Nickname ээ шалгана уу." required nofocus style="display:none;" />
			<button type="button" class="form_bt" onClick="netfu_member.dupl_nick($('#nickname').val())">Давхар шалгалт</button>
		</li>
		<li class="row7">
			<label for="company">Албан байгууллагын нэр<span class="check"></span></label>
			<input type="text" id="company" name="mb_company_name" hname="Албан байгууллагын нэр" required value="<?=$_html_c['mb_company_name'];?>" maxlength="41">
		</li>
		<li class="row8">
			<label for="co_type">Байгууллагын төрөл<span class="check"></span></label>
			<select name="mb_biz_type" id="co_type" hname="Байгууллагын төрөл" required>
				<option value="">Сонгох</option>
				<?php
				if(is_array($_cate_['biz_type'])) { foreach($_cate_['biz_type'] as $k=>$v) {
					$selected = $member_com['mb_biz_type']==$v['code'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
			</select>
		</li>
		<li class="row9" style="height:auto">
			<label for="phone1">Утсаны дугаар</label>
			<?php
			if($_member_write_input_view) {
				echo @implode(" - ", $_mb_hphone);
				?>
				<input type="hidden" name="mb_hphone[]" value="<?=$_mb_hphone[0];?>" />
				<input type="hidden" name="mb_hphone[]" value="<?=$_mb_hphone[1];?>" />
				<input type="hidden" name="mb_hphone[]" value="<?=$_mb_hphone[2];?>" />
				<?php
			} else {?>
			<select name="mb_hphone[]">
				<?php echo $hp_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone1" name="mb_hphone[]" value="<?=$_mb_hphone[1];?>" class="phone1">
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone1" name="mb_hphone[]" value="<?=$_mb_hphone[2];?>">
			<?php }?>
			<div class="receive smschk"><input type="checkbox" name="mb_receive[]" value="sms" checked="checked">Хүний нөөцийн мэдээлэл / анкеттай холбоотой мэдээлэл авах</div>
		</li>
		<li class="row10">
			<label for="phone2">Холбогдох дугаар<span class="check"></span></label>
			<select name="mb_phone[]" hname="Холбогдох дугаар" required>
				<?php echo $tel_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="mb_phone[]" hname="Холбогдох дугаар" required value="<?=$_mb_phone[1];?>" class="phone2">
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="mb_phone[]" hname="Холбогдох дугаар" required value="<?=$_mb_phone[2];?>">
		</li>
		<li class="row11">
			<script type="text/javascript">
			var form = document.forms['fmember'];
			</script>
			<?php
			$map_use = true;
			include NFE_PATH.'/include/inc/post.inc.php';
			?>
			<script type="text/javascript">
			daum_map.map_basic('address_map');
			daum_map.map_click(form);
			</script>
			<input type="hidden" name="map_latlng[]" value="<?=$_map_latlng[0];?>" />
			<input type="hidden" name="map_latlng[]" value="<?=$_map_latlng[1];?>" />
			<label for="address">Хаяг<span class="check"></span></label>
			<input type="text" size="4" maxlength="4" id="mb_doro_post" hname="Шуудангын дугаар" required name="mb_doro_post" value="<?=$_html['mb_address_road'];?>" class="post">
			<input type="hidden" name="mb_zipcode[]" /><input type="hidden" name="mb_zipcode[]" />
			<input type="text" maxlength="" id="mb_address0" name="mb_address0" hname="Хаяг" required  class="address1" value="<?=$_html['mb_address0'];?>">
			<button type="botton" class="form_bt form_bt2" onClick="post_click(); return false;">Шуудангын дугаар</button>
			<div class="cf">
			 <input type="text" id="address" name="mb_address1" hname="Дэлгэрэнгүй хаяг" value="<?=$_html['mb_address1'];?>" class="address2" placeholder="Дэлгэрэнгүй хаяг оруулна уу.">
			</div>
		</li>
		<li class="row12">
			<label>Лого</label>
			<div class="logo_pic">
				<div class="logo_bx"><img src="<?=$member['mb_id'] ? $mb_logo : NFE_URL.'/images/no-img.png';?>" alt="No Image"></div>
				<div class="bt_group">
					<span><input type="file" name="logo" onChange="netfu_util1.filesize_check(this, '<?=$netfu_mjob->logo_size;?>')"></span>
					<p>Gif, jpg, png форматтай 130 × 72 пикселээс бага, 100кб-аас бага файлыг бүртгүүлэх боломжтой.</p>
				</div>
			</div>
		</li>



		<?php
		if(is_array($category_list)) { foreach($category_list as $k=>$v) {

			if($v['view']=='no') continue; // : 사용안함
			$_check = $v['etc_0']==1 ? '<span class="check"></span>' : '';
			$_required = $v['etc_0']==1 ? 'required' : '';

			switch($v['name']) {
				case "Компанийн бүртгэлийн дугаар":
		?>
		<li class="row13">
			<label class="biz_num">Компанийн бүртгэлийн дугаар<?=$_check;?></label>
			<input type="text" name="mb_biz_no[]" hname="Компанийн бүртгэлийн дугаар" <?=$_required;?> value="<?=$_mb_biz_no[0];?>">
			<p>-</p>
			<input type="text" name="mb_biz_no[]" hname="Компанийн бүртгэлийн дугаар" <?=$_required;?> value="<?=$_mb_biz_no[1];?>">
			<p>-</p>
			<input type="text" name="mb_biz_no[]" hname="Компанийн бүртгэлийн дугаар" <?=$_required;?> value="<?=$_mb_biz_no[2];?>">
		</li>
		<li class="row12">
			<label>Компанийн бүртгэлийн дугаар</label>
			<div class="logo_pic">
				<div class="bt_group">
					<input type="file" name="com_num_photo" style="width:100%">
				</div>
			</div>
		</li>
		<?php
					break;


				case "Шуудангын дугаар":
		?>
		<li class="row15">
			<label for="phone2">Шуудангын дугаар<?=$_check;?></label>
			<select name="mb_biz_fax[]" hname="Шуудангын дугаар" <?=$_required;?>>
				<?php echo $fax_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="mb_biz_fax[]" <?=$_required;?> hname="Шуудангын дугаар" class="phone2" value="<?=$_mb_biz_fax[1];?>">
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="mb_biz_fax[]" <?=$_required;?> hname="Шуудангын дугаар" value="<?=$_mb_biz_fax[2];?>">
		</li>
		<?php
					break;


				case "Вэб сайт":
		?>
		<li class="row16">
			<label for="homepage">Вэб сайт<?=$_check;?></label>
			<span>http://</span><input type="text" name="mb_homepage" hname="Вэб сайт" <?=$_required;?> value="<?=$_html_c['mb_homepage'];?>" class="">
		</li>
		<?php
					break;


				case "И-мэйл":
		?>
		<li class="row17" style="height:auto">
			<label for="email">И-мэйл<?=$_check;?></label>
			<input type="text" id="email" name="mb_email[]" hname="И-мэйл" <?=$_required;?> value="<?=$mb_email[0];?>" class="email">
			<p>@</p><input type="tel" name="mb_email[]" hname="И-мэйл" <?=$_required;?> value="<?=$mb_email[1];?>" id="mb_email_put" class="email">
			<select onChange="netfu_util1.put_text(this, $('#mb_email_put'))" style="margin:0">
				<option value="">Шууд оруулах</option>
				<?php echo $email_option; ?>
			</select>
			<div class="receive smschk"><input type="checkbox" name="mb_receive[]" value="email" checked="checked">Хүний нөөцийн мэдээлэл гэх мэт имэйл хүлээн авах</div>
		</li>
		<?php
					break;


				case "Жагсаалтанд орсон эсэх":
		?>
		<li class="row18">
			<label for="listed">Жагсаалтанд орсон эсэх<?=$_check;?></label>
			<select id="listed" name="mb_biz_success" hname="Жагсаалтанд орсон эсэх" <?=$_required;?>>
				<option value="">Жагсаалтанд орсон эсэх сонгох</option>
				<?php
				if(is_array($_cate_['biz_success'])) { foreach($_cate_['biz_success'] as $k=>$v) {
					$selected = $member_com['mb_biz_success']==$v['code'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
			</select>
		</li>
		<?php
					break;


				case "Байгууллагын төрөл":
		?>
		<li class="row19">
			<label for="co_type2">Байгууллагын төрөл<?=$_check;?></label>
			<select id="co_type2" name="mb_biz_form" hname="Байгууллагын төрөл" <?=$_required;?>>
				<option value="">Байгууллагын төрөл сонгох</option>
				<?php
				if(is_array($_cate_['biz_form'])) { foreach($_cate_['biz_form'] as $k=>$v) {
					$selected = $member_com['mb_biz_form']==$v['code'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
			</select>
		</li>
		<?php
					break;


				case "Бизнесийн үндсэн мэдээлэл":
		?>
		<li class="row20">
			<label for="business">Бизнесийн үндсэн мэдээлэл<?=$_check;?></label>
			<input type="text" id="business" name="mb_biz_content" hname="Бизнесийн үндсэн мэдээлэл" <?=$_required;?> value="<?=$_html_c['mb_biz_content'];?>" maxlength="">
			<div>(Жишээ нь: Сүлжээний траффикийн менежментийн бүтээгдэхүүний боловсруулалт, борлуулалт)</div>
		</li>
		<?php
					break;


				case "Байгуулагдсан он":
		?>
		<li class="row21">
			<label for="year">Байгуулагдсан он<?=$_check;?></label>
			<select id="year" name="mb_biz_foundation" hname="Байгуулагдсан он" <?=$_required;?>>
				<option value="">сонгох</option>
				<?php
				for($i=date('Y');$i>=1900;--$i){
					$selected = $member_com['mb_biz_foundation']==$i ? 'selected' : '';
				?>
				<option value="<?=$i;?>" <?=$selected;?>><?=$i;?>жил</option>
				<?php
				}
				?>
			</select>
		</li>
		<?php
					break;


				case "Ажилчдын тоо":
		?>
		<li class="row22">
			<label for="employee">Ажилчдын тоо<?=$_check;?></label>
			<input type="text" id="employee" name="mb_biz_member_count" hname="Ажилчдын тоо" <?=$_required;?> value="<?=$_html_c['mb_biz_member_count'];?>" maxlength="">хүн
		</li>
		<?php
					break;


				case "Үндсэн хөрөнгө":
		?>
		<li class="row23">
			<label for="capital">Үндсэн хөрөнгө<?=$_check;?></label>
			<input type="text" id="capital" name="mb_biz_stock" hname="Үндсэн хөрөнгө" <?=$_required;?> value="<?=$_html_c['mb_biz_stock'];?>" maxlength="">төгрөг
		</li>
		<?php
					break;


				case "Ашиг орлого":
		?>
		<li class="row24">
			<label for="sales">Ашиг орлого<?=$_check;?></label>
			<input type="text" id="sales" name="mb_biz_sale" hname="Ашиг орлого" <?=$_required;?> value="<?=$_html_c['mb_biz_sale'];?>" maxlength="">төгрөг
		</li>
		<?php
					break;


				case "Байгууллагын тухай":
		?>
		<li class="row25">
			<span>Байгууллагын тухай<?=$_check;?></span>
			<textarea type="editor" name="mb_biz_vision" style="width:100%;height:250px;" hname="Байгууллагын тухай" <?=$_required;?>><?=stripslashes($member_com['mb_biz_vision']);?></textarea>
		</li>
		<?php
					break;


				case "Компанийн түүх, гүйцэтгэл":
		?>
		<li class="row26">
			<span>Компанийн түүх, гүйцэтгэл<?=$_check;?></span>
			<textarea type="editor" name="mb_biz_result" style="width:100%;height:250px;"  hname="Компанийн түүх, гүйцэтгэл" <?=$_required;?>><?=stripslashes($member_com['mb_biz_result']);?></textarea>
		</li>
		<?php
					break;
			}
		} }
		?>


		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	</ul>
</section>