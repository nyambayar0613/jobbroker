<?php
/**********************************************************************************************
*
* ���ϸ� : AGS_cancel_result.php
* �ۼ����� : 2016/10/11
*
* �ſ�ī�� ������Ұ���� ȭ�鿡 ǥ���ϴ� �����������Դϴ�.
* �� �������� ������ �µ��� �����Ͽ� ����Ͻʽÿ�.
*
* Copyright NICEPayments.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/ 

$rStoreId = trim( $_POST["rStoreId"] );		//��üID
$rApprNo = trim( $_POST["rApprNo"] );		//���ι�ȣ
$rApprTm = trim( $_POST["rApprTm"] );		//���νð�
$rBusiCd = trim( $_POST["rBusiCd"] );		//�����ڵ�
$rSuccYn = trim( $_POST["rSuccYn"] );		//��������
$rOrdNo = trim( $_POST["rOrdNo"] );			//�ֹ���ȣ
$rInstmt = trim( $_POST["rInstmt"] );		//�Һΰ���
$rAmt = trim( $_POST["rAmt"] );				//�����ݾ�
$rCardNm = trim( $_POST["rCardNm"] );		//ī����
$rCardCd = trim( $_POST["rCardCd"] );		//ī����ڵ�
$rMembNo = trim( $_POST["rMembNo"] );		//��������ȣ
$rAquiCd = trim( $_POST["rAquiCd"] );		//���Ի��ڵ�
$rAquiNm = trim( $_POST["rAquiNm"] );		//���Ի��
$rDealNo = trim( $_POST["rDealNo"] );		//��ǥ��ȣ
$rResMsg = trim( $_POST["rResMsg"] );		//���л���
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
				<td class=clsleft>��� ���</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td>
				<table width=400 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td class=clsright width=100>�������̵� : </td>
						<td class=clsleft width=300><?=$rStoreId?></td>
					</tr>
					<tr>
						<td class=clsright>���ι�ȣ : </td>
						<td class=clsleft><?=$rApprNo?></td>
					</tr>
					<tr>
						<td class=clsright>���νð� : </td>
						<td class=clsleft><?=$rApprTm?></td>
					</tr>
					<tr>
						<td class=clsright>�����ڵ� : </td>
						<td class=clsleft><?=$rBusiCd?></td>
					</tr>
					<tr>
						<td class=clsright>�������� : </td>
						<td class=clsleft><?=$rSuccYn?></td>
					</tr>
					<tr>
						<td class=clsright>ó���޼��� : </td>
						<td class=clsleft><?=$rResMsg?></td>
					</tr>
<?	if($AuthTy == "card" && $SubTy == "visa3d" ) {?>					
					<tr>
						<td class=clsright>�ֹ���ȣ : </td>
						<td class=clsleft><?=$rOrdNo?></td>
					</tr>
					<tr>
						<td class=clsright>�Һΰ��� : </td>
						<td class=clsleft><?=$rInstmt?></td>
					</tr>
					<tr>
						<td class=clsright>�����ݾ� : </td>
						<td class=clsleft><?=$rAmt?></td>
					</tr>
					<tr>
						<td class=clsright>ī����ڵ� : </td>
						<td class=clsleft><?=$rCardCd?></td>
					</tr>
					<tr>
						<td class=clsright>ī���� : </td>
						<td class=clsleft><?=$rCardNm?></td>
					</tr>
					<tr>
						<td class=clsright>���Ի��ڵ� : </td>
						<td class=clsleft><?=$rAquiCd?></td>
					</tr>
					<tr>
						<td class=clsright>���Ի�� : </td>
						<td class=clsleft><?=$rAquiNm?></td>
					</tr>
					<tr>
						<td class=clsright>��������ȣ : </td>
						<td class=clsleft><?=$rMembNo?></td>
					</tr>
<?	}	?>	
					
					<tr>
						<td class=clsright>�ŷ���ȣ : </td>
						<td class=clsleft><?=$rDealNo?></td>
					</tr>
					<tr>
						<td colspan=2>&nbsp;</td>
					</tr>
					<tr>
						<td align=center colspan=2>ī�� �̿������ ����ó�� <font color=red>���̽����̸���(��)</font>�� ǥ��˴ϴ�.</td>
					</tr>
					
				</table>
				</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td class=clsleft>Copyright NICEPayments.Co.,Ltd. All rights reserved..</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</html>
