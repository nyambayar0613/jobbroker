<html>
<head>
	<title>NICE������ �����ֹι�ȣ ����</title>
<style type="text/css"> 
BODY
{
    COLOR: #7f7f7f;
    FONT-FAMILY: "Dotum","DotumChe","Arial";
    BACKGROUND-COLOR: #ffffff;
}
</style>
</head>

<body>

<?php

//������ ���� �����ص帮�� ������������ ���� ���� �� �������� ������ �ֽñ� �ٶ��ϴ�. 

	session_start();
	/********************************************************************************************************************************************
		NICE������ Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		���񽺸� : �����ֹι�ȣ���� (IPIN) ����
		�������� : �����ֹι�ȣ���� (IPIN) ����� ���� ���� ��� ������
		
				   ���Ź��� ������(�������)�� ��ȣȭ�Ͽ� ����� ������ Ȯ���մϴ�.
				   
			   
	*********************************************************************************************************************************************/
	/*****************************
	//����ġ���� ��� �ε尡 ���� �ʾ������ �������� ����� �ε��մϴ�.
	if(!extension_loaded('IPINClient')) {
		dl('IPINClient.' . PHP_SHLIB_SUFFIX);
	}
	$module = 'IPINClient';
	*****************************/
	
	$sSiteCode					= "";			// IPIN ���� ����Ʈ �ڵ�		(NICE���������� �߱��� ����Ʈ�ڵ�)
	$sSitePw					= "";			// IPIN ���� ����Ʈ �н�����	(NICE���������� �߱��� ����Ʈ�н�����)
	
	$sEncData					= "";			// ��ȣȭ �� ����� ���� ����
	$sDecData					= "";			// ��ȣȭ �� ����� ���� ����
	
	$sRtnMsg					= "";			// ó����� �޼���
		
  $sEncData = $_POST['enc_data'];	// ipin_process.php ���� ���Ϲ��� ��ȣȭ �� ����� ���� ����
  
		//////////////////////////////////////////////// ���ڿ� ����///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $sEncData, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
    if(base64_encode(base64_decode($sEncData))!=$sEncData) {echo "�Է� �� Ȯ���� �ʿ��մϴ�!"; exit;}
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////  
	
	// ipin_main.php ���� ������ ���� ������ �����մϴ�.
	// ����Ÿ ������ ������ ���� Ȯ���ϱ� �����̹Ƿ�, �ʼ������� �ƴϸ� ������ ���� �ǰ�����Դϴ�.
	$sCPRequest = $_SESSION['CPREQUEST'];
    
    if ($sEncData != "") {
    
    	// ����� ������ ��ȣȭ �մϴ�.
    	
			//if (extension_loaded($module)) {  // �������� ��� �ε� ������� 
				$sDecData = get_response_data($sSiteCode, $sSitePw, $sEncData);
			//} else {
			//	$sDecData = "Module get_response_data is not compiled into PHP";
			//}
			
    	if ($sDecData == -9) {
    		$sRtnMsg = "�Է°� ���� : ��ȣȭ ó����, �ʿ��� �Ķ���Ͱ��� ������ ��Ȯ�ϰ� �Է��� �ֽñ� �ٶ��ϴ�.";
    	} else if ($sDecData == -12) {
    		$sRtnMsg = "NICE���������� �߱��� ���������� ��Ȯ���� Ȯ���� ������.";
    	} else {
    	
    		// ��ȣȭ�� ����Ÿ �����ڴ� ^ �̸�, �����ڷ� ����Ÿ�� �Ľ��մϴ�.
    		/*
    			- ��ȣȭ�� ����Ÿ ����
    			�����ֹι�ȣȮ��ó������ڵ�^�����ֹι�ȣ^����^�ߺ�Ȯ�ΰ�(DupInfo)^��������^��������^�������(YYYYMMDD)^���ܱ�������^���� ��û Sequence
    		*/
    		$arrData = split("\^", $sDecData);
    		$iCount = count($arrData);
    		
    		if ($iCount >= 5) {
    		
    			/*
					������ ���� ����� ������ ������ �� �ֽ��ϴ�.
					����ڿ��� �����ִ� ������, '�̸�' ����Ÿ�� ���� �����մϴ�.
				
					����� ������ �ٸ� ���������� �̿��Ͻ� ��쿡��
					������ ���Ͽ� ��ȣȭ ����Ÿ($sEncData)�� ����Ͽ� ��ȣȭ �� �̿��Ͻǰ��� �����մϴ�. (���� �������� ���� ó�����)
					
					����, ��ȣȭ�� ������ ����ؾ� �ϴ� ��쿣 ����Ÿ�� ������� �ʵ��� ������ �ּ���. (����ó�� ����)
					form �±��� hidden ó���� ����Ÿ ���� ������ �����Ƿ� �������� �ʽ��ϴ�.
				*/
				
				$strResultCode	= $arrData[0];			// ����ڵ�
				if ($strResultCode == 1) {
					$strCPRequest	= $arrData[8];			// CP ��û��ȣ
					
					if ($sCPRequest == $strCPRequest) {
				
						$sRtnMsg = "����� ���� ����";
						
						$strVno      		= $arrData[1];	// �����ֹι�ȣ (13�ڸ��̸�, ���� �Ǵ� ���� ����)
						$strUserName		= $arrData[2];	// �̸�
						$strDupInfo			= $arrData[3];	// �ߺ����� Ȯ�ΰ� (64Byte ������)
						$strAgeInfo			= $arrData[4];	// ���ɴ� �ڵ� (���� ���̵� ����)
					    $strGender			= $arrData[5];	// ���� �ڵ� (���� ���̵� ����)
					    $strBirthDate		= $arrData[6];	// ������� (YYYYMMDD)
					    $strNationalInfo	= $arrData[7];	// ��/�ܱ��� ���� (���� ���̵� ����)
					
					} else {
						$sRtnMsg = "CP ��û��ȣ ����ġ : ���ǿ� ���� $sCPRequest ����Ÿ�� Ȯ���� �ֽñ� �ٶ��ϴ�.";
					}
				} else {
					$sRtnMsg = "���ϰ� Ȯ�� ��, NICE������ ���� ����ڿ��� ������ �ּ���. [$strResultCode]";
				}
    		
    		} else {
    			$sRtnMsg = "���ϰ� Ȯ�� ��, NICE������ ���� ����ڿ��� ������ �ּ���.";
    		}
    	
    	}
    } else {
    	$sRtnMsg = "ó���� ��ȣȭ ����Ÿ�� �����ϴ�.";
    }
	
?>

	ó����� : <?= $sRtnMsg ?><br>
	�̸� : <?= $strUserName ?><br>

	<form name="user" method="post">
		<input type="hidden" name="enc_data" value="<?= $sEncData ?>"><br>
	</form>
</body>
</html>