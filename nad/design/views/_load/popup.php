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

					<dl class="ntlt lnb_col m0 hand" id="addFrmHandle"><img src="../../images/comn/bul_10.png" class="t">팝업스킨등록
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a></dl>
					<table width="700" class="bg_col">
					<col width=80><col>
					  <tr>
						<td class="ctlt">팝업스킨명</td>
						<td class="pdlnb2">
							<input name="skin_name" type="text" class="txt w50" required hname='팝업스킨명' maxbyte='40'>
							<span class="subtlt">40byte 이내</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">팝업제목색상</td>
						<td class="pdlnb2">
							<span id="subject_colorSet">
								<select name="subject_color" id="subject_color"><?php echo $utility->gwsc();?></select>
							</span>&nbsp;
							<span class="subtlt">팝업창의 제목 색상을 지정합니다. (배경이 검은색인경우 흰색으로 지정하시는게 좋습니다)</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">레이아웃</td>
						<td class="pdlnb2">
							테두리사이즈 <input name="border_size" type="text" class="tnum" size="2" value="1" id="border_size"> px , 
							테두리색상 
							<span id="border_colorSet">
								<select name="border_color" id="border_color"><?php echo $utility->gwsc();?></select>
							</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">배경이미지</td>
						<td class="pdlnb2">
							<input name="bgimage_file" type="file" class="txt w50" id="bgimage_file">
							<input name="bgimage_file_tmp" type="hidden" id="bgimage_file_tmp">
							<select name="bgimage_pattern">
								<option value="no-repeat">반복없음</option>
								<option value="repeat">반복</option>
								<option value="repeat-x">수평 반복</option>
								<option value="repeat-y">수직 반복</option>
							</select>
							<select name="bgimage_position">
								<option value="">배경이미지위치선택</option>
								<option value="top left">맨위 왼쪽</option>
								<option value="top center">맨위 가운데</option>
								<option value="top right">맨위 오른쪽</option>
								<option value="center left">가운데 왼쪽</option>
								<option value="center center">정가운데</option>
								<option value="center right">가운데 오른쪽</option> 
								<option value="bottom left">맨아래 왼쪽</option>
								<option value="bottom center">맨아래 가운데</option>
								<option value="bottom right">맨아래 오른쪽</option>
							</select>
						</dl>
						</td>
					  </tr>  
					  <tr> 
						<td class="ctlt">쿠키 체크출력</td>
						<td class="pdlnb2">
							<label>
								<select name="cookie_time">
									<option value="1 day">1일</option>
									<option value="3 day">3일</option>
									<option value="5 day">5일</option>
									<option value="1 week">1주일</option>
									<option value="1 month">1개월</option>
									<option value="24 hour">24시간</option>
									<option value="18 hour">18시간</option>
									<option value="12 hour">12시간</option>
									<option value="6 hour">6시간</option>
									<option value="3 hour">3시간</option>
									<option value="1 hour">1시간</option>
								</select>
								&nbsp;동안 열지 않기 사용
							</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">미리보기</td>
						<td class="pdlnb2">
						<dl class="mb5"><a onClick="popup_skin_replace();" class="btn pdlr5"><h1 class="btn23"><span class="ic" style="background-image:url(../../images/ic/ref.gif)"></span>미리보기 새로고침</h1></a></dl>
						<dl id="skinPreview">
						  <table width="100%" height="200" style="border:1px solid #000000;background:#000000">
							<tr>
							  <td class="pcontents" style="text-align:center;">{내용}</td>
							</tr>
							<tr>
							  <td class="pclose"><dl><a href="#">하루동안 열지 않기</a>
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

					<dl class="ntlt lnb_col m0 hand" id="addFrmHandle"><img src="../../images/comn/bul_10.png" class="t">팝업스킨수정
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a></dl>
					<table width="700" class="bg_col">
					<col width=80><col>
					  <tr>
						<td class="ctlt">팝업스킨명</td>
						<td class="pdlnb2"><input name="skin_name" type="text" class="txt w50" required hname='팝업스킨명' maxbyte='40' value="<?php echo stripslashes($popup_skin['skin_name']);;?>">
						<span class="subtlt">40byte 이내</span></td>
					  </tr>
					  <tr>
						<td class="ctlt">팝업제목색상</td>
						<td class="pdlnb2">
							<span id="subject_colorSet">
								<select name="subject_color" id="subject_color"><?php echo $utility->gwsc($popup_skin['subject_color']);?></select>
							</span>&nbsp;
							<span class="subtlt">팝업창의 제목 색상을 지정합니다. (배경이 검은색인경우 흰색으로 지정하시는게 좋습니다)</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">레이아웃</td>
						<td class="pdlnb2">
							테두리사이즈 <input name="border_size" type="text" class="tnum" size="2" value="<?php echo $popup_skin['border_size'];?>"> px , 
							테두리색상 
							<span id="border_colorSet">
								<select name="border_color" id="border_color"><?php echo $utility->gwsc($popup_skin['border_color']);?></select>
							</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">배경이미지</td>
						<td class="pdlnb2">
							<input name="bgimage_file" type="file" class="txt w50" id="bgimage_file">
							<input name="bgimage_file_tmp" type="hidden" id="bgimage_file_tmp">
							<select name="bgimage_pattern">
								<option value="no-repeat" <?php echo ($popup_skin['bgimage_pattern']=='no-repeat')?'selected':'';?>>반복없음</option>
								<option value="repeat" <?php echo ($popup_skin['bgimage_pattern']=='repeat')?'selected':'';?>>반복</option>
								<option value="repeat-x" <?php echo ($popup_skin['bgimage_pattern']=='repeat-x')?'selected':'';?>>수평 반복</option>
								<option value="repeat-y" <?php echo ($popup_skin['bgimage_pattern']=='repeat-y')?'selected':'';?>>수직 반복</option>
							</select>
							<select name="bgimage_position">
								<option value="">배경이미지위치선택</option>
								<option value="top left" <?php echo ($popup_skin['bgimage_position']=='top left')?'selected':'';?>>맨위 왼쪽</option>
								<option value="top center" <?php echo ($popup_skin['bgimage_position']=='top center')?'selected':'';?>>맨위 가운데</option>
								<option value="top right" <?php echo ($popup_skin['bgimage_position']=='top right')?'selected':'';?>>맨위 오른쪽</option>
								<option value="center left" <?php echo ($popup_skin['bgimage_position']=='center left')?'selected':'';?>>가운데 왼쪽</option>
								<option value="center center" <?php echo ($popup_skin['bgimage_position']=='center center')?'selected':'';?>>정가운데</option>
								<option value="center right" <?php echo ($popup_skin['bgimage_position']=='center right')?'selected':'';?>>가운데 오른쪽</option> 
								<option value="bottom left" <?php echo ($popup_skin['bgimage_position']=='bottom left')?'selected':'';?>>맨아래 왼쪽</option>
								<option value="bottom center" <?php echo ($popup_skin['bgimage_position']=='bottom center')?'selected':'';?>>맨아래 가운데</option>
								<option value="bottom right" <?php echo ($popup_skin['bgimage_position']=='bottom right')?'selected':'';?>>맨아래 오른쪽</option>
							</select>
						</dl>
						</td>
					  </tr>  
					  <tr> 
						<td class="ctlt">쿠키 체크출력</td>
						<td class="pdlnb2">
							<label>
								<select name="cookie_time">
									<option value="1 day" <?php echo ($popup_skin['cookie_time']=='1 day')?'selected':'';?>>1일</option>
									<option value="3 day" <?php echo ($popup_skin['cookie_time']=='3 day')?'selected':'';?>>3일</option>
									<option value="5 day" <?php echo ($popup_skin['cookie_time']=='5 day')?'selected':'';?>>5일</option>
									<option value="1 week" <?php echo ($popup_skin['cookie_time']=='1 week')?'selected':'';?>>1주일</option>
									<option value="1 month" <?php echo ($popup_skin['cookie_time']=='1 month')?'selected':'';?>>1개월</option>
									<option value="24 hour" <?php echo ($popup_skin['cookie_time']=='24 hour')?'selected':'';?>>24시간</option>
									<option value="18 hour" <?php echo ($popup_skin['cookie_time']=='18 hour')?'selected':'';?>>18시간</option>
									<option value="12 hour" <?php echo ($popup_skin['cookie_time']=='12 hour')?'selected':'';?>>12시간</option>
									<option value="6 hour" <?php echo ($popup_skin['cookie_time']=='6 hour')?'selected':'';?>>6시간</option>
									<option value="3 hour" <?php echo ($popup_skin['cookie_time']=='3 hour')?'selected':'';?>>3시간</option>
									<option value="1 hour" <?php echo ($popup_skin['cookie_time']=='1 hour')?'selected':'';?>>1시간</option>
								</select>
								&nbsp;동안 열지 않기 사용
							</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">미리보기</td>
						<td class="pdlnb2">
						<dl class="mb5"><a onClick="previewReload();" class="btn pdlr5"><h1 class="btn23"><span class="ic" style="background-image:url(../../images/ic/ref.gif)"></span>미리보기 새로고침</h1></a></dl>
						<dl id="skinPreview">
							<table width="100%" height="200" style="border:<?php echo $popup_skin['border_size'];?>px solid #<?php echo $popup_skin['border_color'];?>;background:#<?php echo $popup_skin['border_color'];?>;">
							<tr>
								<td class="pcontents" style="<?php echo $background;?>;text-align:center;">{내용}</td>
							</tr>
							<tr>
								<td class="pclose">
								<dl>
									<input name="" type="checkbox" value="" class="check"><?php echo strtr($popup_skin['cookie_time'],$popup_control->cookie_arr);?> 동안 열지 않기
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
					<img src="../../images/comn/bul_10.png" class="t">팝업등록
					<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a></dl>
					<table width="750" class="bg_col">
					<col width=110><col>
					  <tr>
						<td class="ctlt">팝업스킨</td>
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
								<option value=''>팝업스킨이 존재하지 않습니다.</option>
								<?php } ?>
							</select>
							<?php if(!$popup_skin['result']){?><span class="subtlt"><a href='./pop_skin.php'>팝업스킨을 먼저 설정해 주세요.</a></span><?php } ?>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">팝업제목</td> 
						<td class="pdlnb2">
							<input name="popup_title" type="text" class="txt w50" required hname='팝업제목' maxbyte='40'> &nbsp;
							<label><input name="popup_title_view" type="checkbox" value="1" class="check" checked>출력</label>
							<span class="subtlt">출력시 팝업창 상단에 팝업제목 노출 (20자 이내)</span>
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
						<td class="ctlt">출력여부</td>
						<td class="pdlnb2">
							<label><input name="popup_view" type="radio" value="1" class="radio" checked>출력</label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<label><input name="popup_view" type="radio" value="0" class="radio">미출력</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">서브페이지출력여부</td>
						<td class="pdlnb2">
							<label><input name="popup_sub_view" type="radio" value="1" class="radio" checked>출력</label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<label><input name="popup_sub_view" type="radio" value="0" class="radio">미출력</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">팝업크기</td>
						<td class="pdlnb2">
							가로 <input name="popup_width" type="text" class="tnum" size="3" value="0"> px , 
							세로 <input name="popup_height" type="text" class="tnum" size="3" value="0"> px
							<span class="subtlt">운영체제에 따라 실제 출력크기와 다를 수 있음</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">팝업위치</td>
						<td class="pdlnb2">
							상단 <input name="popup_top" type="text" class="tnum" size="3" value="0"> px , 
							왼쪽 <input name="popup_left" type="text" class="tnum" size="3" value="0"> px
							<span class="subtlt">새창 사용시 브라우저의 좌측상단 끝이 0,0 이며, 레이어 사용시 웹페이지 내용부터 계산</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">출력기간</td>
						<td class="pdlnb2">
							시작일 <input name="popup_begin" type="text" class="tday" id="popup_begin" readonly style="width:125px;" value="">
							종료일 <input name="popup_end" type="text" class="tday" id="popup_end" readonly style="width:125px;" value="">
							<input name="popup_unlimit" type="checkbox" value="1" class="check">제한없음
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">내용</td>
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
						<td class="ctlt">팝업스킨</td>
						<td class="pdlnb2">
							<select name="popup_skin">
								<?php foreach($popup_skin['result'] as $skins){?>
								<option value='<?php echo $skins['no'];?>' <?php echo ($skins['no']==$get_popup['popup_skin'])?'selected':'';?>><?php echo $skins['skin_name'];?></option>
								<?php } ?>
							</select>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">팝업제목</td> 
						<td class="pdlnb2">
							<input name="popup_title" type="text" class="txt w50" required hname='팝업제목' maxbyte='40' value="<?php echo $get_popup['popup_title'];?>"> &nbsp;
							<label><input name="popup_title_view" type="checkbox" value="1" class="check" <?php echo ($get_popup['popup_title_view'])?'checked':'';?> >출력</label>
							<span class="subtlt">출력시 팝업창 상단에 팝업제목 노출 (20자 이내)</span>
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
						<td class="ctlt">출력여부</td>
						<td class="pdlnb2">
							<label><input name="popup_view" type="radio" value="1" class="radio" checked>출력</label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<label><input name="popup_view" type="radio" value="0" class="radio" <?php echo (!$get_popup['popup_view'])?'checked':'';?>>미출력</label>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">팝업크기</td>
						<td class="pdlnb2">
							가로 <input name="popup_width" type="text" class="tnum" size="3" value="<?php echo $get_popup['popup_width'];?>"> px , 
							세로 <input name="popup_height" type="text" class="tnum" size="3" value="<?php echo $get_popup['popup_height'];?>"> px
							<span class="subtlt">운영체제에 따라 실제 출력크기와 다를 수 있음</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">팝업위치</td>
						<td class="pdlnb2">
							상단 <input name="popup_top" type="text" class="tnum" size="3" value="<?php echo $get_popup['popup_top'];?>"> px , 
							왼쪽 <input name="popup_left" type="text" class="tnum" size="3" value="<?php echo $get_popup['popup_left'];?>"> px
							<span class="subtlt">새창 사용시 브라우저의 좌측상단 끝이 0,0 이며, 레이어 사용시 웹페이지 내용부터 계산</span>
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">출력기간</td>
						<td class="pdlnb2">
							시작일 <input name="popup_begin" type="text" class="tday" id="popup_begin" readonly style="width:125px;" value="<?php echo $get_popup['popup_begin'];?>">
							종료일 <input name="popup_end" type="text" class="tday" id="popup_end" readonly style="width:125px;" value="<?php echo $get_popup['popup_end'];?>">
							<input name="popup_unlimit" type="checkbox" value="1" class="check" <?php echo ($get_popup['popup_unlimit'])?'checked':'';?>>제한없음
						</td>
					  </tr>
					  <tr>
						<td class="ctlt">내용</td>
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