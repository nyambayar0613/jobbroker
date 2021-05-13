<?php
require_once dirname(__FILE__).'/ErrorCodes.php';
/**
 * 
 * @author kblee
 *
 */
class ErrorMessagesMap {
	
	/**
	 * 
	 * @var $errorMap
	 */
	private static  $errorMap = array();
	
	/**
	 * 
	 */
	public function __construct(){
		$errorMap[ErrorCodes::S999] = "��Ÿ������ �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::S001] = "��û���ø��� �������� �ʽ��ϴ�.";
		$errorMap[ErrorCodes::S002] = "�������ø��� �������� �ʽ��ϴ�.";
		$errorMap[ErrorCodes::T001] = "���Ÿ޽��� ���ڵ� �� ���ܰ� �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::T002] = "���������� ���� �����Դϴ�.";
		$errorMap[ErrorCodes::T003] = "���ŵ����� �Ľ� �� ���ܰ� �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::T004] = "��û ������ ����� ���� �� ������ �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::T005] = "��û ������ �ٵ�� ���� �� ������ �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::T006] = "�۽Ÿ޽��� ���ڵ� �� ���ܰ� �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::X001] = "���� �����θ��� �߸� �����Ǿ����ϴ�.";
		$errorMap[ErrorCodes::X002] = "������ ���� ���� �� ������ �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::X003] = "���� ���� �� ������ �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::X004]= "���� �۽� �� ������ �߻��Ͽ����ϴ�.";
		$errorMap[ErrorCodes::V005]= "�������� �ʴ� ���Ҽ����Դϴ�.";
		$errorMap[ErrorCodes::V101]= "��ȣȭ �÷��� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V102]= "���񽺸�带 �������� �ʾҽ��ϴ�.";
		$errorMap[ErrorCodes::V103]= "���Ҽ����� �������� �ʾҽ��ϴ�.";
		$errorMap[ErrorCodes::V104]= "��ǰ���� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V201]= "����ID �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V202]= "LicenseKey �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V203]= "��ȭ���� �̼��� �����Դϴ�.";
		//$errorMap[ErrorCodes::V204]= "MID �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V205]= "MallIP �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V301]= "�������̸� �̼��� �����Դϴ�.";
		//$errorMap[ErrorCodes::V302]= "������������ȣ �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V303]= "�����ڿ���ó �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V304]= "�����ڸ����ּ� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V401]= "��ǰ�� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V402]= "��ǰ�ݾ� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V501]= "ī������ �̼��� �����Դϴ�.";
		//$errorMap[ErrorCodes::V502]= "ī�屸�� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V503]= "ī���ڵ� �̼��� �����Դϴ�.";
		//$errorMap[ErrorCodes::V504]= "ī���ȣ �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V505]= "ī�幫���ڿ��� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V506]= "ī���������� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V507]= "ī������ ���� �����Դϴ�.";
		$errorMap[ErrorCodes::V508]= "ī������ ������� �ʴ� ���� �����Ͽ����ϴ�.";
		//$errorMap[ErrorCodes::V509]= "ī�屸�� ������� �ʴ� ���� �����Ͽ����ϴ�.";
		$errorMap[ErrorCodes::V510]= "��ȿ�Ⱓ �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V511]= "��ȿ�Ⱓ ������� �ʴ� ���� �����Ͽ����ϴ�.";
		$errorMap[ErrorCodes::V512]= "��ȿ�Ⱓ�� �� ���°� �߸� �����Ǿ����ϴ�.";
		$errorMap[ErrorCodes::V513]= "ī�� ��й�ȣ ���Է� �����Դϴ�.";
		//$errorMap[ErrorCodes::V601]= "�����ڵ� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V602]= "���������� ��ȣȭ ������ �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V701]= "��������Աݸ����� �̼��� �����Դϴ�.";
	
	        $errorMap[ErrorCodes::VA01]= "�ŷ�KEY �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA02]= "����籸�� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA03]= "SMS���ι�ȣ �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA04]= "��üTID �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA05]= "�޴�����ȣ �̼��� �����Դϴ�.";
		//$errorMap[ErrorCodes::VA06]= "MID �̼��� �����Դϴ�.";
		//$errorMap[ErrorCodes::VA07]= "��ǰ�� �̼��� �����Դϴ�.";
		//$errorMap[ErrorCodes::VA08]= "��ǰ���� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA09]= "��������ȣ(�ֹι�ȣ]=����ڹ�ȣ) �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA10]= "ENCODE ��üTID �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA11]= "��ǰ�����ڵ� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA12]= "���PhoneID �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VA13]= "���RecKey �̼��� �����Դϴ�.";
		
		$errorMap[ErrorCodes::VB02]= "����籸�� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VB05]= "�޴�����ȣ �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VB09]= "��������ȣ(�ֹι�ȣ,����ڹ�ȣ) �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VB10] = "�� IP �̼��� �����Դϴ�.";
		
		$errorMap[ErrorCodes::VC01] = "�ŷ�TID �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VC02] = "������ȣ �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VC03] = "����ڸ� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VC04] = "MID �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::VC05] = "��������ȣ ���Է� �����Դϴ�.";
		
	    $errorMap[ErrorCodes::V801]= "��ұݾ� �̼��� �����Դϴ�.";
		$errorMap[ErrorCodes::V802]= "��һ��� �̼��� �����Դϴ�.";
		//$errorMap[ErrorCodes::V803]= "����н����� �̼��� �����Դϴ�.";
		
	}
	
/**
	 * 
	 * @param errorCode
	 * @return
	 */
	public static function containsErrorCode($errorCode){
		$isContainErrorCode = false;
                $map = ErrorMessagesMap::$errorMap;
		foreach($map as $key=>$value){
			if($key == $errorCode){
				$isContainErrorCode = true;
				break;
			}
		}
		return $isContainErrorCode;
	}
	
	/**
	 * 
	 * @param errorCode
	 * @return
	 */
	public static function getErrorMessage($errorCode){
		if(ErrorMessagesMap::containsErrorCode($errorCode)){
                        $map = ErrorMessagesMap::$errorMap;
			return $map[$errorCode];
		}else{
			return ETC_ERROR_MESSAGE;
		}
	}
	
}

?>
