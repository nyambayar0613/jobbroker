<?php
/**********************************************************************************************
*
* 파일명 : AGS_escrow_result.php
* 작성일자 : 2016/10/11
*
* 배송등록 및 구매확인 결과를 처리합니다.
*
* Copyright NICEPayments.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/
$rTrCode        = trim( $_POST["rTrCode"] );					//거래코드
$rPayKind       = trim( $_POST["rPayKind"] );					//결제종류
$rRetailerId    = trim( $_POST["rRetailerId"] );			    //업체ID
$rSuccYn        = trim( $_POST["rSuccYn"] );				    //성공여부
$rResMsg        = trim( $_POST["rResMsg"] );				    //실패사유
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
				<td class=clsleft>거래 결과</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td>
				<table width=400 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td class=clsright width=100>거래코드 : </td>
						<td class=clsleft width=300>
<?php
if($rTrCode == "E101")
{
    echo "발송완료";
}
else if($rTrCode == "E201")
{
	echo "구매확인";
}
else if($rTrCode == "E301")
{
	echo "구매거절";
}
else if($rTrCode == "E401")
{
	echo "취소요청";
}
?>
						</td>
					</tr>
                    <tr>
						<td class=clsright>결제종류 : </td>
						<td class=clsleft>
<?php
if($rPayKind == "01")
{
    echo "신용카드";
}
else if($rPayKind == "02")
{
	echo "계좌이체 - 인터넷뱅킹";
}
else if($rPayKind == "03")
{
	echo "가상계좌";
}
else if($rPayKind == "04")
{
	echo "계좌이체 - 텔레뱅킹";
}
?>

                    </td>
					</tr>
					<tr>
						<td class=clsright>상점아이디 : </td>
						<td class=clsleft><?=$rRetailerId?></td>
					</tr>
					<tr>
						<td class=clsright>성공여부 : </td>
						<td class=clsleft><?=$rSuccYn?></td>
					</tr>
					<tr>
						<td class=clsright>처리메세지 : </td>
						<td class=clsleft><?=$rResMsg?></td>
					</tr>
					<tr>
						<td colspan=2>&nbsp;</td>
					</tr>
					
				</table>
				</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td class=clsleft>Copyright NICEPayments.Co.,Ltd. All rights reserved.</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</html>
