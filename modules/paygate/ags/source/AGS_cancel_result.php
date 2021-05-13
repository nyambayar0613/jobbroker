<?php
/**********************************************************************************************
*
* 파일명 : AGS_cancel_result.php
* 작성일자 : 2009/04/01
*
* 신용카드 결제취소결과를 화면에 표시하는 샘플페이지입니다.
* 본 페이지를 상점에 맞도록 수정하여 사용하십시요.
*
* Copyright AEGIS ENTERPRISE.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/ 

$rStoreId = trim( $_POST["rStoreId"] );		//업체ID
$rApprNo = trim( $_POST["rApprNo"] );		//승인번호
$rApprTm = trim( $_POST["rApprTm"] );		//승인시각
$rBusiCd = trim( $_POST["rBusiCd"] );		//전문코드
$rSuccYn = trim( $_POST["rSuccYn"] );		//성공여부
$rOrdNo = trim( $_POST["rOrdNo"] );			//주문번호
$rInstmt = trim( $_POST["rInstmt"] );		//할부개월
$rAmt = trim( $_POST["rAmt"] );				//결제금액
$rCardNm = trim( $_POST["rCardNm"] );		//카드사명
$rCardCd = trim( $_POST["rCardCd"] );		//카드사코드
$rMembNo = trim( $_POST["rMembNo"] );		//가맹점번호
$rAquiCd = trim( $_POST["rAquiCd"] );		//매입사코드
$rAquiNm = trim( $_POST["rAquiNm"] );		//매입사명
$rDealNo = trim( $_POST["rDealNo"] );		//전표번호
$rResMsg = trim( $_POST["rResMsg"] );		//실패사유
?>
<html>
<head>
<title>올더게이트</title>
<style type="text/css">
<!--
body { font-family:"돋움"; font-size:9pt; color:#000000; font-weight:normal; letter-spacing:0pt; line-height:180%; }
td { font-family:"돋움"; font-size:9pt; color:#000000; font-weight:normal; letter-spacing:0pt; line-height:180%; }
.clsright { padding-right:10px; text-align:right; }
.clsleft { padding-left:10px; text-align:left; }
-->
</style>
<script language=javascript>
<!--
var openwin = window.open("AGS_progress.html","popup","width=300,height=160");
openwin.close();
-->
</script>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0>
<table border=0 width=100% height=100% cellpadding=0 cellspacing=0>
	<tr>
		<td align=center>
		<table width=400 border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td class=clsleft>취소 결과</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td>
				<table width=400 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td class=clsright width=100>상점아이디 : </td>
						<td class=clsleft width=300><?=$rStoreId?></td>
					</tr>
					<tr>
						<td class=clsright>승인번호 : </td>
						<td class=clsleft><?=$rApprNo?></td>
					</tr>
					<tr>
						<td class=clsright>승인시각 : </td>
						<td class=clsleft><?=$rApprTm?></td>
					</tr>
					<tr>
						<td class=clsright>전문코드 : </td>
						<td class=clsleft><?=$rBusiCd?></td>
					</tr>
					<tr>
						<td class=clsright>성공여부 : </td>
						<td class=clsleft><?=$rSuccYn?></td>
					</tr>
					<tr>
						<td class=clsright>처리메세지 : </td>
						<td class=clsleft><?=$rResMsg?></td>
					</tr>
<?	if($AuthTy == "card" && $SubTy == "visa3d" ) {?>					
					<tr>
						<td class=clsright>주문번호 : </td>
						<td class=clsleft><?=$rOrdNo?></td>
					</tr>
					<tr>
						<td class=clsright>할부개월 : </td>
						<td class=clsleft><?=$rInstmt?></td>
					</tr>
					<tr>
						<td class=clsright>결제금액 : </td>
						<td class=clsleft><?=$rAmt?></td>
					</tr>
					<tr>
						<td class=clsright>카드사코드 : </td>
						<td class=clsleft><?=$rCardCd?></td>
					</tr>
					<tr>
						<td class=clsright>카드사명 : </td>
						<td class=clsleft><?=$rCardNm?></td>
					</tr>
					<tr>
						<td class=clsright>매입사코드 : </td>
						<td class=clsleft><?=$rAquiCd?></td>
					</tr>
					<tr>
						<td class=clsright>매입사명 : </td>
						<td class=clsleft><?=$rAquiNm?></td>
					</tr>
					<tr>
						<td class=clsright>가맹점번호 : </td>
						<td class=clsleft><?=$rMembNo?></td>
					</tr>
<?	}	?>	
					
					<tr>
						<td class=clsright>거래번호 : </td>
						<td class=clsleft><?=$rDealNo?></td>
					</tr>
					<tr>
						<td colspan=2>&nbsp;</td>
					</tr>
					<tr>
						<td align=center colspan=2>카드 이용명세서에 구입처가 <font color=red>이지스효성(주)</font>로 표기됩니다.</td>
					</tr>
					
				</table>
				</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td class=clsleft>Copyright AEGIS ENTERPRISE.Co.,Ltd. All rights reserved.</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</html>
