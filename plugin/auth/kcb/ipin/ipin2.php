<?php
$alice_path = $_SERVER['DOCUMENT_ROOT'].'/';
$cat_path = $_SERVER['DOCUMENT_ROOT'].'/';
include_once $alice_path.'conn.php';

include NFE_PATH.'/engine/netfu_auth.class.php';
$netfu_auth = new netfu_auth();


	// KCB �׽�Ʈ������ ȣ���� ���
	$idpUrl    = "https://tipin.ok-name.co.kr:8443/tis/ti/POTI90B_SendCertInfo.jsp";
	// KCB ������� ȣ���� ���
	//$idpUrl    = "https://ipin.ok-name.co.kr/tis/ti/POTI90B_SendCertInfo.jsp";

	// ������ ������ ��ġ�� ���ƿ� ������ �ּ�. opener(ipin1.php)�� �����ϰ� ��ġ�ϵ��� �����ؾ� ��.
	// (http://www.test.co.kr�� http://test.co.kr�� �ٸ� ���������� �ν��ϸ�, http �� https�� ��ġ�ؾ� ��)
	$realpath = $_SERVER['DOCUMENT_ROOT'] . "/modules/okname";
	$returnUrl = "http://".$_SERVER['HTTP_HOST']."/modules/okname/ipin_sample/ipin3.php";		// ������ ������ ��ġ�� ���ƿ� ������ �ּ�

	$idpCode   = "V";					// ������. KCB����ڵ�
	$cpCode    = $netfu_auth->auth_id;		// ȸ�����ڵ� (�׽�Ʈ�� ��� 'P00000000000'�� ����ϸ� ��� �߱޹��� ȸ�����ڵ带 ����)


	// ��� ��� ���� �� ���� �ο� (������)
	$exe = $realpath . "/linux32_nonstatic_glibc2.3.4/okname";
	// ��ȣȭŰ ���� ���� (������) - ������ �־��� ���ϸ����� �ڵ� �����Ǹ� �ſ����� ���ŵ�. �������� �ش������� ������ ���� �ʿ�.
	$keyPath = $realpath . "/okname.key";
	$memId = $cpCode;			// ȸ�����ڵ�
	$reserved1 = "0";			//reserved1
	$reserved2 = "0";			//reserved2
	$endPointURL = "http://twww.ok-name.co.kr:8888/KcbWebService/OkNameService";// �׽�Ʈ ����
	//$endPointURL = "http://www.ok-name.co.kr/KcbWebService/OkNameService";// � ����
	// �α� ��� ���� �� ���� �ο� (������)
	// options���� 'L'�� �߰��ϴ� ��쿡�� �αװ� ������.
	$logPath = $realpath . "/log";					// �α������� ����� ��� �α������� ������ ���
	$options = "CL";// Option

	// ��ɾ�
	$cmd = "$exe $keyPath $memId \"{$reserved1}\" \"{$reserved2}\" $endPointURL $logPath $options";

	// �Ķ���� ���� (K���)
	echo "$cmd<br>";
	
	// ����
	exec($cmd, $out, $ret);

	echo "ret=".$ret."<br/>";

	$retcode = "";										// ����ڵ�
	$pubkey = "";
	$sig = "";
	$curtime = "";

	if ($ret == 0) {//������ ��� ������ ������� ����
		$retcode=sprintf("B%03d", $ret);
		$pubkey=$out[0];
		$sig=$out[1];
		$curtime=$out[2];
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}

/*
echo "$pubkey<br/>";
echo "$sig<br/>";
echo "$curtime<br/>";
*/

?>
<html>
  <head>
	<script language="JavaScript">
	//<!--
	function certKCBIpin(){
		document.kcbInForm.target = "_self";

		//KCB �׽�Ʈ������ ȣ���� ���
		document.kcbInForm.action = "https://tipin.ok-name.co.kr:8443/tis/ti/POTI01A_LoginRP.jsp";

		//KCB ������� ȣ���� ���
		//document.kcbInForm.action = "https://ipin.ok-name.co.kr/tis/ti/POTI01A_LoginRP.jsp";

		//������û
		document.kcbInForm.submit();
		return	;
	}
	//-->
	</script>
  </head>
<body onload="javascript:certKCBIpin();">
	<form name="kcbInForm" method="post" >
		<input type="hidden" name="IDPCODE" value="<?=$idpCode?>" />
		<input type="hidden" name="IDPURL" value="<?=$idpUrl?>" />
		<input type="hidden" name="CPCODE" value="<?=$cpCode?>" />
		<input type="hidden" name="CPREQUESTNUM" value="<?=$curtime?>" />
		<input type="hidden" name="RETURNURL" value="<?=$returnUrl?>" />
		<input type="hidden" name="WEBPUBKEY" value="<?=$pubkey?>" />
		<input type="hidden" name="WEBSIGNATURE" value="<?=$sig?>" />
	</form>
</body>
</html>
