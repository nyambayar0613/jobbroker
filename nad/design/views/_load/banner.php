<?php
		/*
		* /application/nad/design/views/_load/banner.php
		* @author Harimao
		* @since 2013/06/18
		* @last update 2015/02/25
		* @Module v3.5 ( Alice ) - b1.0
		* @Brief :: Banner Get Info
		* @Comment :: 배너 정보를 읽어 들여 각 프로세스에 맞게 처리
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$no = $_POST['no'];
		$position = $_POST['position'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		switch($mode){
			
			## 입력
			case 'insert':		
				$positions = explode('_',$position);
				$menu_name = $banner_control->_position($positions[0], $position);
				$banner_group = $banner_control->_group($position);
				$cookie_arr = array('main_top','alba_top','resume_top','adult_top','individual_top','company_top','board_top','map_top','search_top','service_top','etc_login');	// 일간 보이지бы 않기 position 배열
?>
			<form name="BannerRegistFrm" method="post" id="BannerRegistFrm" action="./process/banner.php" enctype="multipart/form-data">
			<input type="hidden" name="mode" value="insert" id="mode"/><!-- 배너 등록 -->
			<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
			<input type="hidden" name="uid" value="<?php echo $admin_info['uid'];?>"/>
			<input type="hidden" name="position" value="<?php echo $position?>"/><!-- 배너 위치 -->
			<input type="hidden" name="type" id="type"/><!-- 배너 종류 -->

				<dl class="ntlt lnb_col m0 hand" id="addFrmHandle">
					<img src="../../images/comn/bul_10.png" class="t"><?php echo $menu_name['name'];?> Banner<label id='mode'>Бүртгүүлэх</label>
					<span>Дээд хэмжээ : <label id='limit_width'><?php echo $menu_name['width'];?>px (дээд )</label> * <label id='limit_height'><?php echo ($menu_name['height']=='제한없음')?'제한없음':$menu_name['height'].'px (최대)';?></label> </span>
					<a onClick="$('#add_form').hide();"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
				</dl>
				<table width="700" class="bg_col">
				<col width=80><col>
				<tr>
					<td class="ctlt">Banner group</td>
					<td class="pdlnb2">
						<select name="p_no" id="banner_group" option='select' hname="Banner group" onchange="banner_groups('<?php echo $position;?>',this);">
						<option value="">Group сонгох</option>
						<option value="self">Утга оруулах</option>
						<?php if($banner_group['banner_distinct']){ ?>
						<optgroup label="Group сонгох">
							<?php foreach($banner_group['banner_distinct'] as $_group) { ?>
							<option value="<?php echo $_group['p_no'];?>"><?php echo stripslashes($_group['g_name']);?></option>
							<?php } ?>
						</optgroup>
						<?php } ?>
						</select>
						<span id="group_display" style="display:none;"><input type="text" name="g_name" hname="Banner group" id="group_name" class="txt" style="width:40%" value="" placeholder="Group-н нэр оруулн уу."></span>
					</td>
				</tr>
				<tr>
					<td class="ctlt">Бүртгүүлэх арга</td>
					<td class="pdlnb2">
						<label><input name="type" type="radio" value="image" class="radio" checked onclick="banner_types(this);">Зураг оруулах</label> &nbsp; &nbsp;&nbsp;
						<label><input name="type" type="radio" value="self" class="radio" onclick="banner_types(this);">Утга шууд оруулах</label> &nbsp; &nbsp;&nbsp;
						<label><input name="type" type="radio" value="adsense" class="radio" onclick="banner_types(this);">Google adsense</label>
					</td>
				</tr>
				<?php if(@in_array($position,$cookie_arr)){ ?>
				<tr>
					<td class="ctlt">Харуулах хугацаа</td>
					<td class="pdlnb2">
                        <input name="cookie" type="text" class="tnum" size="3" value="<?php echo $get_banner['cookie'];?>"> Өдөр бүр үзэж болохгүй
                        <span class="subtlt">Хэрэв 0 хоног бол хэвлэх хугацааг асуухгүй.</span>
					</td>
				</tr>
				<?php } ?>
				<!-- 업로드 -->
				<tr id="bannerSize" class="image_upload">
					<td class="ctlt">Banner хэмжээ</td>
					<td class="pdlnb2">
						<span id="size_set_auto"><label><input name="size_set" type="radio" value="0" class="radio" checked onclick="size_sets(this);">Анхны зургийн хэмжээ</label> &nbsp;</span>
						<span id="size_set_user"><label><input name="size_set" type="radio" value="1" class="radio" onclick="size_sets(this);">Хэрэглэгчийн оруулсан хэмжээ</label> &nbsp;</span>
						<span id="size_set" style="display:none;">
						Хэвтээ <input name="width" type="text" class="tnum" size="3" value="<?php echo ($position=='main_pin_first')?'218':'';?>"> px ,
						Босоо <input name="height" type="text" class="tnum" size="3" value="<?php echo ($position=='main_pin_first')?'299':'';?>"> px
						</span>
					</td>
				</tr>
				<!-- <tr id="bannerRolling">
					<td class="ctlt">롤링시간</td>
					<td class="pdlnb2"><input name="rolling_time" type="text" class="tnum" style="width:120px;"> 초</td>
				</tr> -->
				<tr id="bannerLink" class="image_upload">
					<td class="ctlt">Холбох хаяг</td>
					<td class="pdlnb2">http://
						<input name="url" type="text" class="txt w50" style="ime-mode:inactive;">
						<--input name="target" type="checkbox" value="_blank" class="check" checked>Шинэ цоэх нээх
					</td>
				</tr>
				<tr id="bannerFile" class="image_upload">
					<td class="ctlt">Banner file</td>
					<td class="pdlnb2">
						<input name="upload" type="file" class="txt w50">
						<span class="subtlt"> *.jpg, *.gif, *.png, *.swf боломжтой</span>
					</td>
				</tr>
				<!-- 직접입력 -->
				<tr id="bannerSelfContent" style="display:none;">
					<td class="ctlt">Агуулга</td>
					<td class="pdlnb2">
					<?php echo $utility->make_cheditor('self_content', stripslashes($get_banner['content']));	// 에디터 생성?>
					</td>
				</tr>
				<tr id="bannerAdsenseContent" style="display:none;">
					<td class="ctlt">Агуулга</td>
					<td class="pdlnb2"><textarea name="adsense_content" class="bdtxt" style="height:300px" placeholder="구글애드센스 코드를 입력해 주세요."></textarea></td>
				</tr>
				</table>

				<dl class="pbtn">  
					<input type='image' src="../../images/btn/b23_01.png" class="ln_col">&nbsp;
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>
				</dl>

			</form>
<?php
			break;

			## 수정
			case 'update':

				$get_banner = $banner_control->get_banner($no);	// 배너 정보 추출
				$positions = explode('_',$get_banner['position']);
				$menu_name = $banner_control->_position($positions[0], $get_banner['position']);
				$banner_group = $banner_control->_group($position);

?>
			<form name="BannerRegistFrm" method="post" id="BannerRegistFrm" action="./process/banner.php" enctype="multipart/form-data">
			<input type="hidden" name="mode" value="<?php echo $mode;?>" id="mode"/><!-- 배너 수정 -->
			<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
			<input type="hidden" name="uid" value="<?php echo $admin_info['uid'];?>"/>
			<input type="hidden" name="position" value="<?php echo $position?>"/><!-- 배너 위치 -->
			<input type="hidden" name="type" id="type" value="<?php echo $get_banner['type'];?>"/><!-- 배너 종류 -->
			<input type="hidden" name="no" id="no" value="<?php echo $no?>"/><!-- 배너 고유 key -->

				<dl class="ntlt lnb_col m0 hand" id="addFrmHandle">
					<img src="../../images/comn/bul_10.png" class="t"><?php echo $menu_name['name'];?> Banner<label id='mode'>Өөрчлөх</label>
					<span>Хэмжээ : <label id='limit_width'><?php echo $menu_name['width'];?>px (дээд талдаа)</label> * <label id='limit_height'><?php echo ($menu_name['height']=='제한없음')?'제한없음':$menu_name['height'].'px (최대)';?></label> </span>
					<a onClick="$('#add_form').hide();"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
				</dl>
				<table width="700" class="bg_col">
				<col width=80><col>
				<tr>
					<td class="ctlt">Banner group</td>
					<td class="pdlnb2">
						<select name="p_no" id="banner_group" option='select' hname="Banner group" onchange="banner_groups('<?php echo $position;?>',this);"><!-- required -->
						<option value="">Group сонгох</option>
						<option value="self">Утга шууд оруулах</option>
						<?php if($banner_group['banner_distinct']){ ?>
						<optgroup label="Group сонгох">
							<?php foreach($banner_group['banner_distinct'] as $_group) { ?>
							<option value="<?php echo $_group['p_no'];?>" <?php echo ($_group['p_no']==$get_banner['p_no'])?'selected':'';?>><?php echo stripslashes($_group['g_name']);?></option>
							<?php } ?>
						</optgroup>
						<?php } ?>
						</select>
						<span id="group_display" style="display:none;"><input type="text" name="g_name" hname="Banner group" id="group_name" class="txt" style="width:40%" value="" placeholder="Group-н нэр оруулна уу."></span>
					</td>
				</tr>
				<tr>
					<td class="ctlt">Бүртгүүлэх арга</td>
					<td class="pdlnb2">
                        <label><input name="type" type="radio" value="image" class="radio" checked onclick="banner_types(this);">Зураг оруулах</label> &nbsp; &nbsp;&nbsp;
                        <label><input name="type" type="radio" value="self" class="radio" onclick="banner_types(this);">Утга шууд оруулах</label> &nbsp; &nbsp;&nbsp;
                        <label><input name="type" type="radio" value="adsense" class="radio" onclick="banner_types(this);">Google adsense</label>
					</td>
				</tr>
				<?php if($position=='main_top' || $position=='alba_top'){ ?>
				<tr>
					<td class="ctlt">Хэвлэх/харуулах хугацаа</td>
					<td class="pdlnb2">
						<input name="cookie" type="text" class="tnum" size="3" value="<?php echo $get_banner['cookie'];?>"> Өдөр бүр үзэж болохгүй
						<span class="subtlt">Хэрэв 0 хоног бол хэвлэх хугацааг асуухгүй.</span>
					</td>
				</tr>
				<?php } ?>
				<!-- 업로드 -->
				<tr id="bannerSize" class="image_upload" style="display:<?php echo ($get_banner['type']=='self')?'none':';';?>;">
					<td class="ctlt">Banner хэмжээ</td>
					<td class="pdlnb2">
                        <span id="size_set_auto"><label><input name="size_set" type="radio" value="0" class="radio" checked onclick="size_sets(this);">Анхны зургийн хэмжээ</label> &nbsp;</span>
                        <span id="size_set_user"><label><input name="size_set" type="radio" value="1" class="radio" onclick="size_sets(this);">Хэрэглэгчийн оруулсан хэмжээ</label> &nbsp;</span>
                        <span id="size_set" style="display:none;">
						Хэвтээ <input name="width" type="text" class="tnum" size="3" value="<?php echo ($position=='main_pin_first')?'218':'';?>"> px ,
						Босоо <input name="height" type="text" class="tnum" size="3" value="<?php echo ($position=='main_pin_first')?'299':'';?>"> px
						</span>
					</td>
				</tr>
				<tr id="bannerLink" class="image_upload" style="display:<?php echo ($get_banner['type']=='image')?'':'none;';?>;">
					<td class="ctlt">Холбох хаяг</td>
					<td class="pdlnb2">http://
						<input name="url" type="text" class="txt w50" style="ime-mode:inactive;" value="<?php echo $get_banner['url'];?>">
						<input name="target" type="checkbox" value="_blank" class="check" checked>Шинэ цонх нээх
					</td>
				</tr>
				<?php 
					if($get_banner['type']=='image'){ 
					$file_content = explode("/",$get_banner['content']);
				?>
				<tr>
					<td class="ctlt">Эх файл</td>
					<td class="pdlnb2">
						<a href="./download.php?banner_file=<?php echo $get_banner['content'];?>"><?php echo $file_content[1];?>
						<span class="subtlt">Эх файлыг татаж авахын тулд дарна уу</span>
					</td>
				</tr>
				<?php } ?>
				<tr id="bannerFile" class="image_upload" style="display:<?php echo ($get_banner['type']=='image')?'':'none;';?>;">
					<td class="ctlt">Banner файл</td>
					<td class="pdlnb2">
						<input name="upload" type="file" class="txt w50">
						<span class="subtlt"> *.jpg, *.gif, *.png, *.swf зөвхөн боломжтой</span>
					</td>
				</tr>
				<!-- 직접입력 -->
				<tr id="bannerSelfContent" style="display:<?php echo ($get_banner['type']=='self')?'':'none;';?>;">
					<td class="ctlt">Агуулга</td>
					<td class="pdlnb2">
					<?php echo $utility->make_cheditor('self_content', stripslashes($get_banner['content']));	// 에디터 생성?>
					</td>
				</tr>
				<tr id="bannerAdsenseContent" style="display:<?php echo ($get_banner['type']=='adsense')?'':'none;';?>;">
					<td class="ctlt">Агуулга</td>
					<td class="pdlnb2"><textarea name="adsense_content" class="bdtxt" style="height:300px"><?php echo stripslashes($get_banner['content']);?></textarea></td>
				</tr>
				</table>

				<dl class="pbtn">  
					<input type='image' src="../../images/btn/b23_01.png" class="ln_col">&nbsp;
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>
				</dl>

			</form>
<?php
			break;

		}	// switch end.
?>

<script>

</script>