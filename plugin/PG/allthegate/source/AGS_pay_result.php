<?php
/**********************************************************************************************
*
* ���ϸ� : AGS_pay_result.php
* �ۼ����� : 2016/10/11
*
* ���ϰ�������� ó���մϴ�.
*
* Copyright NICEPayments.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/

//������
$AuthTy 		= trim( $_POST["AuthTy"] );				//��������
$SubTy 			= trim( $_POST["SubTy"] );				//�����������
$rStoreId 		= trim( $_POST["rStoreId"] );			//��üID
$rAmt 			= trim( $_POST["rAmt"] );				//�ŷ��ݾ�
$rOrdNo 		= trim( $_POST["rOrdNo"] );				//�ֹ���ȣ
$rProdNm 		= trim( $_POST["rProdNm"] );			//��ǰ��
$rOrdNm			= trim( $_POST["rOrdNm"] );				//�ֹ��ڸ�

//������Ű���(�ſ�ī��,�ڵ���,�Ϲݰ������)�� ���
$rSuccYn 		= trim( $_POST["rSuccYn"] );			//��������
$rResMsg 		= trim( $_POST["rResMsg"] );			//���л���
$rApprTm 		= trim( $_POST["rApprTm"] );			//���νð�

//�ſ�ī�����
$rBusiCd 		= trim( $_POST["rBusiCd"] );			//�����ڵ�
$rApprNo 		= trim( $_POST["rApprNo"] );			//���ι�ȣ
$rCardCd 		= trim( $_POST["rCardCd"] );			//ī����ڵ�
$rDealNo 		= trim( $_POST["rDealNo"] );			//�ŷ�������ȣ

//�ſ�ī��(�Ƚ�,�Ϲ�)
$rCardNm 		= trim( $_POST["rCardNm"] );			//ī����
$rMembNo 		= trim( $_POST["rMembNo"] );			//��������ȣ
$rAquiCd 		= trim( $_POST["rAquiCd"] );			//���Ի��ڵ�
$rAquiNm 		= trim( $_POST["rAquiNm"] );			//���Ի��


//������ü
$ICHE_OUTBANKNAME	= trim( $_POST["ICHE_OUTBANKNAME"] );		//��ü���������
$ICHE_OUTACCTNO 	= trim( $_POST["ICHE_OUTACCTNO"] );			//��ü���¹�ȣ
$ICHE_OUTBANKMASTER = trim( $_POST["ICHE_OUTBANKMASTER"] );		//��ü���¼�����
$ICHE_AMOUNT 		= trim( $_POST["ICHE_AMOUNT"] );			//��ü�ݾ�

//�ڵ���
$rHP_TID 		= trim( $_POST["rHP_TID"] );			//�ڵ�������TID
$rHP_DATE 		= trim( $_POST["rHP_DATE"] );			//�ڵ���������¥
$rHP_HANDPHONE 	= trim( $_POST["rHP_HANDPHONE"] );		//�ڵ��������ڵ�����ȣ
$rHP_COMPANY 	= trim( $_POST["rHP_COMPANY"] );		//�ڵ���������Ż��(SKT,KTF,LGT)

//ARS
$rARS_PHONE = trim( $_POST["rARS_PHONE"] );				//ARS������ȭ��ȣ

//�������
$rVirNo 		= trim( $_POST["rVirNo"] );				//������¹�ȣ ��������߰�
$VIRTUAL_CENTERCD = trim( $_POST["VIRTUAL_CENTERCD"] );	//������� �Ա������ڵ�

//����ũ��
$ES_SENDNO	= trim( $_POST["ES_SENDNO"] );				//����ũ��(������ȣ)

//*******************************************************************************
//* MD5 ���� ������ ���󿩺� Ȯ��
//* ������ AGS_HASHDATA ���� ���� �� rAGS_HASHDATA�� ��ġ ���� Ȯ��
//* ���� : �������̵�(StoreId) + �ֹ���ȣ(OrdNo) + �����ݾ�(Amt)
//*******************************************************************************

$AGS_HASHDATA	= trim( $_POST["AGS_HASHDATA"] );				
$rAGS_HASHDATA	= md5($rStoreId . $rOrdNo . (int)$rAmt);				

if($AGS_HASHDATA == $rAGS_HASHDATA){
	$errResMsg   = "";
}else{
	$errResMsg   = "����ݾ� ���� �߻�. Ȯ�� �ٶ�";
}

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
<script language=javascript> // "����ó����" �˾�â �ݱ�
<!--
var openwin = window.open("AGS_progress.html","popup","width=300,height=160");
openwin.close();
-->
</script>
<script language=javascript>
<!--
/***********************************************************************************
* �� ������ ����� ���� �ڹٽ�ũ��Ʈ
*		
*	������ ����� [ī�����]�ÿ��� ����Ͻ� �� �ֽ��ϴ�.
*  
*   �ش��� �����ǿ� ���ؼ� ������ ����� �����մϴ�.
*     ���� ���Ŀ��� �Ʒ��� �ּҸ� �˾�(630X510)���� ��� ���� ��ȸ �� ����Ͻñ� �ٶ��ϴ�.
*	  �� �˾��� ����������ȸ ������ �ּ� : 
*	     	 http://www.allthegate.com/support/card_search.html
*		�� (�ݵ�� ��ũ�ѹٸ� 'yes' ���·� �Ͽ� �˾��� ���ñ� �ٶ��ϴ�.) ��
*
***********************************************************************************/
function show_receipt() 
{
	if("<?=$rSuccYn?>"== "y" && "<?=$AuthTy?>"=="card")
	{
		var send_dt = appr_tm.value;
		
		url="http://www.allthegate.com/customer/receiptLast3.jsp"
		url=url+"?sRetailer_id="+sRetailer_id.value;
		url=url+"&approve="+approve.value;
		url=url+"&send_no="+send_no.value;
		url=url+"&send_dt="+send_dt.substring(0,8);
		
		window.open(url, "window","toolbar=no,location=no,directories=no,status=,menubar=no,scrollbars=no,resizable=no,width=420,height=700,top=0,left=150");
	}
	else
	{
		alert("�ش��ϴ� ���������� �����ϴ�");
	}
}
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
				<td class=clsleft>���� ���</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td>
				<table width=400 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td class=clsright width=150>�������� : </td>
						<td class=clsleft width=250>
							<?php

							if($AuthTy == "card")
							{
								if($SubTy == "isp")
								{
									echo "�ſ�ī�����-��������(ISP)";
								}	
								else if($SubTy == "visa3d")
								{
									echo "�ſ�ī�����-�Ƚ�Ŭ��";
								}
								else if($SubTy == "normal")
								{
									echo "�ſ�ī�����-�Ϲݰ���";
								}
								
							}
							else if($AuthTy == "iche")
							{
								echo "������ü";
							}
							else if($AuthTy == "hp")
							{
								echo "�ڵ�������";
							}
							else if($AuthTy == "ars")
							{
								echo "ARS����";
							}
							else if($AuthTy == "virtual")
							{
								echo "������°���";
							}
							?>
						</td>
					</tr>
					<tr>
						<td class=clsright>�������̵� : </td>
						<td class=clsleft><?=$rStoreId?></td>
					</tr>
					<tr>
						<td class=clsright>�ֹ���ȣ : </td>
						<td class=clsleft><?=$rOrdNo?></td>
					</tr>
					<tr>
						<td class=clsright>�ֹ��ڸ� : </td>
						<td class=clsleft><?=$rOrdNm?></td>
					</tr>
					<tr>
						<td class=clsright>��ǰ�� : </td>
						<td class=clsleft><?=$rProdNm?></td>
					</tr>
					<tr>
						<td class=clsright>�����ݾ� : </td>
						<td class=clsleft><?=$rAmt?></td>
					</tr>
					<tr>
						<td class=clsright>�������� : </td>
						<td class=clsleft><?=$rSuccYn?></td>
					</tr>
					<tr>
						<td class=clsright>ó���޼��� : </td>
						<td class=clsleft><?=$rResMsg?></td>
					</tr>
<?				if($AuthTy == "card" || $AuthTy == "virtual") { ?>
					<tr>
						<td class=clsright>���νð� : </td>
						<td class=clsleft><?=$rApprTm?></td>
					</tr>
<?				}
				if($AuthTy == "card" && $rSuccYn == "y") {?>
					<tr>
						<td class=clsright>�����ڵ� : </td>
						<td class=clsleft><?=$rBusiCd?></td>
					</tr>
					<tr>
						<td class=clsright>���ι�ȣ : </td>
						<td class=clsleft><?=$rApprNo?></td>
					</tr>
					<tr>
						<td class=clsright>ī����ڵ� : </td>
						<td class=clsleft><?=$rCardCd?></td>
					</tr>
					<tr>
						<td class=clsright>�ŷ���ȣ : </td>
						<td class=clsleft><?=$rDealNo?></td>
					</tr>
<?				}
				if($AuthTy == "card" && ($SubTy == "visa3d" || $SubTy == "normal") && $rSuccYn == "y") {?>
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
<?				}
				if($AuthTy == "iche" ) {?>
					<tr>
						<td class=clsright>��ü��������� : </td>
						<td class=clsleft><?=$ICHE_OUTBANKNAME?><?=getCenter_cd($ICHE_OUTBANKNAME)?></td>
					</tr>
					<tr>
						<td class=clsright>��ü�ݾ� : </td>
						<td class=clsleft><?=$ICHE_AMOUNT?></td>
					</tr>
					<tr>
						<td class=clsright>��ü���¼����� : </td>
						<td class=clsleft><?=$ICHE_OUTBANKMASTER?></td>
					</tr>
					<tr>
						<td class=clsright>����ũ��(SEND_NO) : </td>
						<td class=clsleft><?=$ES_SENDNO?></td>
					</tr>
<?				}
				if($AuthTy == "hp" ) {?>
					<tr>
						<td class=clsright>�ڵ�������TID : </td>
						<td class=clsleft><?=$rHP_TID?></td>
					</tr>
					<tr>
						<td class=clsright>�ڵ���������¥ : </td>
						<td class=clsleft><?=$rHP_DATE?></td>
					</tr>
					<tr>
						<td class=clsright>�ڵ��������ڵ�����ȣ : </td>
						<td class=clsleft><?=$rHP_HANDPHONE?></td>
					</tr>
					<tr>
						<td class=clsright>�ڵ���������Ż�� : </td>
						<td class=clsleft><?=$rHP_COMPANY?></td>
					</tr>
<?				}
				if($AuthTy == "ars" ) {?>
					<tr>
						<td class=clsright>ARS����TID : </td>
						<td class=clsleft><?=$rHP_TID?></td>
					</tr>
					<tr>
						<td class=clsright>ARS������¥ : </td>
						<td class=clsleft><?=$rHP_DATE?></td>
					</tr>
					<tr>
						<td class=clsright>ARS������ȭ��ȣ : </td>
						<td class=clsleft><?=$rARS_PHONE?></td>
					</tr>
					<tr>
						<td class=clsright>ARS������Ż�� : </td>
						<td class=clsleft><?=$rHP_COMPANY?></td>
					</tr>
<?				}
				if($AuthTy == "virtual" ) {?>
					<tr>
						<td class=clsright>�Աݰ��¹�ȣ : </td>
						<td class=clsleft><?=$rVirNo?></td>
					</tr>
                    <tr><!-- �����ڵ�(20) : �츮���� -->
						<td class=clsright>�Ա����� : </td>
						<td class=clsleft><?=getCenter_cd($VIRTUAL_CENTERCD)?></td>
					</tr>
                    <tr>
					<!--�ô�����Ʈ�� ��ϵ� ���������� ǥ��-------->
						<td class=clsright>�����ָ� : </td>
						<td class=clsleft>���̽����̸���(��)</td>
					</tr>
					<tr>
						<td class=clsright>����ũ��(SEND_NO) : </td>
						<td class=clsleft><?=$ES_SENDNO?></td>
					</tr>
<?				}
				if($AuthTy == "card" ) {?>
					<tr>
						<td class=clsright>������ :</td>
						<!--��������������ؼ������ִ°�-------------------->
						<input type=hidden name=sRetailer_id value="<?=$rStoreId?>"><!--�������̵�-->
						<input type=hidden name=approve value="<?=$rApprNo?>"><!---���ι�ȣ-->
						<input type=hidden name=send_no value="<?=$rDealNo?>"><!--�ŷ�������ȣ-->
						<input type=hidden name=appr_tm value="<?=$rApprTm?>"><!--���νð�-->
						<!--��������������ؼ������ִ°�-------------------->
						<td class=clsleft><input type="button" value="������" onclick="javascript:show_receipt();"></td>
					</tr>
					<tr>
						<td colspan=2>&nbsp;</td>
					</tr>
					<tr>
						<td align=center colspan=2>ī�� �̿������ ����ó�� <font color=red>���̽����̸���(��)</font>�� ǥ��˴ϴ�.</td>
					</tr>
<?				}	?>
					<tr>
						<td colspan="2"><?=$errResMsg?></td>
					</tr>
					<tr>
						<td colspan="2">���� �ؽ� : <?=$AGS_HASHDATA?></td>
					</tr>
					<tr>
						<td colspan="2">��� �ؽ� :<?=$rAGS_HASHDATA?></td>
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
<?
	function getCenter_cd($VIRTUAL_CENTERCD){
		if($VIRTUAL_CENTERCD == "39"){
			echo "�泲����";
		}else if($VIRTUAL_CENTERCD == "34"){
			echo "��������";
		}else if($VIRTUAL_CENTERCD == "04"){
			echo "��������";
		}else if($VIRTUAL_CENTERCD == "11"){
			echo "�����߾�ȸ";
		}else if($VIRTUAL_CENTERCD == "31"){
			echo "�뱸����";
		}else if($VIRTUAL_CENTERCD == "32"){
			echo "�λ�����";
		}else if($VIRTUAL_CENTERCD == "02"){
			echo "�������";
		}else if($VIRTUAL_CENTERCD == "45"){
			echo "�������ݰ�";
		}else if($VIRTUAL_CENTERCD == "07"){
			echo "�����߾�ȸ";
		}else if($VIRTUAL_CENTERCD == "48"){
			echo "�ſ���������";
		}else if($VIRTUAL_CENTERCD == "26"){
			echo "(��)��������";
		}else if($VIRTUAL_CENTERCD == "05"){
			echo "��ȯ����";
		}else if($VIRTUAL_CENTERCD == "20"){
			echo "�츮����";
		}else if($VIRTUAL_CENTERCD == "71"){
			echo "��ü��";
		}else if($VIRTUAL_CENTERCD == "37"){
			echo "��������";
		}else if($VIRTUAL_CENTERCD == "23"){
			echo "��������";
		}else if($VIRTUAL_CENTERCD == "35"){
			echo "��������";
		}else if($VIRTUAL_CENTERCD == "21"){
			echo "(��)��������";
		}else if($VIRTUAL_CENTERCD == "03"){
			echo "�߼ұ������";
		}else if($VIRTUAL_CENTERCD == "81"){
			echo "�ϳ�����";
		}else if($VIRTUAL_CENTERCD == "88"){
			echo "��������";
		}else if($VIRTUAL_CENTERCD == "27"){
			echo "�ѹ�����";
		}
				}
?>
