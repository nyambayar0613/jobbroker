<?php
		/*
		* /application/nad/design/views/_load/popup.php
		* @author Harimao
		* @since 2013/06/12
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Popup Get Info
		* @Comment :: 팝업 정보를 읽어 들여 각 프로세스에 맞게 처리
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];

		switch($mode){
			
			## 팝업 스킨 등록
			case 'skin_insert':
?>
				<form name="PopupSkinRegistFrm" method="post" id="PopupSkinRegistFrm" action="./process/popup.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="skin_insert" id="mode"/><!-- 팝업 스킨 등록 -->
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="uid" value="<?php echo $admin_info['uid'];?>"/>

					<dl class="ntlt lnb_col m0 hand" id="addFrmHandle"><img src="../../images/comn/bul_10.png" class="t">POPUP skin бүртгэх
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a></dl>
					<table width="700" class="bg_col">
					<col width=80><col>
					  <tr>
						<td class="ctlt">POPUP skin name</td>
						<td class="pdlnb2">
							<input name="skin_name" type="text" class="txt w50" required hname='POPUP skin name' maxbyte='40'>
							<span class="subtlt">40byte дотор</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">POPUP гарчгийн өнгө</td>
						<td class="pdlnb2">
							<span id="subject_colorSet">
								<select name="subject_color" id="subject_color"><?php echo $utility->gwsc();?></select>
							</span>&nbsp;
							<span class="subtlt">Попап цонхны гарчгийн өнгийг тодорхойлно. (Хэрэв background нь хар өнгөтэй байвал түүнийг цагаан болгож тохируулахыг зөвлөж байна)</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">Layout</td>
						<td class="pdlnb2">
                            border хэмжээ <input name="border_size" type="text" class="tnum" size="2" value="1" id="border_size"> px ,
							border өнгө
							<span id="border_colorSet">
								<select name="border_color" id="border_color"><?php echo $utility->gwsc();?></select>
							</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">background image</td>
						<td class="pdlnb2">
							<input name="bgimage_file" type="file" class="txt w50" id="bgimage_file">
							<input name="bgimage_file_tmp" type="hidden" id="bgimage_file_tmp">
							<select name="bgimage_pattern">
								<option value="no-repeat">давталт байхгүй</option>
								<option value="repeat">давтах</option>
								<option value="repeat-x">хэвтээ давталт</option>
								<option value="repeat-y">босоо давталт</option>
							</select>
							<select name="bgimage_position">
								<option value="">Background зургаа сонгоно уу</option>
                                <option value = "дээд зүүн"> зүүн дээд хэсэг </option>
                                <option value = "top center"> дээд төв </option>
                                <option value = "top right"> баруун дээд хэсэг </option>
                                <option value = "center left"> зүүн төв </option>
                                <option value = "center center"> Center </option>
                                <option value = "center right"> center right </option>
                                <option value = "bottom left"> Доод зүүн </option>
                                <option value = "bottom center"> Доод төв </option>
                                <option value = "баруун доод"> баруун доод хэсэг </option>
							</select>
						</dl>
						</td>
					  </tr>  
					  <tr> 
						<td class="ctlt">Cookie check хэвлэлт</td>
						<td class="pdlnb2">
							<label>
								<select name="cookie_time">
                                    <option value = "1 day"> 1 өдөр </option>
                                    <option value = "3 day"> 3 өдөр </option>
                                    <option value = "5 day"> 5 өдөр </option>
                                    <option value = "1 week"> 1 долоо хоног </option>
                                    <option value = "1 month"> 1 сар </option>
                                    <option value = "24 hour"> 24 цаг </option>
                                    <option value = "18 hour"> 18 цаг </option>
                                    <option value = "12 hour"> 12 цаг </option>
                                    <option value = "6 hour"> 6 цаг </option>
                                    <option value = "3 hour"> 3 цаг </option>
                                    <option value = "1 hour"> 1 цаг </option>
								</select>
								&nbsp;Ашиглаж байхдаа бүү нээгээрэй
							</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">Урьдчилан харах</td>
						<td class="pdlnb2">
						<dl class="mb5"><a onClick="popup_skin_replace();" class="btn pdlr5"><h1 class="btn23"><span class="ic" style="background-image:url(../../images/ic/ref.gif)"></span>Урьдчилан харах шинээх засах</h1></a></dl>
						<dl id="skinPreview">
						  <table width="100%" height="200" style="border:1px solid #000000;background:#000000">
							<tr>
							  <td class="pcontents" style="text-align:center;">{агуулга}</td>
							</tr>
							<tr>
							  <td class="pclose"><dl><a href="#">Өдрийн турш нээхгүй байх</a>
									<span class="wbar"><a href="#">close<b class="pl2">x</b></a></span></dl>
							  </td>
							</tr>
						  </table>
						</dl>
						</td>
					  </tr>
					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_01.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>

<?
			break;

			## 팝업 스킨 수정
			case 'skin_update':

				$popup_skin = $popup_control->get_popupSkin($no);	// 팝업 스킨 정보 추출
				$background = "";
				if($popup_skin['bgimage_file']){	// 배경 이미지를 업로드 했다면
					$background .= "background:";
					$background .= "url('../../".$alice['data']."/popup/".$popup_skin['bgimage_file']."') ".$popup_skin['bgimage_pattern']." ".$popup_skin['bgimage_position'];
					$background .= " #".$popup_skin['border_color'];
				} else {
					$background .= "background:#fff";
				}
				
?>
				<form name="PopupSkinRegistFrm" method="post" id="PopupSkinRegistFrm" action="./process/popup.php" enctype="multipart/form-data" onsubmit="return validate(this);">
				<input type="hidden" name="mode" value="skin_update" id="mode"/><!-- 팝업 스킨 수정 -->
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="uid" value="<?php echo $admin_info['uid'];?>"/>
				<input type="hidden" name="no" value="<?php echo $no;?>"/>

					<dl class="ntlt lnb_col m0 hand" id="addFrmHandle"><img src="../../images/comn/bul_10.png" class="t">POPUP skin тохиргоо
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a></dl>
					<table width="700" class="bg_col">
					<col width=80><col>
					  <tr>
						<td class="ctlt">POPUP skin нэр</td>
						<td class="pdlnb2"><input name="skin_name" type="text" class="txt w50" required hname='POPUP skin нэр' maxbyte='40' value="<?php echo stripslashes($popup_skin['skin_name']);;?>">
						<span class="subtlt">40byte дотор</span></td>
					  </tr>
					  <tr>
                          <td class="ctlt">POPUP гарчгийн өнгө</td>
                          <td class="pdlnb2">
							<span id="subject_colorSet">
								<select name="subject_color" id="subject_color"><?php echo $utility->gwsc();?></select>
							</span>&nbsp;
                              <span class="subtlt">Попап цонхны гарчгийн өнгийг тодорхойлно. (Хэрэв background нь хар өнгөтэй байвал түүнийг цагаан болгож тохируулахыг зөвлөж байна)</span>
						</td>
					  </tr>
					  <tr>
                          <td class="ctlt">Layout</td>
                          <td class="pdlnb2">
                              border хэмжээ <input name="border_size" type="text" class="tnum" size="2" value="1" id="border_size"> px ,
                              border өнгө
							<span id="border_colorSet">
								<select name="border_color" id="border_color"><?php echo $utility->gwsc($popup_skin['border_color']);?></select>
							</span>
						</td>
					  </tr>
					  <tr>
                          <td class="ctlt">background image</td>
						<td class="pdlnb2">
							<input name="bgimage_file" type="file" class="txt w50" id="bgimage_file">
							<input name="bgimage_file_tmp" type="hidden" id="bgimage_file_tmp">
							<select name="bgimage_pattern">
								<option value="no-repeat" <?php echo ($popup_skin['bgimage_pattern']=='no-repeat')?'selected':'';?>>давталт байхгүй</option>
								<option value="repeat" <?php echo ($popup_skin['bgimage_pattern']=='repeat')?'selected':'';?>>давтах</option>
								<option value="repeat-x" <?php echo ($popup_skin['bgimage_pattern']=='repeat-x')?'selected':'';?>>хэвтээ давталт</option>
								<option value="repeat-y" <?php echo ($popup_skin['bgimage_pattern']=='repeat-y')?'selected':'';?>>босоо давталт</option>
							</select>
							<select name="bgimage_position">
                                <option value="">Background зургаа сонгоно уу</option>
								<option value="top left" <?php echo ($popup_skin['bgimage_position']=='top left')?'selected':'';?>>зүүн дээд хэсэг</option>
								<option value="top center" <?php echo ($popup_skin['bgimage_position']=='top center')?'selected':'';?>> дээд </option>
								<option value="top right" <?php echo ($popup_skin['bgimage_position']=='top right')?'selected':'';?>>баруун дээд</option>
								<option value="center left" <?php echo ($popup_skin['bgimage_position']=='center left')?'selected':'';?>>дунд зүүн</option>
								<option value="center center" <?php echo ($popup_skin['bgimage_position']=='center center')?'selected':'';?>>дунд нь</option>
								<option value="center right" <?php echo ($popup_skin['bgimage_position']=='center right')?'selected':'';?>>баруун дунд</option>
								<option value="bottom left" <?php echo ($popup_skin['bgimage_position']=='bottom left')?'selected':'';?>>зүүн доод</option>
								<option value="bottom center" <?php echo ($popup_skin['bgimage_position']=='bottom center')?'selected':'';?>>доод дунд</option>
								<option value="bottom right" <?php echo ($popup_skin['bgimage_position']=='bottom right')?'selected':'';?>>баруун доод</option>
							</select>
						</dl>
						</td>
					  </tr>  
					  <tr> 
						<td class="ctlt">Cookie check хэвлэх</td>
						<td class="pdlnb2">
							<label>
								<select name="cookie_time">
									<option value="1 day" <?php echo ($popup_skin['cookie_time']=='1 day')?'selected':'';?>>1өдөр</option>
									<option value="3 day" <?php echo ($popup_skin['cookie_time']=='3 day')?'selected':'';?>>3өдөр</option>
									<option value="5 day" <?php echo ($popup_skin['cookie_time']=='5 day')?'selected':'';?>>5өдөр</option>
									<option value="1 week" <?php echo ($popup_skin['cookie_time']=='1 week')?'selected':'';?>>1долоо хоног</option>
									<option value="1 month" <?php echo ($popup_skin['cookie_time']=='1 month')?'selected':'';?>>1сар</option>
									<option value="24 hour" <?php echo ($popup_skin['cookie_time']=='24 hour')?'selected':'';?>>24цаг</option>
									<option value="18 hour" <?php echo ($popup_skin['cookie_time']=='18 hour')?'selected':'';?>>18цаг</option>
									<option value="12 hour" <?php echo ($popup_skin['cookie_time']=='12 hour')?'selected':'';?>>12цаг</option>
									<option value="6 hour" <?php echo ($popup_skin['cookie_time']=='6 hour')?'selected':'';?>>6цаг</option>
									<option value="3 hour" <?php echo ($popup_skin['cookie_time']=='3 hour')?'selected':'';?>>3цаг</option>
									<option value="1 hour" <?php echo ($popup_skin['cookie_time']=='1 hour')?'selected':'';?>>1цаг</option>
								</select>
								&nbsp;Өдрийн турш нээхгүй байх
							</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">Урьдчилан харах</td>
						<td class="pdlnb2">
						<dl class="mb5"><a onClick="previewReload();" class="btn pdlr5"><h1 class="btn23"><span class="ic" style="background-image:url(../../images/ic/ref.gif)"></span>Урьдчилан харахыг өөрчлөх</h1></a></dl>
						<dl id="skinPreview">
							<table width="100%" height="200" style="border:<?php echo $popup_skin['border_size'];?>px solid #<?php echo $popup_skin['border_color'];?>;background:#<?php echo $popup_skin['border_color'];?>;">
							<tr>
								<td class="pcontents" style="<?php echo $background;?>;text-align:center;">{Агуулга}</td>
							</tr>
							<tr>
								<td class="pclose">
								<dl>
									<input name="" type="checkbox" value="" class="check"><?php echo strtr($popup_skin['cookie_time'],$popup_control->cookie_arr);?> нээхгүй байх
									<span class="bar"><a href="#">close<b class="pl2">x</b></a></span>
								</dl>
								</td>
							</tr>
							</table>
						</dl>
						</td>
					  </tr>
					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_03.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>&nbsp;
						<a onClick="delete_popSkin('<?php echo $no;?>');"><img src="../../images/btn/23_06.gif"></a>
					</dl>

				</form>
<?
			break;

			## 팝업등록
			case 'insert':
				
				$popup_skin = $popup_control->__PopupSkinList(); // 팝업 스킨

?>
				<form name="PopupRegistFrm" method="post" id="PopupRegistFrm" action="./process/popup.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="insert" id="mode"/><!-- 팝업 등록 -->
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="uid" value="<?php echo $admin_info['uid'];?>"/>

					<dl class="ntlt lnb_col m0 hand" id="addFrmHandle">
					<img src="../../images/comn/bul_10.png" class="t">POPUP бүртгэл
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a></dl>
					<table width="750" class="bg_col">
					<col width=110><col>
					  <tr>
						<td class="ctlt">POPUP skin</td>
						<td class="pdlnb2">
							<select name="popup_skin">
								<?php 
									if($popup_skin['result']){
									foreach($popup_skin['result'] as $skins){
								?>
								<option value='<?php echo $skins['no'];?>'><?php echo $skins['skin_name'];?></option>
								<?php 
									} // foreach end. 
									} else {
								?>
								<option value=''>POPUP skin байхгүй байна.</option>
								<?php } ?>
							</select>
							<?php if(!$popup_skin['result']){?><span class="subtlt"><a href='./pop_skin.php'>POPUP skin эхлээд сонгоно уу.</a></span><?php } ?>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">POPUP гарчиг</td>
						<td class="pdlnb2">
							<input name="popup_title" type="text" class="txt w50" required hname='POPUP гарчиг' maxbyte='40'> &nbsp;
							<label><input name="popup_title_view" type="checkbox" value="1" class="check" checked>хэвлэх</label>
							<span class="subtlt">Хэвлэх үед гарч ирэх цонхны гарчгыг харуулна (20 тэмдэгт хүртэл))</span>
						</td>
					  </tr>
					  <!--
					  <tr>
						<td class="ctlt">출력타입</td>
						<td class="pdlnb2">
							<label><input name="popup_type" type="radio" value="1" class="radio" checked>레이어</label> &nbsp; &nbsp; &nbsp;&nbsp;
							<label><input name="popup_type" type="radio" value="0" class="radio">팝업(새창)</label>  &nbsp;
						</td>
					  </tr>
					  -->
					  <input type="hidden" name="popup_type" value="1">
					  <tr>
						<td class="ctlt">Хэвлэх эсэх</td>
						<td class="pdlnb2">
							<label><input name="popup_view" type="radio" value="1" class="radio" checked>Хэвлэнэ</label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<label><input name="popup_view" type="radio" value="0" class="radio">Хэвлэхгүй</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">Subpage хэвлэх эсэх</td>
						<td class="pdlnb2">
							<label><input name="popup_sub_view" type="radio" value="1" class="radio" checked>Хэвлэнэ</label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<label><input name="popup_sub_view" type="radio" value="0" class="radio">Хэвлэхгүй</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">POPUP хэмжээ</td>
						<td class="pdlnb2">
                            хэвтээ <input name="popup_width" type="text" class="tnum" size="3" value="0"> px ,
							босоо <input name="popup_height" type="text" class="tnum" size="3" value="0"> px
							<span class="subtlt">хэмжээ нь үйлдлийн системээс хамаарч өөр өөр байж болно.</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">POPUP байршил</td>
						<td class="pdlnb2">
                            Топ <input name="popup_top" type="text" class="tnum" size="3" value="0"> px ,
							Зүүн <input name="popup_left" type="text" class="tnum" size="3" value="0"> px
							<span class="subtlt">Шинэ цонх ашиглах үед хөтөчийн зүүн дээд булан нь 0,0 бөгөөд layer ашиглах үед вэб хуудаснаас эхлэн тооцно.</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">Хэвлэх хугацаа</td>
						<td class="pdlnb2">
							Эхлэх огноо <input name="popup_begin" type="text" class="tday" id="popup_begin" readonly style="width:125px;" value="">
                            Дуусах огноо <input name="popup_end" type="text" class="tday" id="popup_end" readonly style="width:125px;" value="">
							<input name="popup_unlimit" type="checkbox" value="1" class="check">no limit
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">Агуулга</td>
						<td class="pdlnb2">
							<?php echo $utility->make_cheditor('popup_content', "");	// 에디터 생성?>
						</td>
					  </tr>
					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_01.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
<?
			break;

			## 팝업수정
			case 'update':
				
				$get_popup = $popup_control->get_popup($no);	// 팝업 정보
				$popup_skin = $popup_control->__PopupSkinList(); // 팝업 스킨

?>
				<form name="PopupRegistFrm" method="post" id="PopupRegistFrm" action="./process/popup.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="update" id="mode"/><!-- 팝업 수정 -->
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="uid" value="<?php echo $admin_info['uid'];?>"/>
				<input type="hidden" name="no" value="<?php echo $no;?>"/>

					<dl class="ntlt lnb_col m0 hand" id="addFrmHandle">
					<img src="../../images/comn/bul_10.png" class="t">팝업수정
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a></dl>
					<table width="750" class="bg_col">
					<col width=80><col>
					  <tr>
						<td class="ctlt">POPUP skin</td>
						<td class="pdlnb2">
							<select name="popup_skin">
								<?php foreach($popup_skin['result'] as $skins){?>
								<option value='<?php echo $skins['no'];?>' <?php echo ($skins['no']==$get_popup['popup_skin'])?'selected':'';?>><?php echo $skins['skin_name'];?></option>
								<?php } ?>
							</select>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">POPUP title</td>
						<td class="pdlnb2">
							<input name="popup_title" type="text" class="txt w50" required hname='POPUP title' maxbyte='40' value="<?php echo $get_popup['popup_title'];?>"> &nbsp;
							<label><input name="popup_title_view" type="checkbox" value="1" class="check" <?php echo ($get_popup['popup_title_view'])?'checked':'';?> >хэвлэх</label>
							<span class="subtlt">Хэвлэх үед гарч ирэх цонхны гарчгийг харуулна (20 тэмдэгт хүртэл)</span>
						</td>
					  </tr>
					  <!--
					  <tr>
						<td class="ctlt">출력타입</td>
						<td class="pdlnb2">
							<label><input name="popup_type" type="radio" value="1" class="radio" checked>레이어</label> &nbsp; &nbsp; &nbsp;&nbsp;
							<label><input name="popup_type" type="radio" value="0" class="radio" <?php echo (!$get_popup['popup_type'])?'checked':'';?>>팝업(새창)</label>  &nbsp;
						</td>
					  </tr>
					  -->
					  <input type="hidden" name="popup_type" value="1">
					  <tr>
						<td class="ctlt">Хэвлэх эсэх</td>
						<td class="pdlnb2">
							<label><input name="popup_view" type="radio" value="1" class="radio" checked>Хэвлэнэ</label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<label><input name="popup_view" type="radio" value="0" class="radio" <?php echo (!$get_popup['popup_view'])?'checked':'';?>>Хэвлэхгүй</label>
						</td>
					  </tr>
					  <tr>
                          <td class="ctlt">POPUP хэмжээ</td>
                          <td class="pdlnb2">
                              хэвтээ <input name="popup_width" type="text" class="tnum" size="3" value="0"> px ,
                              босоо <input name="popup_height" type="text" class="tnum" size="3" value="0"> px
                              <span class="subtlt">хэмжээ нь үйлдлийн системээс хамаарч өөр өөр байж болно.</span>
                          </td>
                      </tr>
                        <tr>
                            <td class="ctlt">POPUP байршил</td>
                            <td class="pdlnb2">
                                Топ <input name="popup_top" type="text" class="tnum" size="3" value="0"> px ,
                                Зүүн <input name="popup_left" type="text" class="tnum" size="3" value="0"> px
                                <span class="subtlt">Шинэ цонх ашиглах үед хөтөчийн зүүн дээд булан нь 0,0 бөгөөд layer ашиглах үед вэб хуудаснаас эхлэн тооцно.</span>
						</td>
					  </tr>
					  <tr>
                          <td class="ctlt">Хэвлэх хугацаа</td>
                          <td class="pdlnb2">
                              Эхлэх огноо <input name="popup_begin" type="text" class="tday" id="popup_begin" readonly style="width:125px;" value="">
                              Дуусах огноо <input name="popup_end" type="text" class="tday" id="popup_end" readonly style="width:125px;" value="">
                              <input name="popup_unlimit" type="checkbox" value="1" class="check">no limit
						</td>
					  </tr>
					  <tr>
                          <td class="ctlt">Агуулга</td>
						<td class="pdlnb2">
							<?php echo $utility->make_cheditor('popup_content', stripslashes($get_popup['popup_content']));	// 에디터 생성?>
						</td>
					  </tr>
					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_01.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
<?
			break;
		}
?>