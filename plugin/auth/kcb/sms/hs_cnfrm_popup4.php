<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<?php
	header('Content-Type: text/html; charset=euc-kr');

	//	����Ȯ�μ��� ��� ȭ��
	/* ���� ���� �׸� */
	$memId				= $_POST["mem_id"];			// ȸ�����ڵ�
	$svcTxSeqno			= $_POST["svc_tx_seqno"];	// �ŷ���ȣ
	$rqstCausCd			= $_POST["rqst_caus_cd"];	// ������û�����ڵ� 2byte  (00:ȸ������, 01:��������, 02:ȸ����������, 03:��й�ȣã��, 04:��ǰ����, 99:��Ÿ);// 

	$resultCd			= $_POST["result_cd"];		// ����ڵ�
	$resultMsg			= $_POST["result_msg"];		// ����޼���
	$certDtTm			= $_POST["cert_dt_tm"];		// �����Ͻ�
	$di					= $_POST["di"];				// DI
	$ci					= $_POST["ci"];				// CI
	$name				= $_POST["name"];			// ����
	$birthday			= $_POST["birthday"];		// �������
	$sex				= $_POST["sex"];			// ����
	$nation				= $_POST["nation"];			// ���ܱ��α���
	$telComCd			= $_POST["tel_com_cd"];		// ��Ż��ڵ�
	$telNo				= $_POST["tel_no"];			// �޴�����ȣ
	$returnMsg			= $_POST["return_msg"];		// ���ϸ޽���
?>
<title>KCB ����Ȯ�μ��� ����</title>
</head>
<body>
<h3>Ȯ�ΰ��</h3>
<ul>
  <li>ȸ�����ڵ�	: <?=$memId?> </li>
  <li>���������ڵ�	: <?=$rqstCausCd?></li>
  <li>����ڵ�		: <?=$resultCd?></li>
  <li>����޼���	: <?=$resultMsg?></li>
  <li>�ŷ���ȣ		: <?=$svcTxSeqno?> </li>
  <li>�����Ͻ�		: <?=$certDtTm?> </li>
  <li>DI			: <?=$di?> </li>
  <li>CI			: <?=$ci?> </li>
  <li>����			: <?=$name?> </li>
  <li>�������		: <?=$birthday?> </li>
  <li>����			: <?=$sex?> </li>
  <li>���ܱ��α���	: <?=$nation?> </li>
  <li>��Ż��ڵ�	: <?=$telComCd?> </li>
  <li>�޴�����ȣ	: <?=$telNo?> </li>
  <li>���ϸ޽���	: <?=$returnMsg?> </li>
</ul>

<br/>
* ���� - 1:��, 0:��
<br/>
* ���ܱ��α��� - 1:������, 2:�ܱ���
<br/>
* ��Ż� - 01:SKT, 02:KT, 03:LGU+, 04:SKT�˶���, 05:KT�˶���, 06:LGU+�˶���
</body>
</html>
