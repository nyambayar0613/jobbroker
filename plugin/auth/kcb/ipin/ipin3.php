<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<?php
	header('Content-Type: text/html; charset=euc-kr');

	//�������˾����� ��ȸ�� PERSONALINFO
	@$encPsnlInfo = $_POST["encPsnlInfo"];
	//KCB���� ����Ű
	@$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);
	//KCB���� ����
	@$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);

	//�Ķ���Ϳ� ���� ��ȿ�����θ� �����Ѵ�.
	if(preg_match('~[^0-9a-zA-Z+/=]~', $encPsnlInfo, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBPUBKEY, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBSIGNATURE, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
  
	/*
	echo "$encPsnlInfo<br>";
	echo "$WEBPUBKEY<br>";
	echo "$WEBSIGNATURE<br>";
	*/
  
	//������ ������ ����� ���� Ű���� ����
	// �Ķ���� ����
    // ��ȣȭŰ ���� ���� (ipin1.php���� ������ ���� ����)
	$keyPath = "/okname/okname_test.key";	// �׽�Ʈ Ű����
	//$keyPath = "/okname/okname.key";		// � Ű����

	$cpCode    = "P00000000000";			// ȸ�����ڵ� (�׽�Ʈ�� ��� 'P00000000000'�� ����ϸ� ��� �߱޹��� ȸ�����ڵ带 ����)
	$endPointUrl = "http://twww.ok-name.co.kr:8888/KcbWebService/OkNameService";// �׽�Ʈ ����
	//$endPointURL = "http://www.ok-name.co.kr/KcbWebService/OkNameService";// � ����

    // �α� ��� ���� �� ���� �ο� (ipin1.php���� ������ ���� ����)
	$logPath = "/okname/log";
	$options = "SL";
		
	// ��ɾ�
	$cmd = array($keyPath, $cpCode, $endPointUrl, $WEBPUBKEY, $WEBSIGNATURE, $encPsnlInfo, $logPath, $options);
	//echo "$cmd<br>";
	
	/**************************************************************************
	 * okname ����
	 **************************************************************************/
	$output = NULL;
	// ����
	$ret = okname($cmd, $output);
    //echo "ret=$ret<br/>";
    
	$retcode = "";

	if($ret == 0) {
		$result = explode("\n", $output);
		$retcode=sprintf("B%03d", $ret);
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}
?>
<script language="JavaScript">
function fncOpenerSubmit() {
	opener.document.kcbOutForm.encPsnlInfo.value 		= "<?=$encPsnlInfo ?>";
<?php
	if ($ret == 0) { 
?>	
	opener.document.kcbOutForm.dupinfo.value 			= "<?=$result[0] ?>";
	opener.document.kcbOutForm.coinfo1.value            = "<?=$result[1] ?>";
	opener.document.kcbOutForm.coinfo2.value            = "<?=$result[2] ?>";
	opener.document.kcbOutForm.ciupdate.value           = "<?=$result[3] ?>";
	opener.document.kcbOutForm.virtualno.value 			= "<?=$result[4] ?>";
	opener.document.kcbOutForm.cpcode.value             = "<?=$result[5] ?>";
	opener.document.kcbOutForm.realname.value 			= "<?=$result[6] ?>";
	opener.document.kcbOutForm.cprequestnumber.value 	= "<?=$result[7] ?>";
	opener.document.kcbOutForm.age.value 				= "<?=$result[8] ?>";
	opener.document.kcbOutForm.sex.value 				= "<?=$result[9] ?>";
	opener.document.kcbOutForm.nationalinfo.value 		= "<?=$result[10]?>";
	opener.document.kcbOutForm.birthdate.value 			= "<?=$result[11]?>";
	opener.document.kcbOutForm.authinfo.value           = "<?=$result[12]?>";
<?php
	} 
?>	
	opener.document.kcbOutForm.action = "ipin4.php";
	opener.document.kcbOutForm.submit();
	self.close();
}
</script>
</head>
<body>
<?php
	if ($ret == 0) { 
?>	
  <input type="hidden" name="encPsnlInfo" 		value ="<?=$encPsnlInfo?>"/>
  <input type="hidden" name="dupinfo" 			value="<?=$result[0]?>"/>
  <input type="hidden" name="coinfo1" 			value="<?=$result[1]?>"/>
  <input type="hidden" name="coinfo2" 			value="<?=$result[2]?>"/>
  <input type="hidden" name="ciupdate" 			value="<?=$result[3]?>"/>
  <input type="hidden" name="virtualno"  		value="<?=$result[4]?>"/>
  <input type="hidden" name="cpcode"        	value="<?=$result[5]?>"/>
  <input type="hidden" name="realname" 			value="<?=$result[6]?>"/>
  <input type="hidden" name="cprequestnumber"	value="<?=$result[7]?>"/>
  <input type="hidden" name="age" 				value="<?=$result[8]?>"/>
  <input type="hidden" name="sex" 				value="<?=$result[9]?>"/>
  <input type="hidden" name="nationalinfo" 		value="<?=$result[10]?>"/>
  <input type="hidden" name="birthdate" 		value="<?=$result[11]?>"/>
  <input type="hidden" name="authinfo"      	value="<?=$result[12]?>"/>
<?php
	} 
?>	
</body>
<?php
	if($ret == 0) {
		echo("<script>alert('������������'); fncOpenerSubmit();</script>");
	} else {
		//������� ��ȣȭ ����
		echo("<script>alert('���������ȣȭ ���� : ".$ret."'); self.close(); </script>");
	}
?>
</html>
