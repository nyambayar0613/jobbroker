<?
	///////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// �ô�����Ʈ ����� ī�� ������� ������
	//
	///////////////////////////////////////////////////////////////////////////////////////////////////
	
	require_once ("./lib/AGSMobile.php");
	
	
	$tracking_id = $_REQUEST["tracking_id"];
	$transaction = $_REQUEST["transaction"];
	$SendNo = $_REQUEST["SendNo"];
	$AdmNo = $_REQUEST["AdmNo"];
	$AdmDt = $_REQUEST["AdmDt"];
	$store_id = $_REQUEST["StoreId"];
	$Store_OrdNo = $_REQUEST["Store_OrdNo"];		// ��� ���ŷ��� Ȯ���� ���� ������ ����

	$log_path = null;	
	// log���� ������ ������ ��θ� �����մϴ�.
    // ����� ���� null�� �Ǿ����� ��� "���� �۾� ���丮�� /lib/log/"�� ����˴ϴ�.

	if ( Cancel_Check($Store_OrdNo) == True ){
    
		$agsMobile = new AGSMobile($store_id,$tracking_id,$transaction,$log_path);

		$agsMobile->setLogging(true);  //true : �αױ��, false : �αױ�Ͼ���.

		$ret = $agsMobile->cancel($AdmNo, $AdmDt, $SendNo);
		
		// ������ �Ʒ����� ó���ϼ���
		if ($ret['status'] == "ok") {
			
			echo "��üID : ".$ret["data"]["StoreId"]."<br/>";     
			echo "���ι�ȣ: ".$ret["data"]["AdmNo"]."<br/>";   
			echo "���νð�: ".$ret["data"]["AdmTime"]."<br/>";   
			echo "�ڵ�: ".$ret["data"]['Code']."<br/>";   
		
		}else {
			//��� ��� ����
			echo "���� ���� : ".$ret['message']; // ���� �޽���
		}

	}else{

			echo "���ν��� : ��� ���ŷ����� ã�� ���߽��ϴ�."; // ��ҿ�û���� ���� �������� �ƴ� ��� ó��
	}

	function Cancel_Check($Store_OrdNo) 
	{
		$flag = False;
		/***********************************************************************************
		*���⼭ ������ ���ŷ� ������ �����ɴϴ�.
		*��ҿ�û ���� ���ŷ��� ������ ���ŷ� ������ �����ϰ�
		*��Ұ� ������ �����̸� True, �ƴϸ� False
		* $Order			//ex. ���� ���ŷ�����	
		************************************************************************************/
		/*
			if ( $Store_OrdNo == $Order ){
				$flag = True;
			}else{
				$flag = False;
			}
		*/
	//	************************************************************************************/
		
		return $flag;

	}
	
?>