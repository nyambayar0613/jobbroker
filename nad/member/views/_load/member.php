<?php
		/*
		* /application/nad/member/views/_load/member.php
		* @author Harimao
		* @since 2013/07/11
		* @last update 2015/03/31
		* @Module v3.5 ( Alice )
		* @Brief :: Member load layer
		* @Comment :: 회원정보에 지정에 다른 정보 추출
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];
		$mb_id = $_POST['mb_id'];

		if($mb_id)
			$member = $member_control->get_member($mb_id);	 // mb_id 기준
		else 
			$member = $member_control->get_memberNo($no);	// no 기준

		$mb_receive = explode(',',$member['mb_receive']);		// 수신여부
		$mb_receive_sms = (@in_array('sms',$mb_receive)) ? 'checked' : '';
		$mb_receive_email = (@in_array('email',$mb_receive)) ? 'checked' : '';
		$mb_receive_memo = (@in_array('memo',$mb_receive)) ? 'checked' : '';

		$level_name = $member_control->get_level($member['mb_level']);

		switch($mode){

			## 회원 정보보기
			case 'get_member':
				$page_name = $_POST['page_name'];
				$mb_type = $member['mb_type'];
				$company_member = $member_control->get_company_member($mb_id);	// 기업회원 정보
				$service_member = $member_control->get_service_member($mb_id);	 // 서비스 정보
				$photo_member = $member_control->get_photo_member($mb_id);	 // 포토 정보
				$mb_biz_paper = $alice['data_member_path']."/".$mb_id."/photos/".$photo_member['photo_name']; 
?>
				<div id="pop_mem" class="bocol lnb_col" style="top:10%;left:33%;display:;">
					<dl class="ntlt lnb_col m0 hand" id="memHandle">
						<img src="../../images/comn/bul_10.png" class="t">회원정보
						<a onClick="MM_showHideLayers('pop_mem','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  
					<table width="730" class="bg_col tf">
					<col width=100><col><col width=100><col>
					<tr>
						<td class="ctlt">아이디</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_id'];?></td>
						<td class="ctlt">이메일</td>
						<td class="pdlnb2 num11"><a onClick="pop_email('<?php echo $member['no'];?>');"><?php echo $member['mb_email'];?></a></td>
					</tr>
					<tr>
						<td class="ctlt">이름/레벨</td>
						<td class="pdlnb2"><?php echo $member['mb_name'] . ' / ' . $level_name;?></td>
						<td class="ctlt">닉네임</td>
						<td class="pdlnb2"><?php echo stripslashes($member['mb_nick']);?></td>
					</tr>
					<?php if($mb_type=='company'){ ?>
					<tr>
						<td class="ctlt">대표자명(ceo)</td>
						<td class="pdlnb2 num11"><?php echo stripslashes($company_member['mb_ceo_name']);?></td>
						<td class="ctlt">회사/점포명</td>
						<td class="pdlnb2 num11"><?php echo stripslashes($company_member['mb_company_name']);?></td>
					</tr>
					<tr>
						<td class="ctlt">회사분류</td>
						<td class="pdlnb2 num11"><?php echo $category_control->get_categoryCodeName($company_member['mb_biz_type']);?></td>
						<td class="ctlt">사업자번호</td>
						<td class="pdlnb2 num11"><?php echo $company_member['mb_biz_no'];?>
						<?php 
							if(is_file($mb_biz_paper)) { 
                               echo "<a href='".$mb_biz_paper."' target='_blank'>[사업자등록증보기]<a>";
							}
                        ?>						
						</td>
					</tr>
					<tr>
						<td class="ctlt">전화번호</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_phone'];?></td>
						<td class="ctlt">휴대폰</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_hphone'];?></td>
					</tr>
					<tr>
						<td class="ctlt">팩스번호</td>
						<td class="pdlnb2 num11"><?php echo $company_member['mb_biz_fax'];?></td>
						<td class="ctlt">홈페이지주소</td>
						<td class="pdlnb2 num11"><?php if($member['mb_homepage']){ ?><a href="<?php echo $member['mb_homepage'];?>" target="_blank"><?php echo $member['mb_homepage'];?></a><?php } ?></td>
					</tr>
					<tr>
						<td class="ctlt">상장여부</td>
						<td class="pdlnb2 num11"><?php echo $category_control->get_categoryCodeName($company_member['mb_biz_success']);?></td>
						<td class="ctlt">기업형태</td>
						<td class="pdlnb2 num11"><?php echo $category_control->get_categoryCodeName($company_member['mb_biz_form']);?></td>
					</tr>
					<tr>
						<td class="ctlt">설립년도</td>
						<td class="pdlnb2 num11"><?php echo $company_member['mb_biz_foundation'];?>년</td>
						<td class="ctlt">사원수</td>
						<td class="pdlnb2 num11"><?php echo number_format($company_member['mb_biz_member_count']);?>명</td>
					</tr>
					<tr>
						<td class="ctlt">자본금</td>
						<td class="pdlnb2 num11"><?php echo $company_member['mb_biz_stock'];?></td>
						<td class="ctlt">매출액</td>
						<td class="pdlnb2 num11"><?php echo $company_member['mb_biz_sale'];?></td>
					</tr>
					<tr>
						<td class="ctlt">주소</td>
						<td class="pdlnb2 num11" colspan="3"><?php echo "[".$member['mb_zipcode']."] ".$member['mb_address0']." ".$member['mb_address1'];?></td>
					</tr>
					<tr>
						<td class="ctlt">주요사업내용</td>
						<td class="pdlnb2 num11" colspan="3"><?php echo $company_member['mb_biz_content'];?></td>
					</tr>
					<tr>
						<td class="ctlt">기업개요 및 비전</td>
						<td class="pdlnb2 num11" colspan="3"><?php echo stripslashes($company_member['mb_biz_vision']);?></td>
					</tr>
					<tr>
						<td class="ctlt">기업연혁 및 실적</td>
						<td class="pdlnb2 num11" colspan="3"><?php echo stripslashes($company_member['mb_biz_result']);?></td>
					</tr>
					<tr>
						<td class="ctlt">공고등록수</td>
						<td class="pdlnb2 num11">
						<?php if($member['mb_alba_count']){ ?>
							<a href="../alba/index.php?mode=search&page_rows=30&search_field=wr_id&search_keyword=<?php echo $member['mb_id'];?>"><?php echo number_format($member['mb_alba_count']);?> 건</a>
						<?php } else { ?>
							0 건
						<?php } ?>
						</td>
						<td class="ctlt">이력서열람기간</td>
						<td class="pdlnb2 num11"><?php echo $service_member['mb_service_open'];?> 까지</td>
					</tr>
					<?php } else if($mb_type=='individual'){ 
						$mb_birth = explode('-',$member['mb_birth']);
					?>
					<tr>
						<td class="ctlt">생년월일</td>
						<td class="pdlnb2 num11"><?php echo $mb_birth[0]."년 ".$mb_birth[1]."월 ".$mb_birth[1]."일";?></td>
						<td class="ctlt">성별</td>
						<td class="pdlnb2 num11"><?php echo $member_control->mb_gender[$member['mb_gender']];?></td>
					</tr>
					<tr>
						<td class="ctlt">전화번호</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_phone'];?></td>
						<td class="ctlt">휴대폰</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_hphone'];?></td>
					</tr>
					<tr>
						<td class="ctlt">이력서등록수</td>
						<td class="pdlnb2 num11">
						<?php if($member['mb_alba_resume_count']){ ?>
							<a href="../alba/resume.php?mode=search&page_rows=15&search_field=wr_id&search_keyword=<?php echo $member['mb_id'];?>"><?php echo number_format($member['mb_alba_resume_count']);?> 건</a>
						<?php } else { ?>
							0 건
						<?php } ?>
						</td>
						<td class="ctlt">홈페이지주소</td>
						<td class="pdlnb2 num11"><?php if($member['mb_homepage']){ ?><a href="<?php echo $member['mb_homepage'];?>" target="_blank"><?php echo $member['mb_homepage'];?></a><?php } ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td class="ctlt">가입일</td>
						<td class="pdlnb2 num11"><?php echo strtr($member['mb_wdate'],'-','.');?></td>
						<td class="ctlt">최종로그인</td>
						<td class="pdlnb2 num11"><?php echo strtr($member['mb_last_login'],'-','.');?></td>
					</tr>
					<tr>
						<td class="ctlt">포인트</td>
						<td class="pdlnb2 num11"><?php echo number_format($member['mb_point']);?></td>
						<td class="ctlt">방문수</td>
						<td class="pdlnb2 num11"><?php echo number_format($member['mb_login_count']);?></td>
					</tr>
					<tr><td colspan="4" class="lnb wbg" height="5"></td></tr>
					<tr>
						<td class="ctlt">관리자메모</td>
						<td class="pdlnb2" colspan="3"><?php echo nl2br(stripslashes($member['mb_memo']));?></td>
					</tr>
					</table>

					<!-- <dl class="ntlt lnb_col">
						<img src="../../images/comn/bul_10.png" class="t">결제내역
						<span>최근 5건만 출력</span>
						<dt><a href="../payment/index.php?md_id=<?php echo $member['mb_id'];?>" class="btn"><h1 class="btn23">결제내역 전체보기</h1></a></dt>
					</dl>  

					<table width="730" class="ttlt">
					<col width=55><col><col span="2" width=75>
					<tr class="bg">
						<td>No</td>
						<td>결제정보</td>
						<td>결제일</td>
						<td class="e">진행상태</td>
					</tr>
					<?php if(!$pay_list){?>
					<tr><td colspan="5" class="stlt"></td></tr>
					<?php 
						} else {
							$pay_no = 0;
							foreach($pay_list as $_pay){
							$pay_no++;
							$pay_status = $payment_control->pay_status[$_pay['pay_status']];
					?>

					<tr>
						<td class="num3"><?php echo $pay_no;?></td>
						<td class="tl"><?php echo stripslashes($_pay['pay_info']);?></td>
						<td class="num3"><?php echo substr($_pay['pay_wdate'],0,11);?></td>
						<td class="e"><?php echo $pay_status;?></td>
					</tr>
					<?php 
							}	// foreach end.
						}	// if end.
					?> -->
					</table>

					<dl class="pbtn">  
						<a onClick="MM_showHideLayers('pop_mem','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>
<?php
			break;

			## 회원정보입력/수정
			case 'insert':
			case 'update':

				$level_list = $category_control->__CategoryList('mb_level');	// 회원 가입시 기본 그룹 지정 카테고리

				$insert_mb_type = ($_POST['mb_type']) ? $_POST['mb_type'] : "individual";

				$mb_type = ($mode=='insert') ? $insert_mb_type : $member['mb_type'];

				$mb_types = ($mb_type=='individual') ? "개인" : "기업";
				$mb_birth = explode('-',$member['mb_birth']);
				$mb_phone = explode('-',$member['mb_phone']);
				$mb_hphone = explode('-',$member['mb_hphone']);
				$mb_zipcode = explode('-',$member['mb_zipcode']);

				$tel_num_option = "";	 //전화번호
				foreach($config->tel_num as $tel){
					$selected = ($tel==$mb_phone[0]) ? 'selected' : '';
					$tel_num_option .= "<option value='".$tel."' ".$selected.">".$config->local_num[$tel]."</option>";
				}

				$hp_num_option = "";	 //휴대폰 번호
				foreach($config->hp_num as $hp){
					$selected = ($hp==$mb_hphone[0]) ? 'selected' : '';
					$hp_num_option .= "<option value='".$hp."' ".$selected.">".$hp."</option>";
				}

				$email_list = $category_control->category_codeList('email', " `rank` asc ");
				$email_option = "";	//이메일
				foreach($email_list as $email){
					$email_option .= "<option value='".$email['name']."'>".$email['name']."</option>";
				}

?>
				<div id="add_form" class="bocol lnb_col" style="top:5%;left:33%;display:none;">
				<form name="MemberFrm" method="post" id="MemberFrm" action="./process/regist.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="<?php echo $mode;?>" id="mode"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<?php if($mode=='update'){ ?>
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<!-- <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/> -->
				<!-- <input type="hidden" name="mb_type" value="<?//php echo $mb_type;?>" id="mb_type"/> -->
				<input type="hidden" name="mb_level" value="<?php echo $member['mb_level'];?>"/>
				<?php } ?>
				<input type="hidden" name="return_regist" id="return_regist"/>
				<input type="hidden" name="mb_photos" id="mb_photos"/>

					<dl class="ntlt lnb_col m0 hand" id="memberFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t"><?php echo $mb_types;?>회원 정보<?php echo ($mode=='insert')?'입력':'수정';?>
						<span>( <b class="col">*</b> 표시는 필수 입력사항 )</span>
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<table width="<?php echo ($mb_type=='individual')?'700':'750';?>" class="bg_col">
					<col width=100><col>
					<tr>
						<td class="ctlt">회원구분</td>
						<td class="pdlnb2">
							<?php if($mode=='insert'){	 // 입력일때 ?>
							<input type="radio" value="individual" name="mb_type" id="mb_type_individual" required hname="개인회원" checked  onclick="mb_types(this);">
							<label for="mb_type_individual">개인회원</label>
							<input type="radio" value="company" name="mb_type" id="mb_type_company" required hname="기업회원" <?php echo ($mb_type=='company')?'checked':'';?> onclick="mb_types(this);">
							<label for="mb_type_company">기업회원</label>
							<?php } else {	// 수정일때 
								echo ($mb_type=='individual') ? "개인회원" : "기업회원";
							?>
							<input type="hidden" name="mb_type" value="<?php echo $mb_type;?>" id="mb_type"/>
							<?php } ?>
						</td>
					</tr>
					</table>

					<?php if($mb_type=='individual'){ // 개인회원 폼?>

					<div class="lnb_col positionA" style="border:2px solid #ddd; background:#fff; width:450px; top:20%;left:35%;text-align:left;display:none;z-index:9999;" id="postSearchPop">
						<dl>
							<dt style="padding:20px 15px;cursor:pointer;" class="bg_gray1" id="postSearchPop_handle">
								<strong>우편번호 검색</strong>
								<em class="closeBtn" onclick="postClose();"><img width="11" height="11" class="pb5" src="../../images/icon/icon_close2.gif" alt="arrow"></em>
							</dt>

							<dd style="padding:20px 15px 30px;width:420px;height:275px;" id="addressResult"></dd>

						</dl>
					</div>

					<table width="700" class="bg_col">
					<col width=100><col>
					<tr>
						<td class="ctlt">아이디 <b class="col">*</b></td>
						<td class="pdlnb2">
							<input name="mb_id" type="text" class="tnum w50" value="<?php echo $member['mb_id'];?>" required hname='아이디' <?php echo ($mode=='update')?'readonly':'';?>>
							<?php if($mode=='update') { ?><span class="subtlt">아이디는 수정이 불가능 합니다.</span><?php } ?>
						</td>
					</tr>
					<tr>
						<td class="ctlt">비밀번호 <?php if($mode=='insert'){?><b class="col">*</b><?php } ?></td>
						<td class="pdlnb2">
							<input name="mb_password" type="password" class="tnum w50" <?php echo ($mode=='insert')?"required hname='비밀번호'":"";?>>
							<span class="subtlt">암호화 되어 저장 됩니다.</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">기본프로필 사진</td>
						<td class="pdlnb2">
							<input name="photo_file" type="file" class="tnum w50">
							<span class="subtlt">100*130픽셀, 100KB 용량 이내로 등록해 주세요.</span>							
						</td>
					</tr>
					<tr>
						<td class="ctlt">회원등급 <b class="col">*</b></td>
						<td class="pdlnb2">
							<select style="width:200px;" name="mb_level" required hname='회원등급'>
								<option value=''>회원등급선택</option>
								<?php foreach($level_list as $level){ if($level['rank']==1) continue; ?>
								<option value='<?php echo $level['rank'];?>' <?php echo ($member['mb_level']==$level['rank'])?'selected':'';?>><?php echo $level['name'];?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="ctlt">이름 <b class="col">*</b></td>
						<td class="pdlnb2"><input name="mb_name" type="text" class="txt w50" value="<?php echo stripslashes($member['mb_name']);?>" required hname='이름' style="ime-mode:active;"></td>
					</tr>
					<tr>
						<td class="ctlt">생년월일/성별 <b class="col">*</b></td>
						<td class="pdlnb2">
							<select title="년도선택" name="mb_birth_year" id="mb_birth_year" style="width:80px" required hname="생년">
							<option value="">년도</option>
							<?php for($i=date('Y')-15;$i>=1900;--$i){ ?>
								<option value='<?=$i?>' <?php echo ($mb_birth[0]==$i)?'selected':'';?>><?=$i?></option>
							<?php } ?>
							</select> 년 
							<select title="월 선택" name="mb_birth_month" id="mb_birth_month" style="width:59px" required hname="생월">
							<option value="">월</option>
							<?php for($i=1;$i<=12;$i++){?>
							<option value="<?php echo sprintf('%02d',$i);?>" <?php echo ($mb_birth[1]==sprintf('%02d',$i))?'selected':'';?>><?php echo sprintf('%02d',$i);?></option>
							<?php } ?>
							</select> 월 
							<select title="일 선택" name="mb_birth_day" id="mb_birth_day" style="width:59px" required hname="생일">
							<option value="">일</option>
							<?php for($i=1;$i<=31;$i++){?>
							<option value="<?php echo sprintf('%02d',$i);?>" <?php echo ($mb_birth[2]==sprintf('%02d',$i))?'selected':'';?>><?php echo sprintf('%02d',$i);?></option>
							<?php } ?>
							</select> 일 
							<input type="radio" value="0" name="mb_gender" id="mb_gender_0" required hname="성별" checked>
							<label for="mb_gender_0">남</label>
							<input type="radio" value="1" name="mb_gender" id="mb_gender_1" required hname="성별" <?php echo ($member['mb_gender'])?'checked':'';?>>
							<label for="mb_gender_1">여</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">닉네임 <b class="col">*</b></td>
						<td class="pdlnb2"><input name="mb_nick" type="text" class="txt w50" value="<?php echo stripslashes($member['mb_nick']);?>" required hname='닉네임' style="ime-mode:active;"></td>
					</tr>
					<tr>
						<td class="ctlt">전화번호 <b class="col">*</b></td>
						<td class="pdlnb2">
							<select style="width:95px;" id="mb_phone0" name="mb_phone[]" title="지역번호 선택" required hname="지역번호">
							<option value="">지역번호 선택</option>
							<?php echo $tel_num_option; ?>
							</select>
							<span class="delimiter">-</span>
							<input style="width:95px;" type="text" class="tnum" title="전화번호 앞자리" maxlength="4" id="mb_phone1" name="mb_phone[]" required hname="전화번호 앞자리" value="<?php echo $mb_phone[1];?>">
							<span class="delimiter">-</span>
							<input style="width:95px;" type="text" class="tnum" title="전화번호 뒷자리" maxlength="4" id="mb_phone2" name="mb_phone[]" required hname="전화번호 뒷자리" value="<?php echo $mb_phone[2];?>">
						</td>
					</tr>
					<tr>
						<td class="ctlt">휴대폰</td>
						<td class="pdlnb2">
							<select style="width:95px;" id="mb_hphone0" name="mb_hphone[]" title="휴대폰 국번">
							<?php echo $hp_num_option; ?>
							</select>
							<span class="delimiter">-</span>
							<input style="width:95px;" type="text" class="tnum" title="휴대폰 앞자리" maxlength="4" id="mb_hphone1" name="mb_hphone[]" hname="휴대폰 앞자리" value="<?php echo $mb_hphone[1];?>">
							<span class="delimiter">-</span>
							<input style="width:95px;" type="text" class="tnum" title="휴대폰 뒷자리" maxlength="4" id="mb_hphone2" name="mb_hphone[]" hname="휴대폰 뒷자리" value="<?php echo $mb_hphone[2];?>">
							<label><input type="checkbox" class="typeCheckbox" id="mb_receive_sms" name="mb_receive[]" value="sms" <?php echo $mb_receive_sms;?>> SMS 수신</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">주소 <b class="col">*</b></td>
						<td class="pdlnb2">

							<div class="addresWrap" id="address_block">
								<input type="text" style="width:55px;" class="tnum" title="우편번호 앞자리" maxlength="3" id="mb_zipcode0" name="mb_zipcode[]" readonly <?//php echo (!$member['mb_address_road'])?'required':'';?> hname="우편번호 앞자리" value="<?php echo $mb_zipcode[0];?>">
								<span class="delimiter">-</span>
								<input type="text" style="width:55px;" class="tnum" title="우편번호 뒷자리" maxlength="4" id="mb_zipcode1" name="mb_zipcode[]" readonly <?//php echo (!$member['mb_address_road'])?'required':'';?> hname="우편번호 뒷자리" value="<?php echo $mb_zipcode[1];?>">
								<a class="btn" style="padding:0 10px;" onclick="execDaumPostcode();"><span>우편번호 검색</span></a>
								<div class="adress2 mt3">
									<input type="text" class="tnum w100 mb3" title="주소" id="mb_address0" name="mb_address0" <?//php echo (!$member['mb_address_road'])?'required':'';?> hname="주소" value="<?php echo $member['mb_address0'];?>">
									<input type="text" class="tnum w100" title="상세주소" id="mb_address1" name="mb_address1" <?//php echo (!$member['mb_address_road'])?'required':'';?> hname="상세주소" value="<?php echo $member['mb_address1'];?>">
								</div>
							</div>

						</td>
					</tr>
					<tr>
						<td class="ctlt">이메일 <b class="col">*</b></td>
						<td class="pdlnb2">
							<input name="mb_email" type="text" class="tnum w50" value="<?php echo stripslashes($member['mb_email']);?>" required hname='이메일'>
							<label><input type="checkbox" class="typeCheckbox" id="mb_receive_email" name="mb_receive[]" value="email" <?php echo $mb_receive_email;?>> 이메일 수신</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">홈페이지주소</td>
						<td class="pdlnb2">
							<input name="mb_homepage" type="text" class="tnum w50" value="<?php echo $utility->add_http($member['mb_homepage']);?>"/>
						</td>
					</tr>
					<tr>
						<td class="ctlt">쪽지수신</td>
						<td class="pdlnb2"><label><input type="checkbox" class="typeCheckbox" id="mb_receive_memo" name="mb_receive[]" value="memo" <?php echo $mb_receive_memo;?>> 회원간 쪽지 수신</label></td>
					</tr>
					<tr>
						<td class="ctlt">관리자메모</td>
						<td class="pdlnb2">
							<dl class="twrap"><textarea name="mb_memo" style="height:80px"><?php echo stripslashes($member['mb_memo']);?></textarea></dl>
						</td>
					</tr>
					</table>

					<script>
					var element_layer = document.getElementById('addressResult');

					// 우편번호 찾기 화면을 넣을 element
					function execDaumPostcode() {
						
						new daum.Postcode({
							oncomplete: function(data) {

								// 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

								// 각 주소의 노출 규칙에 따라 주소를 조합한다.
								// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
								var fullAddr = data.address; // 최종 주소 변수
								var extraAddr = ''; // 조합형 주소 변수
								var printAddr = '';	// 상세 구주소

								// 기본 주소가 도로명 타입일때 조합한다.
								if(data.addressType === 'R'){
									//법정동명이 있을 경우 추가한다.
									if(data.bname !== ''){
										extraAddr += data.bname;
									}
									// 건물명이 있을 경우 추가한다.
									if(data.buildingName !== ''){
										extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
									}
									// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
									//fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
									printAddr += (extraAddr !== '' ? '('+ extraAddr +')' : '');
								}
								
					//새 우편번호 5자리로 교체
					var p_str = data.zonecode;
					var postzip1 = p_str.substr(0,3);
					var postzip2 = p_str.substr(3,2);
					
					$('#mb_zipcode0').val( postzip1 );
					$('#mb_zipcode1').val( postzip2 );
								$('#mb_address0').val( fullAddr );
								$('#mb_address1').val( printAddr );

								// iframe을 넣은 element를 안보이게 한다.
								//element_layer.style.display = 'none';
								$('#postSearchPop').hide();

							},
							width : '100%',
							height : '100%'
						}).embed(element_layer);

						// iframe을 넣은 element를 보이게 한다.
						$('#postSearchPop').show();
					}
					</script>

					<?php } else if($mb_type=='company'){	// 기업회원 폼 

						$use_map = $env['use_map'];
						$daum_local_key = $env['daum_local_key'];
						$naver_map_key = $env['naver_map_key'];

						//$company_info = $member_control->get_company_member($member['mb_id']);
						$get_company = $user_control->get_company($member['mb_id']);	// 대표 기업정보
						$company_info = $user_control->get_member_company($get_company['mb_id']);	// 기업회원 정보

						$biz_type_list = $category_control->category_codeList('biz_type', " `rank` asc ");
						$biz_type_option = "";	//회사분류
						foreach($biz_type_list as $biz_type){
							$selected = ($biz_type['code']==$company_info['mb_biz_type'])?'selected':'';
							$biz_type_option .= "<option value='".$biz_type['code']."' ".$selected.">".$biz_type['name']."</option>";
						}
						$mb_biz_no = explode('-',$company_info['mb_biz_no']);
						$mb_biz_fax = explode('-',$company_info['mb_biz_fax']);

						$biz_success = $category_control->category_codeList('biz_success', " `rank` asc ");
						$biz_success_option = "";	//상장여부
						foreach($biz_success as $option){
							$selected = ($option['code']==$company_info['mb_biz_success'])?'selected':'';
							$biz_success_option .= "<option value='".$option['code']."' ".$selected.">".$option['name']."</option>";
						}
						$biz_form = $category_control->category_codeList('biz_form', " `rank` asc ");
						$biz_form_option = "";	//기업형태
						foreach($biz_form as $option){
							$selected = ($option['code']==$company_info['mb_biz_form'])?'selected':'';
							$biz_form_option .= "<option value='".$option['code']."' ".$selected.">".$option['name']."</option>";
						}
						$foundation_option = "";	 //설립연도
						for($i=date('Y');$i>=1900;--$i){
							$selected = ($i==$company_info['mb_biz_foundation'])?'selected':'';
							$foundation_option .= "<option value='".$i."' ".$selected.">".$i." 년</option>";
						}


					?>
						
					<input type="hidden" name="mb_latlng" id="mb_latlng" value="<?php echo $company_info['mb_latlng'];?>"/>
					<input type="hidden" name="company_no" value="<?php echo $get_company['no'];?>"/>

					<div class="lnb_col positionA" style="border:2px solid #ddd; background:#fff; width:450px; top:20%;left:40%;text-align:left;display:none;z-index:9999;" id="postSearchPop">
						<dl>
							<dt style="padding:20px 15px;cursor:pointer;" class="bg_gray1" id="postSearchPop_handle">
								<strong>우편번호 검색</strong>
								<em class="closeBtn" onclick="postClose();"><img width="11" height="11" class="pb5" src="../../images/icon/icon_close2.gif" alt="arrow"></em>
							</dt>

							<dd style="padding:20px 15px 30px;width:425px;height:275px;" id="addressResult"></dd>

							<div class="mt5" id="mapBlock" style="display:none;">
								<table cellpadding="0" cellspacing="0" align="center">
								<tr><td style="padding:15px 0 10px;"><b>회사위치(약도)</b> - 클릭시 위치가 지정됩니다.</td></tr>
								<tr>
									<td>
										<div style="border:3px solid <?php echo $map_color;?>">
											<div id="map" style="width:420px;height:230px;"></div>
										</div>
									</td>
								</tr>
								<tr align="center">
									<td style="padding-top:10px;">
										<img src="../../images/btn/btn23_ok.gif" align="absmiddle" style='cursor:pointer;' class='close' onclick="postClose();">
										<img src="../../images/btn/btn23_08.gif" align="absmiddle" style='cursor:pointer;' class='close' onclick="postClose();">
									</td>
								</tr>
								</table>
							</div>

						</dl>
					</div>

					<table width="750" class="bg_col">
					<col width=100><col>
					<tr>
						<td class="ctlt">아이디 <b class="col">*</b></td>
						<td class="pdlnb2">
							<input name="mb_id" type="text" class="tnum w50" value="<?php echo $member['mb_id'];?>" required hname='아이디' <?php echo ($mode=='update')?'readonly':'';?>>
							<?php if($mode=='update') { ?><span class="subtlt">아이디는 수정이 불가능 합니다.</span><?php } ?>
						</td>
					</tr>
					<tr>
						<td class="ctlt">비밀번호 <?php if($mode=='insert'){?><b class="col">*</b><?php } ?></td>
						<td class="pdlnb2">
							<input name="mb_password" type="password" class="tnum w50" <?php echo ($mode=='insert')?"required hname='비밀번호'":"";?>>
							<span class="subtlt">암호화 되어 저장 됩니다.</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">회원등급 <b class="col">*</b></td>
						<td class="pdlnb2">
							<select style="width:200px;" name="mb_level" required hname='회원등급'>
								<option value=''>회원등급선택</option>
								<?php foreach($level_list as $level){ if($level['rank']==1) continue; ?>
								<option value='<?php echo $level['rank'];?>' <?php echo ($member['mb_level']==$level['rank'])?'selected':'';?>><?php echo $level['name'];?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="ctlt">가입자명 <b class="col">*</b></td>
						<td class="pdlnb2"><input name="mb_name" type="text" class="txt w50" value="<?php echo stripslashes($member['mb_name']);?>" required hname='가입자명' style="ime-mode:active;"></td>
					</tr>
					<tr>
						<td class="ctlt">회사로고</td>
						<td class="pdlnb2">
							<input name="mb_logo" type="file" class="tnum w50">
							<span class="subtlt">200*100픽셀, 100KB 용량 이내로 등록해 주세요.</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">대표자명(ceo) <b class="col">*</b></td>
						<td class="pdlnb2"><input name="mb_ceo_name" type="text" class="txt w50" value="<?php echo stripslashes($company_info['mb_ceo_name']);?>" required hname='대표자명' style="ime-mode:active;"></td>
					</tr>
					<tr>
						<td class="ctlt">닉네임 <b class="col">*</b></td>
						<td class="pdlnb2"><input name="mb_nick" type="text" class="txt w50" value="<?php echo stripslashes($member['mb_nick']);?>" required hname='닉네임' style="ime-mode:active;"></td>
					</tr>
					<tr>
						<td class="ctlt">회사/점포명 <b class="col">*</b></td>
						<td class="pdlnb2"><input name="mb_company_name" type="text" class="txt w50" value="<?php echo stripslashes($company_info['mb_company_name']);?>" required hname='회사/점포명' style="ime-mode:active;"></td>
					</tr>
					<tr>
						<td class="ctlt">회사분류 <b class="col">*</b></td>
						<td class="pdlnb2">
							<select style="width:200px;" id="mb_biz_type" name="mb_biz_type" title="회사분류 선택" required hname="회사분류">
							<option value="">회사분류 선택</option>
							<?php echo $biz_type_option; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="ctlt">전화번호 <b class="col">*</b></td>
						<td class="pdlnb2">
							<select style="width:95px;" id="mb_phone0" name="mb_phone[]" title="지역번호 선택" required hname="지역번호">
							<option value="">지역번호 선택</option>
							<?php echo $tel_num_option; ?>
							</select>
							<span class="delimiter">-</span>
							<input style="width:95px;" type="text" class="tnum" title="전화번호 앞자리" maxlength="4" id="mb_phone1" name="mb_phone[]" required hname="전화번호 앞자리" value="<?php echo $mb_phone[1];?>">
							<span class="delimiter">-</span>
							<input style="width:95px;" type="text" class="tnum" title="전화번호 뒷자리" maxlength="4" id="mb_phone2" name="mb_phone[]" required hname="전화번호 뒷자리" value="<?php echo $mb_phone[2];?>">
						</td>
					</tr>
					<tr>
						<td class="ctlt">휴대폰</td>
						<td class="pdlnb2">
							<select style="width:95px;" id="mb_hphone0" name="mb_hphone[]" title="휴대폰 국번">
							<?php echo $hp_num_option; ?>
							</select>
							<span class="delimiter">-</span>
							<input style="width:95px;" type="text" class="tnum" title="휴대폰 앞자리" maxlength="4" id="mb_hphone1" name="mb_hphone[]" hname="휴대폰 앞자리" value="<?php echo $mb_hphone[1];?>">
							<span class="delimiter">-</span>
							<input style="width:95px;" type="text" class="tnum" title="휴대폰 뒷자리" maxlength="4" id="mb_hphone2" name="mb_hphone[]" hname="휴대폰 뒷자리" value="<?php echo $mb_hphone[2];?>">
							<label><input type="checkbox" class="typeCheckbox" id="mb_receive_sms" name="mb_receive[]" value="sms" <?php echo $mb_receive_sms;?>> SMS 수신</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">회사/점포 주소 <b class="col">*</b></td>
						<td class="pdlnb2">

							<div class="addresWrap" id="address_block">
								<input type="text" style="width:55px;" class="tnum" title="우편번호 앞자리" maxlength="3" id="mb_zipcode0" name="mb_zipcode[]" readonly <?//php echo (!$member['mb_address_road'])?'required':'';?> hname="우편번호 앞자리" value="<?php echo $mb_zipcode[0];?>">
								<span class="delimiter">-</span>
								<input type="text" style="width:55px;" class="tnum" title="우편번호 뒷자리" maxlength="4" id="mb_zipcode1" name="mb_zipcode[]" readonly <?//php echo (!$member['mb_address_road'])?'required':'';?> hname="우편번호 뒷자리" value="<?php echo $mb_zipcode[1];?>">
								<a class="btn" style="padding:0 10px;" onclick="execDaumPostcode();"><span>우편번호 검색</span></a>
								<div class="adress2 mt3">
									<input type="text" class="tnum w100 mb3" title="주소" id="mb_address0" name="mb_address0" <?//php echo (!$member['mb_address_road'])?'required':'';?> hname="주소" value="<?php echo $member['mb_address0'];?>">
									<input type="text" class="tnum w100" title="상세주소" id="mb_address1" name="mb_address1" <?//php echo (!$member['mb_address_road'])?'required':'';?> hname="상세주소" value="<?php echo $member['mb_address1'];?>">
								</div>
							</div>

						</td>
					</tr>
					<tr>
						<td class="ctlt">사업자번호</td>
						<td class="pdlnb2">
							<input type="text"  style="width:50px;" class="tnum" title="사업자번호1" maxlength="3" id="mb_biz_no0" name="mb_biz_no[]" value="<?php echo $mb_biz_no[0];?>" hname="사업자번호"> 
							<span class="delimiter">-</span> 
							<input type="text" style="width:40px;" class="tnum" title="사업자번호2" maxlength="2" id="mb_biz_no1" name="mb_biz_no[]" value="<?php echo $mb_biz_no[1];?>" hname="사업자번호"> 
							<span class="delimiter">-</span> 
							<input type="text" style="width:70px;" class="tnum" title="사업자번호3" maxlength="5" id="mb_biz_no2" name="mb_biz_no[]" value="<?php echo $mb_biz_no[2];?>" hname="사업자번호">
						</td>
					</tr>
					<tr>
						<td class="ctlt">팩스번호</td>
						<td class="pdlnb2">
							<select style="width:95px;" id="mb_biz_fax0" name="mb_biz_fax[]" title="지역번호 선택" hname="팩스 지역번호">
							<option value="">지역번호 선택</option>
							<?php echo $tel_num_option; ?>
							</select> 
							<span class="delimiter">-</span> 
							<input style="width:95px;" type="text" class="tnum" title="팩스번호 앞자리" maxlength="4" id="mb_biz_fax1" name="mb_biz_fax[]" hname="팩스번호 앞자리" value="<?php echo $mb_biz_fax[1];?>"> 
							<span class="delimiter">-</span> 
							<input style="width:95px;" type="text" class="tnum" title="팩스번호 뒷자리" maxlength="4" id="mb_biz_fax2" name="mb_biz_fax[]" hname="팩스번호 뒷자리" value="<?php echo $mb_biz_fax[2];?>">
						</td>
					</tr>
					<tr>
						<td class="ctlt">홈페이지주소</td>
						<td class="pdlnb2">
							<input name="mb_homepage" type="text" class="tnum w50" value="<?php echo $utility->add_http($member['mb_homepage']);?>"/>
						</td>
					</tr>
					<tr>
						<td class="ctlt">e-mail <b class="col">*</b></td>
						<td class="pdlnb2">
							<input name="mb_email" type="text" class="tnum w50" value="<?php echo stripslashes($member['mb_email']);?>" required hname='이메일'>
							<label><input type="checkbox" class="typeCheckbox" id="mb_receive_email" name="mb_receive[]" value="email" <?php echo $mb_receive_email;?>> 이메일 수신</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">상장여부</td>
						<td class="pdlnb2">
							<select style="width:200px;" id="mb_biz_success" name="mb_biz_success" title="상장여부 선택" hname="상장여부">
							<option value="">상장여부 선택</option>
							<?php echo $biz_success_option;?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="ctlt">기업형태</td>
						<td class="pdlnb2">
							<select style="width:200px;" id="mb_biz_form" name="mb_biz_form" title="기업형태 선택" hname="기업형태">
							<option value="">기업형태 선택</option>
							<?php echo $biz_form_option;?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="ctlt">주요사업내용</td>
						<td class="pdlnb2">
							<input type="text" maxlength="16" class="tnum" style="width:350px;" id="mb_biz_content" name="mb_biz_content" value="<?php echo $company_info['mb_biz_content'];?>"> <span class="subtlt">(예 : 네트워크 트래픽 관리제품 개발 및 판매)</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">설립년도</td>
						<td class="pdlnb2">
							<select style="width:200px;" id="mb_biz_foundation" name="mb_biz_foundation" title="설립연도 선택" hname="설립연도">
							<option value="">선택</option>
							<?php echo $foundation_option;?>
							</select> 설립
						</td>
					</tr>
					<tr>
						<td class="ctlt">사원수</td>
						<td class="pdlnb2">
							<input type="text" maxlength="16" class="tnum" style="width:200px;" id="mb_biz_member_count" name="mb_biz_member_count" hname="사원수" value="<?php echo $company_info['mb_biz_member_count'];?>"> 명 <span class="subtlt">(예 : 200)</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">자본금</td>
						<td class="pdlnb2">
							<input type="text" maxlength="16" class="tnum" style="width:200px;" id="mb_biz_stock" name="mb_biz_stock" hname="자본금" value="<?php echo $company_info['mb_biz_stock'];?>"> 원 <span class="subtlt">(예 : 3억 5천만)</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">매출액</td>
						<td class="pdlnb2">
							<input type="text" maxlength="16" class="tnum" style="width:200px;" id="mb_biz_sale" name="mb_biz_sale" hname="매출액" value="<?php echo $company_info['mb_biz_sale'];?>"> 원 <span class="subtlt">(예 : 3억 5천만)</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">기업개요 및 비전</td>
						<td class="pdlnb2"><?php echo $utility->make_cheditor('mb_biz_vision',$company_info['mb_biz_vision']);?></td>
					</tr>
					<tr>
						<td class="ctlt">기업연혁 및 실적</td>
						<td class="pdlnb2"><?php echo $utility->make_cheditor('mb_biz_result',$company_info['mb_biz_result']);?></td>
					</tr>
					<tr>
						<td class="ctlt">쪽지수신</td>
						<td class="pdlnb2"><label><input type="checkbox" class="typeCheckbox" id="mb_receive_memo" name="mb_receive[]" value="memo" <?php echo $mb_receive_memo;?>> 회원간 쪽지 수신</label></td>
					</tr>
					<tr>
						<td class="ctlt">관리자메모</td>
						<td class="pdlnb2">
							<dl class="twrap"><textarea name="mb_memo" style="height:80px"><?php echo stripslashes($member['mb_memo']);?></textarea></dl>
						</td>
					</tr>
					</table>

					<script>
					<?php if($use_map=='daum'){ ?>

					<?php } ?>
						var element_layer = document.getElementById('addressResult');

						// 우편번호 찾기 화면을 넣을 element
						function execDaumPostcode() {
							
							// 초기화
							//$('#map').html("");	
							$('#mapBlock').hide();
							$('#addressResult').show();

							new daum.Postcode({
								oncomplete: function(data) {
									// 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
									// 각 주소의 노출 규칙에 따라 주소를 조합한다.
									// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
									var fullAddr = data.address; // 최종 주소 변수
									var extraAddr = ''; // 조합형 주소 변수
									var printAddr = '';	// 상세 구주소
									// 기본 주소가 도로명 타입일때 조합한다.
									if(data.addressType === 'R'){
										//법정동명이 있을 경우 추가한다.
										if(data.bname !== ''){
											extraAddr += data.bname;
										}
										// 건물명이 있을 경우 추가한다.
										if(data.buildingName !== ''){
											extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
										}
										// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
										//fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
										printAddr += (extraAddr !== '' ? '('+ extraAddr +')' : '');
									}
					//새 우편번호 5자리로 교체
					var p_str = data.zonecode;
					var postzip1 = p_str.substr(0,3);
					var postzip2 = p_str.substr(3,2);
					
					$('#mb_zipcode0').val( postzip1 );
					$('#mb_zipcode1').val( postzip2 );
									$('#mb_address0').val( fullAddr );
									$('#mb_address1').val( printAddr );
								<?php if($use_map=='daum'){ ?>
									var mapContainer = document.getElementById('map'), // 지도를 표시할 div 

										mapOption = {
											center: new daum.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
											level: 3 // 지도의 확대 레벨
										};  

									// 지도를 생성합니다    
									var map = new daum.maps.Map(mapContainer, mapOption); 

									// 주소-좌표 변환 객체를 생성합니다
									var geocoder = new daum.maps.services.Geocoder();

									// 주소로 좌표를 검색							
									geocoder.addressSearch(data.address, function(result, status) {
										$('#addressResult').hide();
										$('#mapBlock').show();
										
										if (status === daum.maps.services.Status.OK) {
											
											$('#mb_latlng').val(result[0].y +","+result[0].x);
											
											var coords = new daum.maps.LatLng(result[0].y, result[0].x);

											map.relayout();

											var marker = new daum.maps.Marker({
												map: map,
												position: coords
											});

											map.setCenter(coords);									
										}
									});
								<?php } else if($use_map=='naver'){ ?>
									$('#map').html("");
									$('#addressResult').hide();
									$('#mapBlock').show();
									var search_addr = fullAddr;
									$.post('./views/_ajax/post_search.php', { mode:'naver_map_search', search_addr:search_addr }, function(result){
										var data = eval("(" + result + ")");
										var point_y = data.mapy;
										var point_x = data.mapx;
										map_api.map_use("map", "", true);	// 지도 띄우기
										map_api.map_location_move(point_x,point_y);
										map_api.marker_false();
										map_api.addMark();
										map_api.click_event();
										$('#mb_latlng').val( point_x+","+point_y );	// 좌표값 할당
									});
								<?php } else if($use_map=='google'){ ?>
									$('#map').html("");
									$('#addressResult').hide();
									$('#mapBlock').show();
									var search_addr = fullAddr;
									$.post('./views/_ajax/post_search.php', { mode:'google_map_search', search_addr:search_addr }, function(result){
										point = result.split('/');
										$('#mb_latlng').val(point[0]+","+point[1]);
										map_api.map_point = [point[0],point[1],'18'];
										map_api.map_use("map", "", true);
										map_api.click_event();
										map_api.addMark();
										$('#mb_latlng').val(point[0]+","+point[1]);	// 좌표값 할당
									});
								<?php } ?>
									// iframe을 넣은 element를 안보이게 한다.
									//element_layer.style.display = 'none';
									//$('#postSearchPop').hide();
								},
								width : '100%',
								height : '100%'
							}).embed(element_layer);

							// iframe을 넣은 element를 보이게 한다.
							$('#postSearchPop').show();
						}
					</script>

					<?php } ?>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onclick="MemberFrm_Submit();"><?php if($mb_type=='company'){ ?><img src="../../images/btn/19_23.gif" alt="저장후 공고 등록"/><?php } else if($mb_type=='individual'){ ?><img src="../../images/btn/19_23.gif" alt="저장후 이력서 등록"/><?php } ?></a>
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

				</form>
				</div>
<?php
			break;

			## 맞춤인재정보 수정 레이어
			case 'custom_individual':
			$custom = $alba_company_control->get_custom($no);
			$job_type_list = $category_control->category_codeList('job_type');		// 직종
			$wr_job_type0 = $custom['wr_job_type0'];
			$wr_job_type1 = $custom['wr_job_type1'];
			$wr_job_type2 = $custom['wr_job_type2'];
			$area_list = $category_control->category_codeList('area');					// 지역
			$wr_area0 = $custom['wr_area0'];
			$wr_area1 = $custom['wr_area1'];
			$alba_date_list = $category_control->category_codeList('alba_date');	// 알바근무기간
			$alba_week_list = $category_control->category_codeList('alba_week');	// 알바근무요일
			$alba_time_list = $category_control->category_codeList('alba_time');	// 알바근무시간
			$work_type_list = $category_control->category_codeList('work_type');	// 근무형태
			$wr_work_type = explode(',',$custom['wr_work_type']);		// 근무형태
			$wr_age_limit = $custom['wr_age_limit'];
			$wr_age = explode('-',$custom['wr_age']);
			$wr_age_etc = explode(',',$custom['wr_age_etc']);

?>
				<div id="pop_custom" class="bocol lnb_col" style="top:10%;left:33%;display:;">
				<form name="CustomFrm" method="post" id="CustomFrm" action="./process/custom.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="individual_update" id="mode"/>
				<input type="hidden" name="ajax" value="1" id="ajax"/>
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="mb_id" value="<?php echo $mb_id;?>"/>

					<dl class="ntlt lnb_col m0 hand" id="customHandle">
						<img src="../../images/comn/bul_10.png" class="t">맞춤인재정보 수정
						<a onClick="MM_showHideLayers('pop_custom','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  
					<table width="730" class="bg_col tf">
					<col width="100"><col width="180"><col width=100><col>
					<tr>
						<td class="ctlt">아이디</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_id'];?></td>
						<td class="ctlt">이름</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_name'];?></td>
					</tr>
					<tr>
						<td class="ctlt">업직종</td>
						<td class="pdlnb2 num11" colspan="3">
							<select class="ipSelect" style="width:180px;" id="wr_job_type0" name="wr_job_type0" title="1차직종선택" onchange="job_type_sel_first(this,'wr_job_type1');" hname="1차직종">
							<option value="">= 1차 직종선택 =</option>
							<?php 
							if($job_type_list){
								foreach($job_type_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($wr_job_type0 == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php 
								}	// foreach end.
							} // if end.
							?>
							</select>
							<span id="wr_job_type1_display">
								<select class="ipSelect" style="width:180px;" id="wr_job_type1" name="wr_job_type1" title="2차직종선택" onchange="job_type_sel_first(this,'wr_job_type2');">
								<option value="">= 2차 직종선택 =</option>
								<?php
								if($wr_job_type1){
									$pcodeList = $category_control->category_pcodeList('job_type', $wr_job_type0);
									if($pcodeList){
										foreach($pcodeList as $val){ 
										$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
										$selected = ($wr_job_type1 == $val['code']) ? "selected" : "";
								?>
										<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
								<?php 
										}	// foreach end.
									}	// if end.
								} else {
								?>
									<option value="">1차 직종을 먼저 선택해 주세요</option>
								<?php
								}	// if end.
								?>
								</select>
							</span>
							<span id="wr_job_type2_display">
								<select class="ipSelect" style="width:180px;" id="wr_job_type2" name="wr_job_type2" title="3차직종선택">
								<option value="">= 3차 직종선택 =</option>
								<?php
								if($wr_job_type2){
									$pcodeList = $category_control->category_pcodeList('job_type', $wr_job_type1);
									if($pcodeList){
										foreach($pcodeList as $val){ 
										$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
										$selected = ($wr_job_type2 == $val['code']) ? "selected" : "";
								?>
									<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
								<?php 
										}	// foreach end.
									}	// if end.
								} else {
								?>
									<option value="">2차 직종을 먼저 선택해 주세요</option>
								<?php
								}	// if end.
								?>
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">근무지</td>
						<td class="pdlnb2 num11" colspan="3">
							<select class="ipSelect" style="width:180px;" id="wr_area0" name="wr_area0" title="시·도 선택" onchange="area_sel_first(this,'wr_area1');" hname="근무지 시·도">
							<option value=""> -- 시·도 --</option>
							<?php 
								foreach($area_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($wr_area0 == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php } ?>
							</select>
							<span id="wr_area1_display">
								<select class="ipSelect" style="width:180px;" id="wr_area1" name="wr_area1" title="시·군·구 선택">
								<option value=""> -- 시·군·구 --</option>
								<?php
								if($wr_area1){
									$pcodeList = $category_control->category_pcodeList('area', $wr_area0);
									foreach($pcodeList as $val){ 
									$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
									$selected = ($wr_area1 == $val['code']) ? "selected" : "";
								?>
									<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
								<?php 
									}	// foreach end.
								} else {
								?>
									<option value="">시·도 를 먼저 선택해 주세요</option>
								<?php
								}	// if end.
								?>
								</select>
							</span>
							<em>
								<input type="checkbox" class="typeCheckbox" id="wr_home_work" name="wr_home_work" value="1" <?php echo ($custom['wr_home_work'])?'checked':'';?>> <label for="wr_home_work">재택근무가능</label>
							</em>
						</td>
					</tr>
					<tr>
						<td class="ctlt">근무일시</td>
						<td class="pdlnb2 num11" colspan="3">
							<select class="ipSelect" style="width:130px;" id="wr_date" name="wr_date" title="근무기간" hname="근무기간">
							<option value=""> -- 근무기간 --</option>
							<?php 
								foreach($alba_date_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($custom['wr_date'] == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php } ?>
							</select>
							<select class="ipSelect" style="width:130px;" id="wr_week" name="wr_week" title="근무요일" hname="근무요일">
							<option value=""> -- 근무요일 --</option>
							<?php 
								foreach($alba_week_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($custom['wr_week'] == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php } ?>
							</select>
							<select class="ipSelect" style="width:130px;" id="wr_time" name="wr_time" title="근무시간" hname="근무시간">
							<option value=""> -- 근무시간 --</option>
							<?php 
								foreach($alba_time_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($custom['wr_time'] == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php } ?>
							</select>
							<em>
								<input type="checkbox" class="typeCheckbox" id="wr_work_direct" name="wr_work_direct" value="1" <?php echo ($custom['wr_work_direct'])?'checked':'';?>> <label for="wr_work_direct">즉시출근가능</label>
							</em>
						</td>
					</tr>
					<tr>
						<td class="ctlt">성별</td>
						<td class="pdlnb2 num11">
							<input type="radio" name="wr_gender" id="wr_gender_0" value="0" class="chk" checked>
							<label for="wr_gender_0">성별무관</label>
							<input type="radio" name="wr_gender" id="wr_gender_1" value="1" class="chk" <?php echo ($custom['wr_gender']=='1')?'selected':'';?>><label for="wr_gender_1">남자</label>
							<input type="radio" name="wr_gender" id="wr_gender_2" value="2" class="chk" <?php echo ($custom['wr_gender']=='2')?'selected':'';?>><label for="wr_gender_2">여자</label>
						</td>
						<td class="ctlt">연령</td>
						<td class="pdlnb2 num11">
							<input type="radio" class="chk" id="wr_age_limit_0" name="wr_age_limit" value="0" onclick="age_sel(this);" hname="연령" option="radio" checked>
							<label for="wr_age_limit_0">연령무관</label>
							<input type="radio"  class="chk" id="wr_age_limit_1" name="wr_age_limit" value="1" onclick="age_sel(this);" hname="연령" option="radio" <?php echo ($wr_age_limit=='1')?'checked':'';?>>
							<label for="wr_age_limit_1">연령제한 있음</label>

							<span id="wr_age_display" style="display:<?php echo ($wr_age_limit)?'':'none';?>;">
								<input type="text"  maxlength="2" style="width:30px;text-align:center;" class="txt wr_age" id="wr_sage" name="wr_sage" value="<?php echo $wr_age[0];?>" hname="제한연령">
								<label>세 이상~</label>
								<input type="text"  maxlength="2" style="width:30px;text-align:center;" class="txt wr_age" id="wr_eage" name="wr_eage" value="<?php echo $wr_age[1];?>" hname="제한연령">
								<label>세 이하</label>
							</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">근무형태</td>
						<td class="pdlnb2 num11" colspan="3">
							<?php 
								foreach($work_type_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$checked = (@in_array($val['code'],$wr_work_type)) ? "checked" : "";
							?>
								<input type="checkbox" name="wr_work_type[]" id="wr_work_type_<?php echo $val['code'];?>" class="chk" value="<?php echo $val['code'];?>" hname="근무형태" <?php echo $checked;?>>
								<label for="wr_work_type_<?php echo $val['code'];?>"><?php echo $name;?></label>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td class="ctlt">메일링수신</td>
						<td class="pdlnb2 num11" colspan="3">
							<input type="checkbox" name="wr_email" id="wr_email" class="chk" value="1" hname="메일링수신" <?php echo ($custom['wr_email'])?'checked':'';?>>
							<label for="wr_email">이메일수신</label>&nbsp;&nbsp;
							<input type="checkbox" name="wr_sms" id="wr_sms" class="chk" value="1" hname="SMS수신" <?php echo ($custom['wr_sms'])?'checked':'';?>>
							<label for="wr_sms">SMS수신</label>
						</td>
					</tr>
					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_custom','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

				</div>
<?php

			break;

			## 맞춤채용정보 수정 레이어
			case 'custom_employ':
			$custom = $alba_individual_control->get_custom($no);
			$job_type_list = $category_control->category_codeList('job_type');		// 직종
			$area_list = $category_control->category_codeList('area');					// 지역
			$alba_date_list = $category_control->category_codeList('alba_date');	// 정규직근무기간
			$alba_week_list = $category_control->category_codeList('alba_week');	// 정규직근무요일
			$alba_time_list = $category_control->category_codeList('alba_time');	// 정규직근무시간
			$work_type_list = $category_control->category_codeList('work_type');	// 근무형태
			$wr_job_type0 = $custom['wr_job_type0'];
			$wr_job_type1 = $custom['wr_job_type1'];
			$wr_job_type2 = $custom['wr_job_type2'];
			$wr_area0 = $custom['wr_area0'];
			$wr_area1 = $custom['wr_area1'];
			$wr_age_limit = $custom['wr_age_limit'];
			$wr_age = explode('-',$custom['wr_age']);
			$wr_age_etc = explode(',',$custom['wr_age_etc']);
			$wr_stime = explode(':',$custom['wr_stime']);
			$wr_etime = explode(':',$custom['wr_etime']);
			$wr_time_conference = $custom['wr_time_conference'];
			$wr_work_type = explode(',',$custom['wr_work_type']);		// 근무형태
?>
				<div id="pop_custom" class="bocol lnb_col" style="top:10%;left:33%;display:;">
				<form name="CustomFrm" method="post" id="CustomFrm" action="./process/custom.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="employ_update" id="mode"/>
				<input type="hidden" name="ajax" value="1" id="ajax"/>
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="mb_id" value="<?php echo $mb_id;?>"/>

					<dl class="ntlt lnb_col m0 hand" id="customHandle">
						<img src="../../images/comn/bul_10.png" class="t">맞춤채용정보 수정
						<a onClick="MM_showHideLayers('pop_custom','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  
					<table width="730" class="bg_col tf">
					<col width="100"><col width="180"><col width=100><col>
					<tr>
						<td class="ctlt">아이디</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_id'];?></td>
						<td class="ctlt">이름</td>
						<td class="pdlnb2 num11"><?php echo $member['mb_name'];?></td>
					</tr>
					<tr>
						<td class="ctlt">업직종</td>
						<td class="pdlnb2 num11" colspan="3">
							<select class="ipSelect" style="width:180px;" id="wr_job_type0" name="wr_job_type0" title="1차직종선택" onchange="job_type_sel_first(this,'wr_job_type1');" required hname="1차직종">
							<option value="">1차직종선택</option>
							<?php 
								foreach($job_type_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($wr_job_type0 == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php } ?>
							</select>
							<span id="wr_job_type1_display">
								<select class="ipSelect" style="width:180px;" id="wr_job_type1" name="wr_job_type1" title="2차직종선택" onchange="job_type_sel_first(this,'wr_job_type2');">
								<option value="">2차직종선택</option>
								<?php
								if($wr_job_type1){
									$pcodeList = $category_control->category_pcodeList('job_type', $wr_job_type0);
									foreach($pcodeList as $val){ 
									$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
									$selected = ($wr_job_type1 == $val['code']) ? "selected" : "";
								?>
									<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
								<?php 
									}	// foreach end.
								} else {
								?>
									<option value="">1차 직종을 먼저 선택해 주세요</option>
								<?php
								}	// if end.
								?>
								</select>
							</span>
							<span id="wr_job_type2_display">
								<select class="ipSelect" style="width:180px;" id="wr_job_type2" name="wr_job_type2" title="3차직종선택">
								<option value="">3차직종선택</option>
								<?php
								if($wr_job_type2){
									$pcodeList = $category_control->category_pcodeList('job_type', $wr_job_type1);
									foreach($pcodeList as $val){ 
									$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
									$selected = ($wr_job_type2 == $val['code']) ? "selected" : "";
								?>
									<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
								<?php 
									}	// foreach end.
								} else {
								?>
									<option value="">2차 직종을 먼저 선택해 주세요</option>
								<?php
								}	// if end.
								?>
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">근무지</td>
						<td class="pdlnb2 num11" colspan="3">
							<select class="ipSelect" style="width:180px;" id="wr_area0" name="wr_area0" title="시·도 선택" onchange="area_sel_first(this,'wr_area1');" required hname="근무지 시·도">
							<option value=""> -- 시·도 --</option>
							<?php 
								foreach($area_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($wr_area0 == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php } ?>
							</select>
							<span id="wr_area1_display">
								<select class="ipSelect" style="width:180px;" id="wr_area1" name="wr_area1" title="시·군·구 선택">
								<option value=""> -- 시·군·구 --</option>
								<?php
								if($wr_area1){
									$pcodeList = $category_control->category_pcodeList('area', $wr_area0);
									foreach($pcodeList as $val){ 
									$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
									$selected = ($wr_area1 == $val['code']) ? "selected" : "";
								?>
									<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
								<?php 
									}	// foreach end.
								} else {
								?>
									<option value="">시·도 를 먼저 선택해 주세요</option>
								<?php
								}	// if end.
								?>
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">근무일시</td>
						<td class="pdlnb2 num11" colspan="3">
							<select class="ipSelect" style="width:130px;" id="wr_date" name="wr_date" title="근무기간" required hname="근무기간">
							<option value=""> -- 근무기간 --</option>
							<?php 
								foreach($alba_date_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($custom['wr_date'] == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php } ?>
							</select>
							<select class="ipSelect" style="width:130px;" id="wr_week" name="wr_week" title="근무요일" required hname="근무요일">
							<option value=""> -- 근무요일 --</option>
							<?php 
								foreach($alba_week_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$selected = ($custom['wr_week'] == $val['code']) ? "selected" : "";
							?>
							<option value="<?php echo $val['code'];?>" <?php echo $selected;?>><?php echo $name;?></option>
							<?php } ?>
							</select>
							
							<select class="ipSelect wr_time" name="wr_stime[]" id="wr_stime" hname="근무시간" option="select" <?php echo ($wr_time_conference)?'disabled':'';?>>
							<option value="">선택</option>
							<?php for($i=0;$i<=23;$i++){ ?>
							<option value="<?php echo sprintf('%02d',$i);?>" <?php echo ($wr_stime[0]&&$wr_stime[0]==$i)?'selected':'';?>><?php echo sprintf('%02d',$i);?>시</option>
							<?php } ?>
							</select>
							<select class="ipSelect wr_time" name="wr_stime[]" id="wr_smin" hname="근무시간" option="select" <?php echo ($wr_time_conference)?'disabled':'';?>>
							<option value="">선택</option>
							<?php for($i=0;$i<=5;$i++){?>
							<option value="<?php echo $i;?>0" <?php echo ($wr_stime[1]==$i.'0')?'selected':'';?>><?php echo $i;?>0분</option>
							<?php } ?>
							</select>
							<span id="nextworktime">~</span>
							<select class="ipSelect wr_time" name="wr_etime[]" id="wr_etime" <?php echo ($wr_time_conference)?'':'required';?> hname="근무시간" option="select" <?php echo ($wr_time_conference)?'disabled':'';?>>
							<option value="">선택</option>
							<?php for($i=0;$i<=23;$i++){ ?>
							<option value="<?php echo sprintf('%02d',$i);?>" <?php echo ($wr_etime[0]&&$wr_etime[0]==$i)?'selected':'';?>><?php echo sprintf('%02d',$i);?>시</option>
							<?php } ?>
							</select>
							<select class="ipSelect wr_time" name="wr_etime[]" id="wr_emin" <?php echo ($wr_time_conference)?'':'required';?> hname="근무시간" option="select" <?php echo ($wr_time_conference)?'disabled':'';?>>
							<option value="">선택</option>
							<?php for($i=0;$i<=5;$i++){?>
							<option value="<?php echo $i;?>0" <?php echo ($wr_etime[1]==$i.'0')?'selected':'';?>><?php echo $i;?>0분</option>
							<?php } ?>
							</select>
							<input type="checkbox" class="typeCheckbox" id="wr_time_conference" name="wr_time_conference" value="1" onclick="time_conference(this);"  <?php echo ($wr_time_conference)?'checked':'';?>>
							<label for="wr_time_conference">시간협의</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">성별</td>
						<td class="pdlnb2 num11">
							<input type="radio" name="wr_gender" id="wr_gender_0" value="0" class="chk" checked>
							<label for="wr_gender_0">성별무관</label>
							<input type="radio" name="wr_gender" id="wr_gender_1" value="1" class="chk" <?php echo ($custom['wr_gender']=='1')?'selected':'';?>><label for="wr_gender_1">남자</label>
							<input type="radio" name="wr_gender" id="wr_gender_2" value="2" class="chk" <?php echo ($custom['wr_gender']=='2')?'selected':'';?>><label for="wr_gender_2">여자</label>
						</td>
						<td class="ctlt">연령</td>
						<td class="pdlnb2 num11">
							<input type="radio" class="chk" id="wr_age_limit_0" name="wr_age_limit" value="0" onclick="age_sel(this);" hname="연령" option="radio" checked>
							<label for="wr_age_limit_0">연령무관</label>
							<input type="radio"  class="chk" id="wr_age_limit_1" name="wr_age_limit" value="1" onclick="age_sel(this);" hname="연령" option="radio" <?php echo ($wr_age_limit=='1')?'checked':'';?>>
							<label for="wr_age_limit_1">연령제한 있음</label>

							<span id="wr_age_display" style="display:<?php echo ($wr_age_limit)?'':'none';?>;">
								<input type="text"  maxlength="2" style="width:30px;text-align:center;" class="txt wr_age" id="wr_sage" name="wr_sage" value="<?php echo $wr_age[0];?>" hname="제한연령">
								<label>세 이상~</label>
								<input type="text"  maxlength="2" style="width:30px;text-align:center;" class="txt wr_age" id="wr_eage" name="wr_eage" value="<?php echo $wr_age[1];?>" hname="제한연령">
								<label>세 이하</label>
							</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">근무형태</td>
						<td class="pdlnb2 num11" colspan="3">
							<?php 
								foreach($work_type_list as $val){ 
								$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
								$checked = (@in_array($val['code'],$wr_work_type)) ? "checked" : "";
							?>
								<input type="checkbox" name="wr_work_type[]" id="wr_work_type_<?php echo $val['code'];?>" class="chk" value="<?php echo $val['code'];?>" hname="근무형태" <?php echo $checked;?>>
								<label for="wr_work_type_<?php echo $val['code'];?>"><?php echo $name;?></label>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td class="ctlt">메일링수신</td>
						<td class="pdlnb2 num11" colspan="3">
								<input type="checkbox" name="wr_email" id="wr_email" class="chk" value="1" hname="메일링수신" <?php echo ($custom['wr_email'])?'checked':'';?>>
								<label for="wr_email">이메일수신</label>&nbsp;&nbsp;
								<input type="checkbox" name="wr_sms" id="wr_sms" class="chk" value="1" hname="SMS수신" <?php echo ($custom['wr_sms'])?'checked':'';?>>
								<label for="wr_sms">SMS수신</label>
						</td>
					</tr>
					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_custom','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

				</div>
<?php
			break;

		}	// switch end.
?>