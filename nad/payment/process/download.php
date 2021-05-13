<?php
		/*
		* /application/nad/payment/process/download.php
		* @author Harimao
		* @since 2013/11/08
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Payment data download
		* @Comment :: 결제 데이터 다운로드
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크


		$status = $_GET['status'];
		if($status){
			$con = " where `pay_pg` != 'admin' and `pay_method` != 'service' and `is_delete` = 0 and `pay_status` = '".$status."' ";
		} else {
			$con = " where `pay_pg` != 'admin' and `pay_method` != 'service' and `is_delete` = 0 ";
		}

		$pay_list = $payment_control->__PayList("", "", $con);
	
		header('Content-Type: application/vnd.ms-excel; charset='.$alice['charset']);
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
		header('Content-Disposition: attachment; filename="payment_' . date("ymd", time()) . '.xls"'); 
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
		header('Pragma: public'); 

?>
<table align=center  cellpadding="0" cellspacing="0" border="1" width="100%" class="mt20">
<colgroup>
<col width="2%"><!-- NO -->
<col width="8%"><!-- 회원구분 -->
<col width="10%"><!-- 이름/대표자 -->
<col width="10%"><!-- 회원ID -->
<col width="15%"><!-- 공고(이력서) -->
<col width="8%"><!-- 현금영수증/세금계산서 신청 정보 -->
<col width="15%"><!-- 서비스 결제 정보 -->
<col width="8%"><!-- 결제수단 -->
<col width="8%"><!-- 진행상태 -->
<col width="10%"><!-- 할인금액 -->
<col width="10%"><!-- 결제금액 -->
<col width="8%"><!-- 결제일 -->
<col width="8%"><!-- 결제완료일 -->
</colgroup>
<tr>
<td colspan="13" class="ntlt">결제내역 <span class="fon11 dgr pL3 nom">| &nbsp;총 <b class="num2 col"><?=$pay_list['total_count'];?></b>건의 결제내역이 검색되었습니다.</span></td>
</tr>
<tr><td colspan="13" height="2" class="ln_dbl"></td></tr>
<tr class="bg tc">
<td align="center">NO</td>
<td align="center">회원구분</td>
<td align="center">이름/대표자</td>
<td align="center">회원ID</td>
<td align="center">공고(이력서)</td>
<td align="center">현금영수증/세금계산서</td>
<td align="center">서비스 결제 정보</td>
<td align="center">결제수단</td>
<td align="center">진행상태</td>
<td align="center">할인금액</td>
<td align="center">결제금액</td>
<td align="center">결제일</td>
<td align="center">결제완료일</td>
</tr>
<?php if(!$pay_list['result']){ ?>
<tr>
<td class="stlt" colspan="11">등록된 내용이 없습니다.</td>
</tr>
<?php } else { 
	$pay_status = $payment_control->pay_status;
	$no = 0;
	foreach($pay_list['result'] as $val ){
	$no++;
	
	$get_member = $member_control->get_member($val['pay_uid']);

	if($get_member['mb_type']=='individual'){
		$get_resume = $alba_resume_control->get_resume($val['pay_no']);
		$individual_msg = "<span style='color:#dfdfdf;'>개인</span>";
		$mb_type = "개인회원";
		$mb_name = $get_member['mb_name'];
		$wr_subject = stripslashes($get_resume['wr_subject']);
	} else if($val['mb_type']=='company'){
		$get_alba = $alba_control->get_alba($val['pay_no']);
		$get_company_member = $member_control->get_company_member($val['pay_uid']);
		$company_msg = "<span style='color:#dfdfdf;'>기업</span>";
		$mb_type = "기업회원";
		$mb_name = $get_company_member['mb_ceo_name'];
		$wr_subject = stripslashes($get_alba['wr_subject']);
	}

	$list = $payment_control->payment_listing($val['no']);	// 결제정보
	$get_method = $payment_control->pg_payMethod($val['pay_method']);

?>
<tr height="30" class="wr_list">
<td align="center"><?php echo $no;?></td>
<td align="center"><?php echo $mb_type;?></td>
<td align="center"><?php echo $mb_name;?></td>
<td align="center"><?php echo $val['pay_uid'];?></td>
<td align="center"><?php echo $wr_subject;?></td>
<td align="center">
<?php if($val['pay_tax_type']){ ?>
<?php echo ($val['pay_tax_type']=='1')?"현금영수증":"세금계산서";?> 신청 <br>
<?php echo ($val['pay_tax_type']=='1')?$val['pay_tax_num']:strtr($val['pay_tax_num'],"/","-");?>
<?php } else { echo "&nbsp;"; } ?>
</td>
<td align="center"><?php echo @implode($list,"<br/>");?></td>
<td align="center">
<?php echo $get_method['name']?>
<?php 
if($val['pay_method']=='bank'){
echo "<br/>".$val['pay_bank_name'];	
} 
?>
</td>
<td align="center"><?php echo $pay_status[$val['pay_status']];?></td>
<td align="center"><?php echo number_format($val['pay_dc']);?></td>
<td align="center"><?php echo number_format($val['pay_price']);?></td>
<td align="center"><?php echo $val['pay_wdate'];?></td>
<td align="center"><?php echo $val['pay_sdate'];?></td>
</tr>
<?php
	}	// foreach end.
}	// if end.
?>