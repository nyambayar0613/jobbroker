<?php

//������ ���� �����ص帮�� ������������ ���� ���� �� �������� ������ �ֽñ� �ٶ��ϴ�. 

	/********************************************************************************************************************************************
		NICE������ Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		���񽺸� : �����ֹι�ȣ���� (IPIN) ����
		�������� : �����ֹι�ȣ���� (IPIN) ����� ���� ���� ó�� ������
		
				   ���Ź��� ������(�������)�� ����ȭ������ �ǵ����ְ�, close�� �ϴ� ��Ȱ�� �մϴ�.
	*********************************************************************************************************************************************/
	
	// ����� ���� �� CP ��û��ȣ�� ��ȣȭ�� ����Ÿ�Դϴ�. (ipin_main.php ���������� ��ȣȭ�� ����Ÿ�ʹ� �ٸ��ϴ�.)
	$sResponseData = $_POST['enc_data'];
	
	// ipin_main.php ���������� ������ ����Ÿ�� �ִٸ�, �Ʒ��� ���� Ȯ�ΰ����մϴ�.
	$sReservedParam1  = $_POST['param_r1'];
	$sReservedParam2  = $_POST['param_r2'];
	$sReservedParam3  = $_POST['param_r3'];
	
		//////////////////////////////////////////////// ���ڿ� ����///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $sResponseData, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
    if(base64_encode(base64_decode($sResponseData))!=$sResponseData) {echo "�Է� �� Ȯ���� �ʿ��մϴ�!"; exit;}
    
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam1, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam2, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam3, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// ��ȣȭ�� ����� ������ �����ϴ� ���
	if ($sResponseData != "") {

?>

<html>
<head>
	<title>NICE������ �����ֹι�ȣ ����</title>
	<script language='javascript'>
		function fnLoad()
		{
			// ��翡���� �ֻ����� �����ϱ� ���� 'parent.opener.parent.document.'�� �����Ͽ����ϴ�.
			// ���� �ͻ翡 ���μ����� �°� �����Ͻñ� �ٶ��ϴ�.
			parent.opener.parent.document.vnoform.enc_data.value = "<?= $sResponseData ?>";
			
			parent.opener.parent.document.vnoform.param_r1.value = "<?= $sReservedParam1 ?>";
			parent.opener.parent.document.vnoform.param_r2.value = "<?= $sReservedParam2 ?>";
			parent.opener.parent.document.vnoform.param_r3.value = "<?= $sReservedParam3 ?>";
			
			parent.opener.parent.document.vnoform.target = "Parent_window";
			
			// ���� �Ϸ�ÿ� ��������� �����ϰ� �Ǵ� �ͻ� Ŭ���̾�Ʈ ��� ������ URL
			parent.opener.parent.document.vnoform.action = "ipin_result.php";
			parent.opener.parent.document.vnoform.submit();
			
			self.close();
		}
	</script>
</head>
<body onLoad="fnLoad()">

<?
	} else {
?>

<html>
<head>
	<title>NICE������ �����ֹι�ȣ ����</title>
	<body onLoad="self.close()">

<?
	}
?>

</body>
</html>