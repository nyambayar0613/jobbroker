<?php

    //**************************************************************************************************************
    //NICE������ Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
    
    //���񽺸� :  üũ�÷��� - �Ƚɺ������� ����
    //�������� :  üũ�÷��� - ��� ������
    
    //������ ���� �����ص帮�� ������������ ���� ���� �� �������� ������ �ֽñ� �ٶ��ϴ�. 
    //**************************************************************************************************************
    
    /*****************************
	//����ġ���� ��� �ε尡 ���� �ʾ������ �������� ����� �ε��մϴ�.
	
		if(!extension_loaded('CPClient')) {
			dl('CPClient.' . PHP_SHLIB_SUFFIX);
		}
		$module = 'CPClient';
	*****************************/

    $sitecode = "";						// NICE�κ��� �ο����� ����Ʈ �ڵ�
    $sitepasswd = "";					// NICE�κ��� �ο����� ����Ʈ �н�����

		
    $enc_data = $_POST["EncodeData"];	// ��ȣȭ�� ��� ����Ÿ
 
	//////////////////////////////////////////////// ���ڿ� ����///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ� : ".$match[0]; exit;} // ���ڿ� ���� �߰�. 
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
   
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		
    if ($enc_data != "") {

				//if (extension_loaded($module)) {// �������� ��� �ε� �������
					$plaindata = get_decode_data($sitecode, $sitepasswd, $enc_data);// ��ȣȭ�� ��� �������� ��ȣȭ
				//} else {
				//	$plaindata = "Module get_response_data is not compiled into PHP";
				//}
        echo "[plaindata] " . $plaindata . "<br>";

        if ($plaindata == -1){
            $returnMsg  = "��/��ȣȭ �ý��� ����";
        }else if ($plaindata == -4){
            $returnMsg  = "��ȣȭ ó�� ����";
        }else if ($plaindata == -5){
            $returnMsg  = "HASH�� ����ġ - ��ȣȭ �����ʹ� ���ϵ�";
        }else if ($plaindata == -6){
            $returnMsg  = "��ȣȭ ������ ����";
        }else if ($plaindata == -9){
            $returnMsg  = "�Է°� ����";
        }else if ($plaindata == -12){
            $returnMsg  = "����Ʈ ��й�ȣ ����";
        }else{
            // ��ȣȭ�� �������� ��� �����͸� �Ľ��մϴ�.
            
            $requestnumber = GetValue($plaindata , "REQ_SEQ");
            $errcode = GetValue($plaindata , "ERR_CODE");
            $authtype = GetValue($plaindata , "AUTH_TYPE");
        }
    }
?>

<?
    function GetValue($str , $name)
    {
        $pos1 = 0;  //length�� ���� ��ġ
        $pos2 = 0;  //:�� ��ġ

        while( $pos1 <= strlen($str) )
        {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;
            if( $key == $name )
            {
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            }
            else
            {
                // �ٸ��� ��ŵ�Ѵ�.
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }            
        }
    }
?>

<html>
<head>
    <title>NICE������ - CheckPlus �Ƚɺ������� �׽�Ʈ</title>
</head>
<body>
    <center>
    <p><p><p><p>
    ���������� �����Ͽ����ϴ�.<br>
    <table width=500 border=1>
        <tr>
            <td>��û ��ȣ</td>
            <td><?= $requestnumber ?></td>
        </tr>            
        <tr>
            <td>�������� ���� �ڵ�</td>
            <td><?= $errcode ?></td>
        </tr>            
        <tr>
            <td>��������</td>
            <td><?= $authtype ?></td>
        </tr>
    </table>
    </center>
</body>
</html>