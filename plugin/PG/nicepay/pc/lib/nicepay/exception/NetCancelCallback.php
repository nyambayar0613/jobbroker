<?php
require_once dirname(__FILE__).'/Callback.php';
require_once dirname(__FILE__).'/../core/ErrorCodes.php';
/**
 * 
 * @author kblee
 *
 */
class NetCancelCallback implements Callback{
	
	/** The web message dto. */
	private $webMessageDTO;
	
	/** The service exception. */
	private $serviceException;
	
	/** The hash set. */
	private static $NETCANCEL_TARGET_ERROR_CODES;
	
	/**
	 * 
	 */
	public function __construct(){
		if(!isset(NetCancelCallback::$NETCANCEL_TARGET_ERROR_CODES)){
			NetCancelCallback::$NETCANCEL_TARGET_ERROR_CODES = array();
			NetCancelCallback::$NETCANCEL_TARGET_ERROR_CODES[0] = ErrorCodes::S002;
			NetCancelCallback::$NETCANCEL_TARGET_ERROR_CODES[1] = ErrorCodes::X003;
			NetCancelCallback::$NETCANCEL_TARGET_ERROR_CODES[2] = ErrorCodes::T001;
			NetCancelCallback::$NETCANCEL_TARGET_ERROR_CODES[3] = ErrorCodes::T002;
			NetCancelCallback::$NETCANCEL_TARGET_ERROR_CODES[4] = ErrorCodes::T003;
		}
	}
	
	/**
	 * Sets the web message dto.
	 * 
	 * @param webMessageDTO the new web message dto
	 */
	public function setWebMessageDTO($webMessageDTO) {
		$this->webMessageDTO = $webMessageDTO;
	}
	
	/**
	 * Sets the service exception.
	 * 
	 * @param serviceException the new service exception
	 */
	public function setServiceException($serviceException){
		$this->serviceException = $serviceException;
	}

	/**
	 * Do callback.
	 */
	public function doCallback(){
		try {
			if($this->isServiceExceptionTargetNetCancel()){ // 특정 에러코드 발생시 망취소
				if(LogMode::isAppLogable()){
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->errorAppLog("망취소 진행...[".$this->serviceException->getErrorCode()."|".$this->serviceException->getErrorMessage()."]");
				}
				
				$requestMsgDTO = new WebMessageDTO();
				// Header (이외 데이터 자동 설정)
				$requestMsgDTO->setParameter(VERSION, "NPG01");  // 버전
				$requestMsgDTO->setParameter(ID, "IPGC1");  // 전문ID
				$requestMsgDTO->setParameter(TID, $this->webMessageDTO->getParameter(TID));  // 거래아이디
				$requestMsgDTO->setParameter(ENC_FLAG, $this->webMessageDTO->getParameter(ENC_FLAG));  // 암복호화여부


				// Body
				$requestMsgDTO->setParameter(PAY_METHOD, $this->webMessageDTO->getParameter(PAY_METHOD));  // 지불수단
				$requestMsgDTO->setParameter(CANCEL_AMT, $this->webMessageDTO->getParameter(GOODS_AMT));  // 취소금액
				$requestMsgDTO->setParameter(CANCEL_MSG, "망취소");  // 취소사유
				$requestMsgDTO->setParameter(MID, $this->webMessageDTO->getParameter(MID));  // 상점ID
				$requestMsgDTO->setParameter(CANCEL_PWD, "");  // 취소패스워드
				$requestMsgDTO->setParameter(MERCHANT_KEY, $this->webMessageDTO->getParameter(MERCHANT_KEY));  // 상점KEY
				$requestMsgDTO->setParameter(CANCEL_IP, $this->webMessageDTO->getParameter(MALL_IP));  // 취소IP
				$requestMsgDTO->setParameter(NET_CANCEL_CODE, "1");  // 망취소구분


				$msgTemplateCreator = new MessageTemplateCreator();
				$cancelRequestDocument = $msgTemplateCreator->createRequestDocumentTemplate(CANCEL_SERVICE_CODE,"");
				$cancelResponseDocument = $msgTemplateCreator->createResponseDocumentTemplate(CANCEL_SERVICE_CODE,"");
				$serviceFactory = new ServiceFactory();
				
				$adaptorService =  $serviceFactory->createService(CANCEL_SERVICE_CODE);
				$adaptorService->setRequestTemplateDocument($cancelRequestDocument);
				$adaptorService->setResponseTemplateDocument($cancelResponseDocument);
				
				$ioAdaptorTransport = new IoAdaptorTransport($this->webMessageDTO->getParameter(USE_DOMAIN));
				
				$adaptorService->setTransport($ioAdaptorTransport);
				
				// 망취소 실행
				$adaptorService->service($requestMsgDTO);

				if(LogMode::isAppLogable()){
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->errorAppLog("망취소 요청");
				}

			}
			
		} catch (ServiceException $e) {
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				
				$logJournal->errorAppLog("망상 취소시 예외가 발생하였습니다. :"+$e->getMessage());
			}
		}
		
	}
	
	/**
	 * Checks if is service exception target net cancel.
	 * 
	 * @return true, if is service exception target net cancel
	 */
	private function isServiceExceptionTargetNetCancel(){
		$isServiceExceptionTarget = false;
		if(PAY_SERVICE_CODE == $this->webMessageDTO->getParameter(SERVICE_MODE)){
			$errorCode = $this->serviceException->getErrorCode();
			foreach (NetCancelCallback::$NETCANCEL_TARGET_ERROR_CODES as $key=>$value){
				if($value == $errorCode){
					$isServiceExceptionTarget = true;
					break;
				}
			}
		}
		return $isServiceExceptionTarget;
	}
	
}
?>
