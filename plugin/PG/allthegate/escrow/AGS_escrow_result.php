<?php
/**********************************************************************************************
*
* ���ϸ� : AGS_escrow_result.php
* �ۼ����� : 2016/10/11
*
* ��۵�� �� ����Ȯ�� ����� ó���մϴ�.
*
* Copyright NICEPayments.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/
$rTrCode        = trim( $_POST["rTrCode"] );					//�ŷ��ڵ�
$rPayKind       = trim( $_POST["rPayKind"] );					//��������
$rRetailerId    = trim( $_POST["rRetailerId"] );			    //��üID
$rSuccYn        = trim( $_POST["rSuccYn"] );				    //��������
$rResMsg        = trim( $_POST["rResMsg"] );				    //���л���
?>
<html>
<head>
<title>�ô�����Ʈ</title>
<style type="text/css">
<!--
body { font-family:"����"; font-size:9pt; color:#000000; font-weight:normal; letter-spacing:0pt; line-height:180%; }
td { font-family:"����"; font-size:9pt; color:#000000; font-weight:normal; letter-spacing:0pt; line-height:180%; }
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
				<td class=clsleft>�ŷ� ���</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td>
				<table width=400 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td class=clsright width=100>�ŷ��ڵ� : </td>
						<td class=clsleft width=300>
<?php
if($rTrCode == "E101")
{
    echo "�߼ۿϷ�";
}
else if($rTrCode == "E201")
{
	echo "����Ȯ��";
}
else if($rTrCode == "E301")
{
	echo "���Ű���";
}
else if($rTrCode == "E401")
{
	echo "��ҿ�û";
}
?>
						</td>
					</tr>
                    <tr>
						<td class=clsright>�������� : </td>
						<td class=clsleft>
<?php
if($rPayKind == "01")
{
    echo "�ſ�ī��";
}
else if($rPayKind == "02")
{
	echo "������ü - ���ͳݹ�ŷ";
}
else if($rPayKind == "03")
{
	echo "�������";
}
else if($rPayKind == "04")
{
	echo "������ü - �ڷ���ŷ";
}
?>

                    </td>
					</tr>
					<tr>
						<td class=clsright>�������̵� : </td>
						<td class=clsleft><?=$rRetailerId?></td>
					</tr>
					<tr>
						<td class=clsright>�������� : </td>
						<td class=clsleft><?=$rSuccYn?></td>
					</tr>
					<tr>
						<td class=clsright>ó���޼��� : </td>
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
