<?php
		/*
		* /application/nad/member/views/_load/layer.php
		* @author Harimao
		* @since 2013/07/11
		* @last update 2015/04/13
		* @Module v3.5 ( Alice )
		* @Brief :: Member load layer
		* @Comment :: 회원정보에 지정에 다른 정보 추출
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$type = $_POST['type'];
		$no = $_POST['no'];

		$member = $member_control->get_memberNo($no);
		
		switch($mode){

			## 문자
			case 'sms':

				$sms_msg = $sms_control->__SMS_msgList( " where `is_view`  = 1 " );
?>
				<div id="pop_sms" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1001;width:805px;">
					
					<dl class="ntlt lnb_col m0" id="smsFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">SMS текст илгээх
						<a onClick="MM_showHideLayers('pop_sms','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<dl class="mt7">
						<dt class="fl mr10"><?php include_once "../_include/sms.php"; ?></dt>
						<dt class="fr">
							<?php include_once "../../../include/sms_text.php"; ?>
							<dl class="ntlt lnb_col">문자메세지예제
								<span class="subtlt bar">메세지를 클릭하면 메세지창에 바로 입력이 됩니다</span>
								<dt><a href="../config/sms.php" class="btn"><h1 class="btn23">예문보기</h1></a></dt>
							</dl>
							<table width="100%" cellspacing="1" class="sep ln">
							<col span="4" width="150">
							<tr class="wbg tc fon11 gr none" height="25">
							<?php 
							$mod = 4;
							$i = 0;
							foreach($sms_msg as $val){ 
								if($i && $i % $mod == 0) echo "</tr><tr class=\"wbg tc fon11 gr none\" height=\"25\">";
							?>
								<td><a href="javascript:sms_msg('<?php echo $val['no'];?>');"><?php echo $val['msg_title'];?></a></td>
							<?php 
							$i++;
							} // foreach end.
							$cnt = $i % $mod;
							if($cnt)
								for($i=$cnt;$i<$mod;$i++)
									echo "<td>&nbsp;</td>";
							?>
							</tr>
							</table>
						</dt>
					</dl>

				</div>
<?
			break;

			## 이메일
			case 'email':

				if(is_array($no)){	// 배열로 넘어온 경우 선택 메일 발송 (복수)

					$no_cnt = count($no);
					$receive_mails = array();
					$receive_nos = array();
					for($i=0;$i<$no_cnt;$i++){
						$member = $member_control->get_memberNo($no[$i]);
						$receive_mails[$i] = $member['mb_email'];
						$receive_nos[$i] = $member['no'];
					}

					$receive_mail = @implode(',',$receive_mails);
					$receive_no = @implode(',',$receive_nos);

				} else {	 // 일반 메일 발송 (단수)

					$receive_mail = $member['mb_email'];
					$receive_no = $member['no'];

				}

				$get_mail_skin = $design_control->get_mail_skin('member_mailing');	// 메일 스킨 기본값 :: 회원 메일링
				
?>
				<div id="pop_mail" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1002;">
				<form name="MemberEmailFrm" method="post" id="MemberEmailFrm" action="../member/process/regist.php">
				<input type="hidden" name="mode" value="email"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="send_email" value="<?php echo $env['email'];?>"/>

				<input type="hidden" name="receive_no" value="<?php echo $receive_no;?>"/>

					<dl class="ntlt lnb_col m0" id="emailFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">메일보내기
						<a onClick="MM_showHideLayers('pop_mail','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="700" class="bg_col">
					<col width="60"><col>
					<tr>
						<td class="pdlnb1 ctlt">제목</td>
						<td class="pdlnb2"><input type="text" class="txt w100" name="subject" required hname="메일 제목"></td>
					</tr>
					<tr>
						<td class="pdlnb1 ctlt">받는사람</td>
						<td class="pdlnb2">
							<textarea name="receive_mail" style="width:100%;height:40px;overflow-y:scroll" class="fon11 h14 bdtxt" required hname="받는사람 메일주소"><?php echo $receive_mail;?></textarea>
							<dt class="mt2 subt">여러명 발송시 콤마(,) 로 구분</dt>
						</td>
					</tr>
					<tr>
						<td class="pdlnb1 ctlt">내용</td>
						<td class="pdlnb2" id="contentBlock">
							※ 메일 기본 내용은 <a href="../design/mail_skin.php?mail_type=member_mailing">[디자인관리] - MAIL스킨관리 - 회원 메일링</a> 에서 설정 가능합니다.
							<!-- <textarea name="content" id='tx_content' style='display:none;'></textarea> -->
							<?//php echo $utility->make_cheditor('content', '');	// 에디터 생성?>
							<?php echo $utility->make_cheditor('content', stripslashes($get_mail_skin['content']));	// 에디터 생성?>
						</td>
					</tr>  
					</table>

					<dl class="pbtn">  
						<img  src="../../images/btn/b23_07.png" class="ln_col" style="cursor:pointer;" onclick="mail_send('<?php echo $no;?>');">&nbsp;
						<a onClick="MM_showHideLayers('pop_mail','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>  

				</form>
				</div>
<?
			break;

			## 메모 정보
			case 'memo':
?>
				<div id="pop_memo" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1003;">
				<form name="MemberMemoFrm" method="post" id="MemberMemoFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="memo"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>

					<dl class="ntlt lnb_col m0" id="memoFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">관리자메모
						<a onClick="MM_showHideLayers('pop_memo','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<dl class="twrap"><textarea style="height:100px;width:690px" name="mb_memo"><?php echo stripslashes($member['mb_memo']);?></textarea></dl>  

					<dl class="pbtn">
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_memo','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>
<?php
			break;

			## 우편번호 (개인회원)
			case 'zipcode_individual':

				if($type=='new'){	// 도로명 주소
?>
				<div class="lnb_col positionA" style="border:2px solid #ddd; background:#fff; width:520px; top:20%;left:50%;text-align:left;display:;z-index:1005;" id="new_postSearchPop">
					<dl>
					<dt style="padding:20px 15px;cursor:pointer;" class="bg_gray1" id="new_postSearchPop_handle">
						<strong>우편번호 검색</strong>
						<em class="closeBtn"><img width="11" height="11" class="pb5" src="../../images/icon/icon_close2.gif" alt="arrow"></em>
					</dt>
					<dd style="padding:20px 15px 30px;">
						<p style="padding-bottom:10px;padding-left:15px; background:url(../../images/icon/icon_arrow_right1.gif) no-repeat 0 20%;">
							<strong>우편번호 검색</strong><br/>
						</p>
						<div class="box2" style="background:#F8F8F8; border:1px solid #ddd; padding:20px;">
							<ul>
								<li>
									<span>
										<label class="skip">검색어입력</label>
										<input type="text" style="width:220px;ime-mode:active;" name="new_postSearchKeyword" id="new_postSearchKeyword">
										<em class="pr10"><a class="btn" style="padding:2px 10px;" onclick="new_postSearchs('individual');"><span>검색</span></a></em>
									</span>
								</li>
								<li class="pt5"><em class="">※ 도로명을 입력해주세요 (삼성동이면 '삼성'만 입력).</em></li>
							</ul>
						</div>
						<!-- 결과 리스트 -->
						<div class="mt20 addressResult">
							<table width="100%" cellspacing="0" cellpadding="0" align="center" >		
							<colgroup><col width="15%"><col width="50%"><col width="30%"></colgroup>
							<tr>
								<th><strong>우편 번호</strong></th>
								<th><strong>도로명 주소</strong></th>
								<th class=" brend"><strong>지번</strong></th>
							</tr>
							<tbody id="new_post_List">
							<tr>
								<td colspan="2" style="text-align:center;height:165px;">우편번호를 검색해 주세요.</td>
							</tr>
							</tbody>
							</table>
						</div>
						<!-- //결과 리스트 -->
						</dd>
					</dl>
				</div>

<?php
				} else {	 // 일반 주소
?>
				<div class="lnb_col positionA" style="border:2px solid #ddd; background:#fff; width:420px; top:20%;left:50%;text-align:left;display:;z-index:1005;" id="postSearchPop">
					<dl>
					<dt style="padding:20px 15px;cursor:pointer;" class="bg_gray1" id="postSearchPop_handle">
						<strong>우편번호 검색</strong>
						<em class="closeBtn"><img width="11" height="11" class="pb5" src="../../images/icon/icon_close2.gif" alt="arrow"></em>
					</dt>
					<dd style="padding:20px 15px 30px;">
						<p style="padding-bottom:10px;padding-left:15px; background:url(../../images/icon/icon_arrow_right1.gif) no-repeat 0 20%;">
							<strong>우편번호 검색</strong><br/>
						</p>
						<div class="box2" style="background:#F8F8F8; border:1px solid #ddd; padding:20px;">
							<ul>
								<li>
									<span>
										<label class="skip">검색어입력</label>
										<input type="text" style="width:220px;ime-mode:active;" name="postSearchKeyword" id="postSearchKeyword">
										<em class="pr10"><a class="btn" style="padding:2px 10px;" onclick="postSearchs('individual');"><span>검색</span></a></em>
									</span>
								</li>
								<li class="pt5"><em class="">※ 동명을 입력해주세요 (삼성동이면 '삼성동'만 입력).</em></li>
							</ul>
						</div>
						<!-- 결과 리스트 -->
						<div class="mt20 addressResult">
							<table width="100%" cellspacing="0" cellpadding="0" align="center" >		
							<colgroup><col width="20%"><col width="80%"></colgroup>
							<tr>
								<th><strong>우편 번호</strong></th>
								<th class=" brend"><strong>주소</strong></th>
							</tr>		
							<tbody id="post_List">
							<tr>
								<td colspan="2" style="text-align:center;height:165px;">우편번호를 검색해 주세요.</td>
							</tr>
							</tbody>
							</table>
						</div>
						<!-- //결과 리스트 -->
						</dd>
					</dl>
				</div>
<?php
				}
			break;

			## 우편번호 (기업회원)
			case 'zipcode_company':

				$map_color = $_POST['map_color'];

				if($type=='new'){	// 도로명 주소
?>
				<div class="lnb_col positionA" style="border:2px solid #ddd; background:#fff; width:520px; top:20%;left:50%;display:none;z-index:1005;" id="new_postSearchPop">
					<dl>
					<dt style="padding:20px 15px;cursor:pointer;" class="bg_gray1" id="new_postSearchPop_handle">
						<strong>우편번호 검색</strong>
						<em class="closeBtn"><img width="11" height="11" class="pb5" src="../../images/icon/icon_close2.gif" alt="arrow"></em>
					</dt>
					<dd style="padding:20px 15px 30px;">
						<p style="padding-bottom:10px;padding-left:15px; background:url(../../images/icon/icon_arrow_right1.gif) no-repeat 0 20%;">
							<strong>우편번호 검색</strong><br/>
						</p>
						<div class="box2" style="background:#F8F8F8; border:1px solid #ddd; padding:20px;">
							<ul>
								<li>
									<span>
										<label class="skip">검색어입력</label>
										<input type="text" style="width:220px;ime-mode:active;" name="new_postSearchKeyword" id="new_postSearchKeyword">
										<em class="pr10"><a class="btn" style="padding:0 10px;" onclick="new_postSearchs('company');"><span>검색</span></a></em>
									</span>
								</li>
								<li class="pt5"><em class="">※ 도로명을 입력해주세요 (삼성동이면 '삼성'만 입력).</em></li>
							</ul>
						</div>
						<!-- 결과 리스트 -->
						<div class="mt20 addressResult">
							<table width="100%" cellspacing="0" cellpadding="0" align="center" >		
							<colgroup><col width="15%"><col width="50%"><col width="30%"></colgroup>
							<tr>
								<th><strong>우편 번호</strong></th>
								<th><strong>도로명 주소</strong></th>
								<th class=" brend"><strong>지번</strong></th>
							</tr>
							<tbody id="new_post_List">
							<tr>
								<td colspan="2" style="text-align:center;height:165px;">우편번호를 검색해 주세요.</td>
							</tr>
							</tbody>
							</table>
						</div>
						<!-- //결과 리스트 -->
						<div class="mt5">
							<table width="100%" cellpadding="0" cellspacing="0" align="center">
							<tr><td style="padding:15px 0 10px;"><b>회사위치(약도)</b> - 클릭시 위치가 지정됩니다.</td></tr>
							<tr>
								<td>
									<div id="mapBlock" style="border:3px solid <?php echo $map_color;?>">
										<div id="new_mapContainer" style="width:485px;height:230px;"></div>
									</div>
								</td>
							</tr>
							<tr align="center">
								<td style="padding-top:10px;">
									<img src="../../images/btn/btn23_ok.gif" align="absmiddle" style='cursor:pointer;' class='close'>
									<img src="../../images/btn/btn23_08.gif" align="absmiddle" style='cursor:pointer;' class='close'>
								</td>
							</tr>
							</table>
						</div>
					</dd>
					</dl>
				</div>
<?php
				} else {
?>
				<div class="lnb_col positionA" style="border:2px solid #ddd; background:#fff; width:420px; top:20%;left:50%;display:none;z-index:1005;" id="postSearchPop">
					<dl>
					<dt style="padding:20px 15px;cursor:pointer;" class="bg_gray1" id="postSearchPop_handle">
						<strong>우편번호 검색</strong>
						<em class="closeBtn"><img width="11" height="11" class="pb5" src="../../images/icon/icon_close2.gif" alt="arrow"></em>
					</dt>
					<dd style="padding:20px 15px 30px;">
						<p style="padding-bottom:10px;padding-left:15px; background:url(../../images/icon/icon_arrow_right1.gif) no-repeat 0 20%;">
							<strong>우편번호 검색</strong><br/>
						</p>
						<div class="box2" style="background:#F8F8F8; border:1px solid #ddd; padding:20px;">
							<ul>
								<li>
									<span>
										<label class="skip">검색어입력</label>
										<input type="text" style="width:220px;ime-mode:active;" name="postSearchKeyword" id="postSearchKeyword">
										<em class="pr10"><a class="btn" style="padding:0 10px;" onclick="postSearchs('company');"><span>검색</span></a></em>
									</span>
								</li>
								<li class="pt5"><em class="">※ 동명을 입력해주세요 (삼성동이면 '삼성동'만 입력).</em></li>
							</ul>
						</div>
						<!-- 결과 리스트 -->
						<div class="mt20 addressResult">
							<table width="100%" cellspacing="0" cellpadding="0" align="center" >		
							<colgroup><col width="20%"><col width="80%"></colgroup>
							<tr>
								<th><strong>우편 번호</strong></th>
								<th class=" brend"><strong>주소</strong></th>
							</tr>		
							<tbody id="post_List">
							<tr>
								<td colspan="2" style="text-align:center;height:165px;">우편번호를 검색해 주세요.</td>
							</tr>
							</tbody>
							</table>
						</div>
						<!-- //결과 리스트 -->
						<div class="mt5">
							<table width="100%" cellpadding="0" cellspacing="0" align="center">
							<tr><td style="padding:15px 0 10px;"><b>회사위치(약도)</b> - 클릭시 위치가 지정됩니다.</td></tr>
							<tr>
								<td>
									<div id="mapBlock" style="border:3px solid <?php echo $map_color;?>">
										<div id="mapContainer" style="width:385px;height:230px;"></div>
									</div>
								</td>
							</tr>
							<tr align="center">
								<td style="padding-top:10px;">
									<img src="../../images/btn/btn23_ok.gif" align="absmiddle" style='cursor:pointer;' class='close'>
									<img src="../../images/btn/btn23_08.gif" align="absmiddle" style='cursor:pointer;' class='close'>
								</td>
							</tr>
							</table>
						</div>
					</dd>
					</dl>
				</div>

<?php
				}
			break;

			## 불량회원 등록 폼
			case 'badness':
				$mb_denied = $member['mb_denied'];
				$mb_badness = $member['mb_badness'];

				$is_nos = false;
				if(is_array($no)){
					$is_nos = true;
					$no = @implode(',',$no);
				}

?>
				<div id="pop_badness" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1003;">
				<form name="MemberBadnessFrm" method="post" id="MemberBadnessFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="badness"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>
				<input type="hidden" name="is_nos" value="<?php echo $is_nos;?>"/>
				<!-- <input type="hidden" name="mb_badness" value="1"/> -->

					<dl class="ntlt lnb_col m0" id="badnessFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">불량회원 등록
						<span>저장하시면 불량회원으로 등록 됩니다.</span>
						<a onClick="MM_showHideLayers('pop_badness','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="700" class="bg_col">
					<col width=90><col>
					<tr>
						<td class="ctlt">불량회원</td>
						<td class="pdlnb2">
							<input type="radio" value="1" name="mb_badness" id="mb_badness_1" required hname="등록" checked>
							<label for="mb_badness_1">등록</label>&nbsp;
							<input type="radio" value="0" name="mb_badness" id="mb_badness_0" required hname="미등록" <?php echo (!$mb_badness)?'checked':'';?>>
							<label for="mb_badness_0">미등록</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">차단유무</td>
						<td class="pdlnb2">
							<input type="radio" value="1" name="mb_denied" id="mb_denied_1" required hname="차단" checked>
							<label for="mb_denied_1">차단</label>&nbsp;
							<input type="radio" value="0" name="mb_denied" id="mb_denied_0" required hname="미차단" <?php echo (!$mb_denied)?'checked':'';?>>
							<label for="mb_denied_0">접근</label>
							<span class="subtlt">차단 설정 하시면 `<?php echo $member['mb_name'];?>(<?php echo $member['mb_id'];?>)` 회원은 사이트에 접근 할수 없습니다.</span>
						</td>
					</tr>
					<?php if(!$is_nos){ // 다수가 아닐때만 ?>
					<tr>
						<td class="ctlt">메모</td>
						<td class="pdlnb2">
							<dl class="twrap"><textarea name="mb_memo" style="height:80px"><?php echo stripslashes($member['mb_memo']);?></textarea></dl>
						</td>
					</tr>
					<?php } ?>
					</table>

					<dl class="pbtn">
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_badness','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>

<?php
			break;
			
			## 열람서비스
			case 'open_service':

				$member = $member_control->get_member($mb_id);
				$get_service = $member_control->get_service_member($mb_id);
?>
				<div id="pop_open_service" class="bocol lnb_col" style="top:5%;left:33%;display:;z-index:1003;">
				<form name="MemberOpenServiceFrm" method="post" id="MemberOpenServiceFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="oepn_service"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>

					<dl class="ntlt lnb_col m0" id="MemberOpenServiceFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">열람서비스 기간
						<span>기간을 지정하시면 열람서비스가 부여 됩니다.</span>
						<a onClick="MM_showHideLayers('pop_open_service','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="500" class="bg_col">
					<col width=90><col>
					<tr>
						<td class="ctlt">서비스기간</td>
						<td class="pdlnb2">
							<input type="text" class="txt" name="mb_service_open" value="<?php echo $get_service['mb_service_open'];?>" id="mb_service_open" style="width:70px;">
							<span>기간을 지정하시면 열람서비스가 부여 됩니다.</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">열람건수</td>
						<td class="pdlnb2">
							<input type="text" class="txt" name="mb_service_open_count" value="<?php echo $get_service['mb_service_open_count'];?>" id="mb_service_open_count" style="width:20px;">
							<span>건</span>
						</td>
					</tr>
					</table>

					<dl class="pbtn">
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_open_service','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>

<?php
			break;

			## 개인회원 열람 서비스
			case 'indi_open_service':

				$member = $member_control->get_member($mb_id);
				$get_service = $member_control->get_service_member($mb_id);
?>
				<div id="pop_open_service" class="bocol lnb_col" style="top:5%;left:33%;display:;z-index:1003;">
				<form name="MemberOpenServiceFrm" method="post" id="MemberOpenServiceFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="indi_oepn_service"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>

					<dl class="ntlt lnb_col m0" id="MemberOpenServiceFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">열람서비스 기간
						<span>기간을 지정하시면 열람서비스가 부여 됩니다.</span>
						<a onClick="MM_showHideLayers('pop_open_service','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="500" class="bg_col">
					<col width=90><col>
					<tr>
						<td class="ctlt">서비스기간</td>
						<td class="pdlnb2">
							<input type="text" class="txt" name="mb_service_alba_open" value="<?php echo $get_service['mb_service_alba_open'];?>" id="mb_service_alba_open" style="width:70px;">
							<span>기간을 지정하시면 열람서비스가 부여 됩니다.</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">열람건수</td>
						<td class="pdlnb2">
							<input type="text" class="txt" name="mb_service_alba_count" value="<?php echo $get_service['mb_service_alba_count'];?>" id="mb_service_alba_count" style="width:20px;">
							<span>건</span>
						</td>
					</tr>
					</table>

					<dl class="pbtn">
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_open_service','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>

<?php
			break;

			## 발송 내역 보기
			case 'send_content':

			$get_mailing_list = $mailing_control->get_mailing_list($no);
			$wr_type = $get_mailing_list['wr_type'];
?>
				<div id="pop_content" class="bocol lnb_col" style="top:15%;left:33%;display:;z-index:1003;">
					<dl class="ntlt lnb_col m0 hand" id="contentHandle">
						<img src="../../images/comn/bul_10.png" class="t">맞춤채용정보 수정
						<a onClick="MM_showHideLayers('pop_content','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  
					
					<table width="840" class="bg_col tf">
					<col width="100"><col>
					<?php if($wr_type=='sms'){ ?>
					<tr>
						<td class="ctlt">내용</td>
						<td class="pdlnb2 num11"><?php echo stripslashes($get_mailing_list['wr_content']);?></td>
					</tr>
					<?php } else if($wr_type=='email'){ ?>
					<tr>
						<td class="ctlt">제목</td>
						<td class="pdlnb2 num11"><?php echo stripslashes($get_mailing_list['wr_subject']);?></td>
					</tr>
					<tr>
						<td class="ctlt">내용</td>
						<td class="pdlnb2 num11"><?php echo stripslashes($get_mailing_list['wr_content']);?></td>
					</tr>
					<?php } ?>
					</table>

					<dl class="pbtn">
						<a onClick="MM_showHideLayers('pop_content','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</div>
<?php
			break;

			## 메일링 수동 발송
			case 'mailing_list':

				$member_list = $member_control->__MemberList("",""," where a.is_delete = 0 ");
				
?>
				<div id="pop_content" class="bocol lnb_col" style="top:5%;left:33%;display:;z-index:1003;">
					<dl class="ntlt lnb_col m0 hand" id="contentHandle">
						<img src="../../images/comn/bul_10.png" class="t">정기메일링 / SMS 수신회원
						<span class="subtlt bar">이메일, SMS 수신여부와 관계없이, 맞춤인재, 맞춤채용정보를 설정한 회원 목록입니다.</span>
						<a onClick="MM_showHideLayers('pop_content','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  

					<table style="width:720px;" class="ttlt">
					<col width="2%"><col width="7%"><col width="5%" span="2"><col width="10%"><col width="15%">
					<tr class="bg">
						<td><input name="check_all" type="checkbox" checked></td>
						<td><a href="#">회원구분<span id="mb_id_sort">▲<!-- ▼ --></span></a></td>
						<td>이메일 수신</td>
						<td>SMS 수신</td>
						<td><a href="#">회원ID<span id="mb_id_sort">▲<!-- ▼ --></span></a></td>
						<td><a href="#">이름/대표자 (성별/나이)<span id="mb_id_name">▲<!-- ▼ --></span></a></td>
					</tr>
					</table>

					<div style="width: 720px; height: 400px; overflow: auto;overflow-x:hidden;">
						<table style="width:720px;" class="ttlt">
						<col width="2%"><col width="7%"><col width="5%" span="2"><col width="10%"><col width="15%">
						<?php 
						foreach($member_list['result'] as $val){ 
						$mb_type = ($val['mb_type']=='individual') ? "개인회원" : "기업회원";
						$mb_name  = $val['mb_name'];
						$mb_name .= ($val['mb_company_name']) ? "/" . $val['mb_company_name'] : "";
						$get_gender = $member_control->mb_gender[$val['mb_gender']];	// 성별
						$get_age = $member_control->get_age($val['mb_birth']);	// 나이
						$mb_name .= ($val['mb_type']=='individual') ? " (".$get_gender."/".$get_age."세)" : "";
						$mb_receive = explode(",",$val['mb_receive']);
						$checked = ( (in_array('email',$mb_receive)) || (in_array('sms',$mb_receive))) ? 'checked' : '';
						$custom_titles = $alba_company_control->custom_titles($val['mb_id']);	 // 타이틀 뽑기
						if(!$custom_titles) continue;
						?>
						<tr>
							<td><input type="checkbox" name='no[]' class='check_all' value="<?php echo $val['no'];?>" <?//php echo $checked;?> checked></td>
							<td><?php echo $mb_type;?></td>
							<td><?php echo (in_array('email',$mb_receive))?"<span class=\"wbl b\">O</span>":"<span class=\"red b\">X</span>";?></td>
							<td><?php echo (in_array('sms',$mb_receive))?"<span class=\"wbl b\">O</span>":"<span class=\"red b\">X</span>";?></td>
							<td><?php echo $val['mb_id'];?></td>
							<td><?php echo $mb_name;?></td>
						</tr>
						<?php } ?>
						</tbody>
						</table>
					</div>

					<dl style="text-align:center;" class="mt10">
						<dd>
							<a onClick="send_mailing('mail');" class="cbtn lnb_col grf_col"><h1 class="btn23">메일링 발송</h1></a>
							<a onClick="send_mailing('sms');" class="cbtn lnb_col grf_col"><h1 class="btn23">SMS 발송</h1></a>
						</dd>
					</dl>

				</div>
<?php
			

			break;

			## SMS 수동 충전
			case 'sms_charge':
?>
				<div id="pop_sms" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1003;">
				<form name="MemberSMSFrm" method="post" id="MemberSMSFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="sms_charge"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>

					<dl class="ntlt lnb_col m0" id="badnessFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">SMS 수동 충전
						<span>SMS 를 수동으로 충전합니다.</span>
						<a onClick="MM_showHideLayers('pop_sms','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="700" class="bg_col">
					<col width=90><col>
					<tr>
						<td class="ctlt">SMS 잔여</td>
						<td class="pdlnb2">
							<?php echo number_format($member['mb_sms']);?>건
						</td>
					</tr>
					<tr>
						<td class="ctlt">충전 건수</td>
						<td class="pdlnb2">
							<select name="charge_type">
							<option value="+">+ (충전)</option>
							<option value="-">- (차감)</option>
							</select>
							<input type="text" name="mb_sms" class="txt" id="mb_sms" value="" placeholder="0" data-v-min="0" data-v-max="10000000000"/> 건
						</td>
					</tr>
					</table>

					<dl class="pbtn">
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_sms','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>

<?php
			break;

			## 점프 서비스 충전
			case 'jump_charge':
				$service_member = $member_control->get_service_member($member['mb_id']);
?>
				<div id="pop_jump" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1003;">
				<form name="MemberJumpFrm" method="post" id="MemberJumpFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="jump_charge"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>

					<dl class="ntlt lnb_col m0" id="badnessFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">점프 서비스 수동 충전
						<span>점프 서비스를 수동으로 충전합니다.</span>
						<a onClick="MM_showHideLayers('pop_sms','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="700" class="bg_col">
					<col width=90><col>
					<tr>
						<td class="ctlt">점프 잔여</td>
						<td class="pdlnb2">
							<?php echo ($member['mb_type']=='individual') ? number_format($service_member['mb_resume_jump_count']) : number_format($service_member['mb_alba_jump_count']);?>건
						</td>
					</tr>
					<tr>
						<td class="ctlt">충전 건수</td>
						<td class="pdlnb2">
							<select name="charge_type">
							<option value="+">+ (충전)</option>
							<option value="-">- (차감)</option>
							</select>
							<input type="text" name="mb_jump" class="txt" id="mb_jump" value="" placeholder="0" data-v-min="0" data-v-max="10000000000"/> 건
						</td>
					</tr>
					</table>

					<dl class="pbtn">
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_jump','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>

<?php
			break;

		}	// switch end.
?>