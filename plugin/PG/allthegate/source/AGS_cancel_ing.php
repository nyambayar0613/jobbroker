<?php
/**********************************************************************************************
*
* ���ϸ� : AGS_cancel_ing.php
* �ۼ����� : 2016/10/11
* 
* �ô�����Ʈ �÷����ο��� ���ϵ� ����Ÿ�� �޾Ƽ� ������ҿ�û�� �մϴ�.
*
* Copyright NICEPayments.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/ 

	/****************************************************************************
	*
	* [1] ���̺귯��(AGSLib.php)�� ��Ŭ��� �մϴ�.
	*
	****************************************************************************/
	require ("./lib/AGSLib.php");
	
	/****************************************************************************
	*
	* [2]. agspay4.0 Ŭ������ �ν��Ͻ��� �����մϴ�.
	*
	****************************************************************************/
	$agspay = new agspay40;


	/****************************************************************************
	*
	* [3] AGS_pay.html �� ���� �Ѱܹ��� ����Ÿ
	*
	****************************************************************************/

	/*������*/
	//$agspay->SetValue("AgsPayHome","C:/htdocs/agspay");			//�ô�����Ʈ ������ġ ���丮 (������ �°� ����)
	$agspay->SetValue("AgsPayHome","/data2/local_docs/agspay40/php");			//�ô�����Ʈ ������ġ ���丮 (������ �°� ����)
	$agspay->SetValue("log","true");							//true : �αױ��, false : �αױ�Ͼ���.
	$agspay->SetValue("logLevel","ERROR");						//�α׷��� : DEBUG, INFO, WARN, ERROR, FATAL (�ش� �����̻��� �α׸� ��ϵ�)
	$agspay->SetValue("Type", "Cancel");						//������(�����Ұ�)
	$agspay->SetValue("RecvLen", 7);							//���� ������(����) üũ ������ 6 �Ǵ� 7 ����. 
	
	$agspay->SetValue("StoreId",trim($_POST["StoreId"]));		//�������̵�
	$agspay->SetValue("AuthTy",trim($_POST["AuthTy"]));			//��������
	$agspay->SetValue("SubTy",trim($_POST["SubTy"]));			//�����������
	$agspay->SetValue("rApprNo",trim($_POST["rApprNo"]));			//���ι�ȣ
	$agspay->SetValue("rApprTm",trim($_POST["rApprTm"]));			//��������
	$agspay->SetValue("rDealNo",trim($_POST["rDealNo"]));			//�ŷ���ȣ
	
	/****************************************************************************
	*
	* [4] �ô�����Ʈ ���������� ������ ��û�մϴ�.
	*
	****************************************************************************/
	echo ($agspay->startPay());

	/****************************************************************************
	*
	* [5] ��ҿ�û����� ���� ����DB ���� �� ��Ÿ �ʿ��� ó���۾��� �����ϴ� �κ��Դϴ�.
	*
	* �ſ�ī����� ��Ұ���� ���������� ���ŵǾ����Ƿ� DB �۾��� �� ��� 
	* ����������� �����͸� �����ϱ� �� �̺κп��� �ϸ�ȴ�.
	*
	* ���⼭ DB �۾��� �� �ּ���.
	* ��Ҽ������� : $agspay->GetResult("rCancelSuccYn") (����:y ����:n)
	* ��Ұ���޽��� : $agspay->GetResult("rCancelResMsg")
	*
	****************************************************************************/		
		
	if($agspay->GetResult("rCancelSuccYn") == "y")
	{ 
		// ������ҿ� ���� ó���κ�
		echo ("�ſ�ī�� ������Ұ� ����ó���Ǿ����ϴ�. [" . $agspay->GetResult("rCancelSuccYn")."]". $agspay->GetResult("rCancelResMsg").". " );
	}
	else
	{
		// �������п� ���� ����ó���κ�
		echo ("�ſ�ī�� ������Ұ� ����ó���Ǿ����ϴ�. [" . $agspay->GetResult("rCancelSuccYn")."]". $agspay->GetResult("rCancelResMsg").". " );
	}
?>
<html>
<head>
</head>
<body onload="javascript:frmAGS_cancel_ing.submit();">
<form name=frmAGS_cancel_ing method=post action=AGS_cancel_result.php>
<input type=hidden name=rStoreId value="<?=$agspay->GetResult("rStoreId")?>">
<input type=hidden name=AuthTy value="<?=$agspay->GetResult("AuthTy")?>">
<input type=hidden name=SubTy value="<?=$agspay->GetResult("SubTy")?>">
<input type=hidden name=rApprNo value="<?=$agspay->GetResult("rApprNo")?>">
<input type=hidden name=rApprTm value="<?=$agspay->GetResult("rApprTm")?>">
<input type=hidden name=rBusiCd value="<?=$agspay->GetResult("rBusiCd")?>">
<input type=hidden name=rSuccYn value="<?=$agspay->GetResult("rCancelSuccYn")?>">
<input type=hidden name=rResMsg value="<?=$agspay->GetResult("rCancelResMsg")?>">
<input type=hidden name=rOrdNo value="<?=$agspay->GetResult("rOrdNo")?>">
<input type=hidden name=rInstmt value="<?=$agspay->GetResult("rInstmt")?>">
<input type=hidden name=rAmt value="<?=$agspay->GetResult("rAmt")?>">
<input type=hidden name=rCardNm value="<?=$agspay->GetResult("rCardNm")?>">
<input type=hidden name=rCardCd value="<?=$agspay->GetResult("rCardCd")?>">
<input type=hidden name=rMembNo value="<?=$agspay->GetResult("rMembNo")?>">
<input type=hidden name=rAquiCd value="<?=$agspay->GetResult("rAquiCd")?>">
<input type=hidden name=rAquiNm value="<?=$agspay->GetResult("rAquiNm")?>">
<input type=hidden name=rDealNo value="<?=$agspay->GetResult("rDealNo")?>">
</form>
</body>
</html>
