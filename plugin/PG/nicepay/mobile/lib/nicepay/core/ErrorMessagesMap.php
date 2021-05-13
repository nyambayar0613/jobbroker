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
		$errorMap[ErrorCodes::S999] = "기타오류가 발생하였습니다.";
		$errorMap[ErrorCodes::S001] = "요청템플릿이 존재하지 않습니다.";
		$errorMap[ErrorCodes::S002] = "응답템플릿이 존재하지 않습니다.";
		$errorMap[ErrorCodes::T001] = "수신메시지 인코딩 중 예외가 발생하였습니다.";
		$errorMap[ErrorCodes::T002] = "비정상적인 수신 전문입니다.";
		$errorMap[ErrorCodes::T003] = "수신데이터 파싱 중 예외가 발생하였습니다.";
		$errorMap[ErrorCodes::T004] = "요청 전문의 헤더부 생성 중 오류가 발생하였습니다.";
		$errorMap[ErrorCodes::T005] = "요청 전문의 바디부 생성 중 오류가 발생하였습니다.";
		$errorMap[ErrorCodes::T006] = "송신메시지 인코딩 중 예외가 발생하였습니다.";
		$errorMap[ErrorCodes::X001] = "서버 도메인명이 잘못 설정되었습니다.";
		$errorMap[ErrorCodes::X002] = "서버로 소켓 연결 중 오류가 발생하였습니다.";
		$errorMap[ErrorCodes::X003] = "전문 수신 중 오류가 발생하였습니다.";
		$errorMap[ErrorCodes::X004]= "전문 송신 중 오류가 발생하였습니다.";
		$errorMap[ErrorCodes::V005]= "지원하지 않는 지불수단입니다.";
		$errorMap[ErrorCodes::V101]= "암호화 플래그 미설정 오류입니다.";
		$errorMap[ErrorCodes::V102]= "서비스모드를 설정하지 않았습니다.";
		$errorMap[ErrorCodes::V103]= "지불수단을 설정하지 않았습니다.";
		$errorMap[ErrorCodes::V104]= "상품개수 미설정 오류입니다.";
		$errorMap[ErrorCodes::V201]= "상점ID 미설정 오류입니다.";
		$errorMap[ErrorCodes::V202]= "LicenseKey 미설정 오류입니다.";
		$errorMap[ErrorCodes::V203]= "통화구분 미설정 오류입니다.";
		//$errorMap[ErrorCodes::V204]= "MID 미설정 오류입니다.";
		$errorMap[ErrorCodes::V205]= "MallIP 미설정 오류입니다.";
		$errorMap[ErrorCodes::V301]= "구매자이름 미설정 오류입니다.";
		//$errorMap[ErrorCodes::V302]= "구매자인증번호 미설정 오류입니다.";
		$errorMap[ErrorCodes::V303]= "구매자연락처 미설정 오류입니다.";
		$errorMap[ErrorCodes::V304]= "구매자메일주소 미설정 오류입니다.";
		$errorMap[ErrorCodes::V401]= "상품명 미설정 오류입니다.";
		$errorMap[ErrorCodes::V402]= "상품금액 미설정 오류입니다.";
		$errorMap[ErrorCodes::V501]= "카드형태 미설정 오류입니다.";
		//$errorMap[ErrorCodes::V502]= "카드구분 미설정 오류입니다.";
		$errorMap[ErrorCodes::V503]= "카드코드 미설정 오류입니다.";
		//$errorMap[ErrorCodes::V504]= "카드번호 미설정 오류입니다.";
		$errorMap[ErrorCodes::V505]= "카드무이자여부 미설정 오류입니다.";
		$errorMap[ErrorCodes::V506]= "카드인증구분 미설정 오류입니다.";
		$errorMap[ErrorCodes::V507]= "카드형태 설정 오류입니다.";
		$errorMap[ErrorCodes::V508]= "카드형태 허용하지 않는 값을 설정하였습니다.";
		//$errorMap[ErrorCodes::V509]= "카드구분 허용하지 않는 값을 설정하였습니다.";
		$errorMap[ErrorCodes::V510]= "유효기간 미설정 오류입니다.";
		$errorMap[ErrorCodes::V511]= "유효기간 허용하지 않는 값을 설정하였습니다.";
		$errorMap[ErrorCodes::V512]= "유효기간의 월 형태가 잘못 설정되었습니다.";
		$errorMap[ErrorCodes::V513]= "카드 비밀번호 미입력 오류입니다.";
		//$errorMap[ErrorCodes::V601]= "은행코드 미설정 오류입니다.";
		$errorMap[ErrorCodes::V602]= "금융결제원 암호화 데이터 미설정 오류입니다.";
		$errorMap[ErrorCodes::V701]= "가상계좌입금만료일 미설정 오류입니다.";
	
	        $errorMap[ErrorCodes::VA01]= "거래KEY 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA02]= "이통사구분 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA03]= "SMS승인번호 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA04]= "업체TID 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA05]= "휴대폰번호 미설정 오류입니다.";
		//$errorMap[ErrorCodes::VA06]= "MID 미설정 오류입니다.";
		//$errorMap[ErrorCodes::VA07]= "상품명 미설정 오류입니다.";
		//$errorMap[ErrorCodes::VA08]= "상품가격 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA09]= "고객고유번호(주민번호]=사업자번호) 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA10]= "ENCODE 업체TID 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA11]= "상품구분코드 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA12]= "모빌PhoneID 미설정 오류입니다.";
		$errorMap[ErrorCodes::VA13]= "모빌RecKey 미설정 오류입니다.";
		
		$errorMap[ErrorCodes::VB02]= "이통사구분 미설정 오류입니다.";
		$errorMap[ErrorCodes::VB05]= "휴대폰번호 미설정 오류입니다.";
		$errorMap[ErrorCodes::VB09]= "고객고유번호(주민번호,사업자번호) 미설정 오류입니다.";
		$errorMap[ErrorCodes::VB10] = "고객 IP 미설정 오류입니다.";
		
		$errorMap[ErrorCodes::VC01] = "거래TID 미설정 오류입니다.";
		$errorMap[ErrorCodes::VC02] = "운송장번호 미설정 오류입니다.";
		$errorMap[ErrorCodes::VC03] = "등록자명 미설정 오류입니다.";
		$errorMap[ErrorCodes::VC04] = "MID 미설정 오류입니다.";
		$errorMap[ErrorCodes::VC05] = "고객고유번호 미입력 오류입니다.";
		
	    $errorMap[ErrorCodes::V801]= "취소금액 미설정 오류입니다.";
		$errorMap[ErrorCodes::V802]= "취소사유 미설정 오류입니다.";
		//$errorMap[ErrorCodes::V803]= "취소패스워드 미설정 오류입니다.";
		
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
