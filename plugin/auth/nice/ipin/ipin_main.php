<?php

//������ ���� �����ص帮�� ������������ ���� ���� �� �������� ������ �ֽñ� �ٶ��ϴ�. 

	session_start();
	/********************************************************************************************************************************************
		NICE������ Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		���񽺸� : �����ֹι�ȣ���� (IPIN) ����
		�������� : �����ֹι�ȣ���� (IPIN) ȣ�� ������
		
		[ PHP Ȯ���� ��ġ �ȳ� ]
		1.	Php.ini ������ ���� ���� �� Ȯ���� ���(extension_dir)�� ������ ��ġ�� ÷�ε� IPINClient.so ������ �����մϴ�.
		2.	Php.ini ���Ͽ� ������ ���� ������ �߰� �մϴ�.
				extension=IPINClient.so
		3.	����ġ �� ���� �մϴ�.
		
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
	
	$sReturnURL					= "";			// �ϴܳ��� ����
	$sCPRequest					= "";			// �ϴܳ��� ����
	
	//if (extension_loaded($module)) {// �������� ��� �ε� �������
		$sCPRequest = get_request_no($sSiteCode);
	//} else {
	//	$sCPRequest = "Module get_request_no is not compiled into PHP";
	//}
	
	// ���� ������ ������ ������ ipin_result.php ���������� ����Ÿ ������ ������ ���� Ȯ���ϱ� �����Դϴ�.
	// �ʼ������� �ƴϸ�, ������ ���� �ǰ�����Դϴ�.
	$_SESSION['CPREQUEST'] = $sCPRequest;
    
    $sEncData					= "";			// ��ȣȭ �� ����Ÿ
	$sRtnMsg					= "";			// ó����� �޼���
	
    // ���� ������� ����, ���μ��� ���࿩�θ� �ľ��մϴ�.

  
		//if (extension_loaded($module)) {/ �������� ��� �ε� �������
			$sEncData = get_request_data($sSiteCode, $sSitePw, $sCPRequest, $sReturnURL);
		//} else {
		//	$sEncData = "Module get_request_data is not compiled into PHP";
		//}
    
    // ���� ������� ���� ó������
    if ($sEncData == -9)
    {
    	$sRtnMsg = "�Է°� ���� : ��ȣȭ ó����, �ʿ��� �Ķ���Ͱ��� ������ ��Ȯ�ϰ� �Է��� �ֽñ� �ٶ��ϴ�.";
    } else {
    	$sRtnMsg = "$sEncData ������ ��ȣȭ ����Ÿ�� Ȯ�εǸ� ����, ������ �ƴ� ��� �����ڵ� Ȯ�� �� NICE������ ���� ����ڿ��� ������ �ּ���.";
    }

	/*
	
	�� sReturnURL ������ ���� ����  ����������������������������������������������������������������������������������������������������������
		NICE������ �˾����� �������� ����� ������ ��ȣȭ�Ͽ� �ͻ�� �����մϴ�.
		���� ��ȣȭ�� ��� ����Ÿ�� ���Ϲ����� URL ������ �ּ���.
		
		* URL �� http ���� �Է��� �ּž��ϸ�, �ܺο����� ������ ��ȿ�� �������� �մϴ�.
		* ��翡�� �����ص帰 ���������� ��, ipin_process.jsp �������� ����� ������ ���Ϲ޴� ���� �������Դϴ�.
		
		�Ʒ��� URL �����̸�, �ͻ��� ���� �����ΰ� ������ ���ε� �� ���������� ��ġ�� ���� ��θ� �����Ͻñ� �ٶ��ϴ�.
		�� - http://www.test.co.kr/ipin_process.jsp, https://www.test.co.kr/ipin_process.jsp, https://test.co.kr/ipin_process.jsp
	������������������������������������������������������������������������������������������������������������������������������������������
	
	�� sCPRequest ������ ���� ����  ����������������������������������������������������������������������������������������������������������
		[CP ��û��ȣ]�� �ͻ翡�� ����Ÿ�� ���Ƿ� �����ϰų�, ��翡�� ������ ���� ����Ÿ�� ������ �� �ֽ��ϴ�. (�ִ� 30byte ������ ����)
		
		CP ��û��ȣ�� ���� �Ϸ� ��, ��ȣȭ�� ��� ����Ÿ�� �Բ� �����Ǹ�
		����Ÿ ������ ���� �� Ư�� ����ڰ� ��û�� ������ Ȯ���ϱ� ���� �������� �̿��Ͻ� �� �ֽ��ϴ�.
		
		���� �ͻ��� ���μ����� �����Ͽ� �̿��� �� �ִ� ����Ÿ�̱⿡, �ʼ����� �ƴմϴ�.
	������������������������������������������������������������������������������������������������������������������������������������������
	*/
	

?>

<html>
<head>
	<title>NICE������ �����ֹι�ȣ ����</title>
	
	<script language='javascript'>
	window.name ="Parent_window";
	
	function fnPopup(){
		window.open('', 'popupIPIN2', 'width=450, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_ipin.target = "popupIPIN2";
		document.form_ipin.action = "https://cert.vno.co.kr/ipin.cb";
		document.form_ipin.submit();
	}
	</script>
</head>

<body>
<?= $sRtnMsg ?><br><br>
��ü���� ��ȣȭ ����Ÿ : [<?= $sEncData ?>]<br><br>

<!-- �����ֹι�ȣ ���� �˾��� ȣ���ϱ� ���ؼ��� ������ ���� form�� �ʿ��մϴ�. -->
<form name="form_ipin" method="post">
	<input type="hidden" name="m" value="pubmain">						<!-- �ʼ� ����Ÿ��, �����Ͻø� �ȵ˴ϴ�. -->
    <input type="hidden" name="enc_data" value="<?= $sEncData ?>">		<!-- ������ ��ü������ ��ȣȭ �� ����Ÿ�Դϴ�. -->
    
    <!-- ��ü���� ����ޱ� ���ϴ� ����Ÿ�� �����ϱ� ���� ����� �� ������, ������� ����� �ش� ���� �״�� �۽��մϴ�.
    	 �ش� �Ķ���ʹ� �߰��Ͻ� �� �����ϴ�. -->
    <input type="hidden" name="param_r1" value="">
    <input type="hidden" name="param_r2" value="">
    <input type="hidden" name="param_r3" value="">
    
    <a href="javascript:fnPopup();"><img src="http://image.creditbank.co.kr/static/img/vno/new_img/bt_17.gif" width=218 height=40 border=0></a>
</form>



<!-- �����ֹι�ȣ ���� �˾� ���������� ����ڰ� ������ ������ ��ȣȭ�� ����� ������ �ش� �˾�â���� �ްԵ˴ϴ�.
	 ���� �θ� �������� �̵��ϱ� ���ؼ��� ������ ���� form�� �ʿ��մϴ�. -->
<form name="vnoform" method="post">
	<input type="hidden" name="enc_data">								<!-- �������� ����� ���� ��ȣȭ ����Ÿ�Դϴ�. -->
	
	<!-- ��ü���� ����ޱ� ���ϴ� ����Ÿ�� �����ϱ� ���� ����� �� ������, ������� ����� �ش� ���� �״�� �۽��մϴ�.
    	 �ش� �Ķ���ʹ� �߰��Ͻ� �� �����ϴ�. -->
    <input type="hidden" name="param_r1" value="">
    <input type="hidden" name="param_r2" value="">
    <input type="hidden" name="param_r3" value="">
</form>

</body>
</html>