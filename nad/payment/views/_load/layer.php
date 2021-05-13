<?php
		/*
		* /application/nad/payment/views/_load/layer.php
		* @author Harimao
		* @since 2013/09/30
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Tax load layer
		* @Comment :: 세금계산서 관련 다른 정보 추출
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];

		//$member = $member_control->get_memberNo($no);

		$get_tax = $tax_control->get_tax($no);
		
		switch($mode){

			## 메모
			case 'memo':
?>
				<div id="pop_memo" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1003;">
				<form name="TaxMemoFrm" method="post" id="TaxMemoFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="memo"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="no" value="<?php echo $no;?>"/>

					<dl class="ntlt lnb_col m0" id="memoFrmHandle" style="cursor:pointer;">
						<img src="../../images/comn/bul_10.png" class="t">세금 계산서 관리자메모
						<a onClick="MM_showHideLayers('pop_memo','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<dl class="twrap"><textarea style="height:100px;width:690px" name="wr_memo"><?php echo stripslashes($get_tax['wr_memo']);?></textarea></dl>  

					<dl class="pbtn">
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_memo','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>
<?php
			break;

			## 세금계산서 정보
			case 'tax_info':
				$get_tax = $tax_control->get_tax($no);
				$get_member = $member_control->get_member($get_tax['wr_id']);
?>
				<div id="pop_tax" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1003;">
				
					<dl class="ntlt lnb_col m0 hand" id="taxHandle">
						<img src="../../images/comn/bul_10.png" class="t">세금계산서 신청 정보
						<a onClick="MM_showHideLayers('pop_tax','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  

					<table width="730" class="bg_col tf">
					<col width=100><col><col width=100><col>
					<tr>
						<td class="ctlt">신청 회원 아이디</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_id'];?></td>
						<td class="ctlt">회원 이름</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_name'];?></td>
					</tr>
					<tr>
						<td class="ctlt">회사명</td>
						<td class="pdlnb2 num11"><?php echo stripslashes($get_tax['wr_company_name']);?></td>
						<td class="ctlt">대표자명</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_ceo_name'];?></td>
					</tr>
					<tr>
						<td class="ctlt">사업장주소</td>
						<td class="pdlnb2 num11" colspan="3">
						[<?php echo $get_tax['wr_zipcode']?>] <?php echo $get_tax['wr_address0']." ".$get_tax['wr_address1'];?>
						</td>
					</tr>
					<tr>
						<td class="ctlt">업태</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_condition'];?></td>
						<td class="ctlt">종목</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_item'];?></td>
					</tr>
					<tr>
						<td class="ctlt">담당자명</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_manager'];?></td>
						<td class="ctlt">담당자연락처</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_phone'];?></td>
					</tr>
					<tr>
						<td class="ctlt">이메일주소</td>
						<td class="pdlnb2 num11" colspan="3"><?php echo $get_tax['wr_email'];?></td>
					</tr>
					<tr>
						<td class="ctlt">결제일자</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_pay_date'];?></td>
						<td class="ctlt">결제금액</td>
						<td class="pdlnb2 num11"><?php echo number_format($get_tax['wr_price']);?></td>
					</tr>
					<tr>
						<td class="ctlt">신청 내용</td>
						<td class="pdlnb2 num11" colspan="3"><?php echo nl2br(stripslashes($get_tax['wr_content']));?></td>
					</tr>
					<tr>
						<td class="ctlt">관리자 메모</td>
						<td class="pdlnb2 num11" colspan="3"><?php echo nl2br(stripslashes($get_tax['wr_memo']));?></td>
					</tr>
					</table>

					<dl class="pbtn">  
						<a onClick="MM_showHideLayers('pop_tax','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</div>
<?php
			break;

			## 세금계산서 내용 수정
			case 'tax_update':
				$get_tax = $tax_control->get_tax($no);
				$get_member = $member_control->get_member($get_tax['wr_id']);
				$wr_zipcode = explode('-',$get_tax['wr_zipcode']);
				$wr_phone = explode('-',$get_tax['wr_phone']);
				$tel_num_option = $config->get_tel_num($wr_phone[0]);
				$wr_email = explode('@',$get_tax['wr_email']);
				$email_option = $config->get_email();	 // 이메일

?>
				<div id="pop_tax" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1003;">
				
				<form method="post" name="taxFrm" action="./process/regist.php" id="taxFrm">
				<input type="hidden" name="mode" value="tax_update"/>
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="wr_id" value="<?php echo $get_tax['wr_id'];?>"/>

					<dl class="ntlt lnb_col m0 hand" id="taxHandle">
						<img src="../../images/comn/bul_10.png" class="t">세금계산서 신청 정보 수정
						<a onClick="MM_showHideLayers('pop_tax','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  

					<table width="730" class="bg_col tf">
					<col width=100><col><col width=100><col>
					<tr>
						<td class="ctlt">신청 회원 아이디</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_id'];?></td>
						<td class="ctlt">회원 이름</td>
						<td class="pdlnb2 num11"><?php echo $get_tax['wr_name'];?></td>
					</tr>
					<tr>
						<td class="ctlt">회사명</td>
						<td class="pdlnb2 num11">
							<input type="text" name="wr_company_name" id="wr_company_name" style="width:200px;" class="txt" maxlength="16" hname="회사명" required value="<?php echo stripslashes($get_tax['wr_company_name']);?>">
						</td>
						<td class="ctlt">대표자명</td>
						<td class="pdlnb2 num11">
							<input type="text" name="wr_ceo_name" id="wr_ceo_name" style="width:200px;" class="txt" maxlength="16" hname="대표자명" required value="<?php echo stripslashes($get_tax['wr_ceo_name']);?>">
						</td>
					</tr>
					<tr>
						<td class="ctlt">사업장주소</td>
						<td class="pdlnb2 num11" colspan="3">
							<input type="text" style="width:55px;" class="txt" title="우편번호 앞자리" maxlength="3" id="wr_zipcode0" name="wr_zipcode[]" readonly required hname="우편번호 앞자리" value="<?php echo $wr_zipcode[0];?>">
							<span class="delimiter">-</span>
							<input type="text" style="width:55px;" class="txt" title="우편번호 뒷자리" maxlength="4" id="wr_zipcode1" name="wr_zipcode[]" readonly required hname="우편번호 뒷자리" value="<?php echo $wr_zipcode[1];?>">
							<a class="button" onclick="postSearchPops('individual');"><span>우편번호 검색</span></a> </div>
							<div class="adress2 mt3">
							<input type="text" class="txt w50" title="주소" id="wr_address0" name="mb_address0" required hname="주소" value="<?php echo $get_tax['wr_address0'];?>">
							<input type="text" class="txt w50" title="상세주소" id="wr_address1" name="mb_address1" required hname="상세주소" value="<?php echo $get_tax['wr_address1'];?>">
						</td>
					</tr>
					<tr>
						<td class="ctlt">업태</td>
						<td class="pdlnb2 num11">
							<input type="text" name="wr_condition" id="wr_condition" class="txt"  maxlength="16" required hname="업태" value="<?php echo $get_tax['wr_condition'];?>"><em class="pl10 help">
						</td>
						<td class="ctlt">종목</td>
						<td class="pdlnb2 num11">
							<input type="text" name="wr_item" id="wr_item" class="txt"  maxlength="16" value="<?php echo $get_tax['wr_item'];?>"  hname="종목"><em class="pl10 help">
						</td>
					</tr>
					<tr>
						<td class="ctlt">담당자명</td>
						<td class="pdlnb2 num11">
							<input type="text" name="wr_manager" id="wr_manager" class="txt"  maxlength="16" required hname="담당자명" value="<?php echo $get_tax['wr_manager'];?>">
						</td>
						<td class="ctlt">담당자연락처</td>
						<td class="pdlnb2 num11">
							<select title="지역번호 선택" name="wr_phone[]" id="wr_phone_0" style="width:111px;" class="ipSelect" hname="지역번호" required>
							<option value="">지역번호 선택</option>
							<?php echo $tel_num_option; ?>
							</select>
							<span class="delimiter">-</span>
							<input type="text" name="wr_phone[]" id="wr_phone_1" maxlength="4" title="전화번호 앞자리" class="txt" hname="전화번호 앞자리" required value="<?php echo $wr_phone[1];?>">
							<span class="delimiter">-</span>
							<input type="text" name="wr_phone[]" id="wr_phone_2" maxlength="4" title="전화번호 뒷자리" class="txt" hname="전화번호 뒷자리" required value="<?php echo $wr_phone[2];?>">
						</td>
					</tr>
					<tr>
						<td class="ctlt">이메일주소</td>
						<td class="pdlnb2 num11" colspan="3">
								<input type="text" class="txt" style="width:150px;ime-mode:disabled;" maxlength="30" id="wr_email" name="wr_email[]" required hname="이메일" value="<?php echo $wr_email[0];?>">
								<span class="delimiter">@</span>
								<input type="text" style="width:185px" class="txt" maxlength="25" title="이메일 서비스 제공자" id="wr_email_tail" name="wr_email[]" required hname="이메일 서비스 제공자" value="<?php echo $wr_email[1];?>">
								<select class="ipSelect" style="width:105px;" id="email_service" onchange="email_sel(this);">
								<option value="">직접입력</option>
								<?php echo $email_option; ?>
								</select>
						</td>
					</tr>
					<tr>
						<td class="ctlt">결제일자</td>
						<td class="pdlnb2 num11">
							<input type="text" name="wr_pay_date" value="<?php echo $get_tax['wr_pay_date'];?>" id="wr_pay_date" class="txt"/>
						</td>
						<td class="ctlt">결제금액</td>
						<td class="pdlnb2 num11">
						<input type="text" name="wr_price" id="wr_price" style="width:200px;" class="txt"  maxlength="16" value="<?php echo $get_tax['wr_price'];?>">
						</td>
					</tr>
					<tr>
						<td class="ctlt">신청 내용</td>
						<td class="pdlnb2 num11" colspan="3">
							<dl class="twrap"><textarea style="height:100px;width:690px" name="wr_content" id="wr_content"><?php echo stripslashes($get_tax['wr_content']);?></textarea></dl>  
						</td>
					</tr>
					<tr>
						<td class="ctlt">관리자 메모</td>
						<td class="pdlnb2 num11" colspan="3">
							<dl class="twrap"><textarea style="height:100px;width:690px" name="wr_memo" id="wr_memo"><?php echo stripslashes($get_tax['wr_memo']);?></textarea></dl>
						</td>
					</tr>
					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_tax','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>

<?php
			break;

		}	// switch end.
?>