<?php
require_once dirname(__FILE__).'/WebMessageDTO.php';
require_once dirname(__FILE__).'/../log/LogMode.php';
require_once dirname(__FILE__).'/../log/NicePayLogJournal.php';
require_once dirname(__FILE__).'/../log/NicePayEventLogJournal.php';
require_once dirname(__FILE__).'/../core/MessageIdVersionFactory.php';
require_once dirname(__FILE__).'/../core/ErrorMessageHandler.php';
require_once dirname(__FILE__).'/../core/ServiceFactory.php';
require_once dirname(__FILE__).'/../core/SecureMessageProcessor.php';
require_once dirname(__FILE__).'/../core/IoAdaptorTransport.php';
require_once dirname(__FILE__).'/../validator/CommonMessageValidator.php';
require_once dirname(__FILE__).'/WebParamGatherFactory.php';
require_once dirname(__FILE__).'/PayCommonWebParamGather.php';
require_once dirname(__FILE__).'/../validator/GoodsMessageDataValidator.php';
require_once dirname(__FILE__).'/../validator/MerchantMessageDataValidator.php';
require_once dirname(__FILE__).'/../validator/BuyerMessageDataValidator.php';
require_once dirname(__FILE__).'/../validator/BodyMessageValidatorFactory.php';
require_once dirname(__FILE__).'/../validator/CellPhoneRegItemBodyValidator.php';
require_once dirname(__FILE__).'/../validator/CellPhoneSelfDeliverBodyValidator.php';
require_once dirname(__FILE__).'/../validator/CellPhoneSmsDeliverBodyValidator.php';
require_once dirname(__FILE__).'/../validator/CellPhoneItemConfirmBodyValidator.php';
require_once dirname(__FILE__).'/../validator/CancelBodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceExceptionCallbackHandler.php';
require_once dirname(__FILE__).'/../exception/NetCancelCallback.php';
require_once dirname(__FILE__).'/../exception/NetCancelCallback.php';
require_once dirname(__FILE__).'/../message/MessageTemplateCreator.php';

/**
 * 
 * @author kblee
 *
 */
class NicePayWEB{
	
	/**
	 * 
	 * @var $webMessageDTO
	 */
	private $webMessageDTO;
	
	/**
	 * 
	 */
	public function __construct(){
		$this->webMessageDTO = new WebMessageDTO();
	}
	
	/**
	 * 
	 * @param $request
	 */
	public function doService($request){
	
		try {			
			// IP 설정 시에 domain look up 사용 여부 확인
			// 0: DISABLE, 1: ENABLE
			$useDomainEnable = $this->webMessageDTO->getParameter(USE_DOMAIN);
			
			// APP로그 사용 여부 확인 후 초기화
			$appLogEnable = $this->webMessageDTO->getParameter(APP_LOG);
			if("1" == $appLogEnable){
				LogMode::enableAppLogMode();
			}
			
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
                $directoryPath = $this->webMessageDTO->getParameter(NICEPAY_LOG_HOME);
				$logJournal->setLogDirectoryPath($directoryPath);
				$logJournal->configureNicePayLog4PHP();
			}
			
			// 로그 사용 여부 확인
			$eventLogEnable = $this->webMessageDTO->getParameter(EVENT_LOG);
			
			if("1" == $eventLogEnable){
				LogMode::enableEventLogMode();
			}
				
			if(LogMode::isEventLogable()){
				$eventLogJournal = NicePayEventLogJournal::getInstance();
				$directoryPath = $this->webMessageDTO->getParameter(NICEPAY_LOG_HOME);
				$eventLogJournal->setLogDirectoryPath($directoryPath);
				$eventLogJournal->configureNicePayLog4PHP();
			}
			
			$serviceMode  = $this->webMessageDTO->getParameter(SERVICE_MODE);
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("service mode : ".$serviceMode);
			}
			
			// 서비스모드에 따른 version과 ID설정
			$messageIdVersionFactory = new MessageIdVersionFactory();
			$messageIdVersionSetter = $messageIdVersionFactory->create($serviceMode,$this->webMessageDTO->getParameter(PAY_METHOD));
			$messageIdVersionSetter->fillIdAndVersion($this->webMessageDTO);
			
			// 전문 공통부 유효성 체크
			$parameterSetValidator = new CommonMessageValidator();
			$parameterSetValidator->validate($this->webMessageDTO);
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("common message validation success");
			}
			
			//공통 Gather
			$commonWebGather = new PayCommonWebParamGather();
			$commonWebGather->charset =  $this->webMessageDTO->getParameter(CHARSET);

	   	    $commonGatherParam = $commonWebGather->gather($request);
			$this->webMessageDTO->add($commonGatherParam);
			
			// 서비스별로 http request value gather
			$webParamGatherFactory = new WebParamGatherFactory();
			$webParamGather = $webParamGatherFactory->createParamGather($serviceMode,$this->webMessageDTO->getParameter(PAY_METHOD));
			if($webParamGather!=null){
				$gatherParam = $webParamGather->gather($request);
				$this->webMessageDTO->add($gatherParam);
			}
			// 유효성 체크
			$this->paramValidateByValidate($serviceMode);
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("parameter validation success");
			}
			
			$testFlag = $this->webMessageDTO->getParameter("testFlag");
			$requestPgIp = $this->webMessageDTO->getParameter("requestPgIp");
			$requestPgPort = $this->webMessageDTO->getParameter("requestPgPort");
			
			/*if ($testFlag == "TEST") {
				if(LogMode::isAppLogable()){
					$logJournal->writeAppLog("TX mode is TEST!!!!");
				}
			}*/
			
			// 서비스 생성
			$ioAdaptorService = $this->createIoAdaptorService($serviceMode,$this->webMessageDTO->getParameter(PAY_METHOD)
																				, $useDomainEnable, $testFlag, $requestPgIp, $requestPgPort);
			
			// 서비스 실행 
			$responseWebMDTO = $ioAdaptorService->service($this->webMessageDTO);
						
			$responseWebMDTO->setParameter(SERVICE_MODE, $serviceMode);

			if(LogMode::isEventLogable()){
				$eventLogJournal = NicePayEventLogJournal::getInstance();
				$eventLogJournal->writeEventLog($this->webMessageDTO, $responseWebMDTO);
			}
			if(LogMode::isAppLogable()){
				$logJournal->closeAppLog("");
			}
			
			return $responseWebMDTO;
			
			
		}catch(ServiceException $e){
			echo $e->getErrorMessage();
			// ServiceException 발생시 특정 예외코드별로 망취소 처리한다.
			$callbackHandler = new ServiceExceptionCallbackHandler();
			$netCancelCallback = new NetCancelCallback();
			$netCancelCallback->setWebMessageDTO($this->webMessageDTO);
			$netCancelCallback->setServiceException($e);
			$callbackHandler->doHandle(array($netCancelCallback));
			$errorHandler = new ErrorMessageHandler();
			// 에러코드, 에러메시지를 리턴한다.
			return $errorHandler->doHandle($e);
		}catch(Exception $e){
				echo $e->getMessage();
				// 에러코드, 에러메시지를 리턴한다.
				$errorHandler = new ErrorMessageHandler();
				// 에러코드, 에러메시지를 리턴한다.
				return $errorHandler->doHandle($e);
		}
			
	}

	/**
	 * 
	 * @param $serviceMode
	 */
	private function paramValidateByValidate($serviceMode){
		// 결제서비스일 경우 상품정보,상점정보  유효성 체크
		if(PAY_SERVICE_CODE == $serviceMode){
							
			if("CASHRCPT" != $this->webMessageDTO->getParameter(PAY_METHOD)){
				$goodsValidator = new GoodsMessageDataValidator();
				$goodsValidator->validate($this->webMessageDTO);
				
				$merchantValidator = new MerchantMessageDataValidator();
				$merchantValidator->validate($this->webMessageDTO);
				
				$buyerValidator = new BuyerMessageDataValidator();
				$buyerValidator->validate($this->webMessageDTO);
			}
							
			$bodyValidatorFactory = new BodyMessageValidatorFactory();
			$bodyValidator = $bodyValidatorFactory->createValidator($this->webMessageDTO->getParameter(PAY_METHOD));
			
			if($bodyValidator!=null){
				$bodyValidator->validate($this->webMessageDTO);
			}
			
		}else if(CANCEL_SERVICE_CODE == $serviceMode){
			$cancelValidator = new CancelBodyMessageValidator();
			$cancelValidator->validate($this->webMessageDTO);
		}else if(ESCROW_SERVICE_CODE == $serviceMode){
			$bodyValidatorFactory = new BodyMessageValidatorFactory();
			$bodyValidator = $bodyValidatorFactory->createValidator($this->webMessageDTO->getParameter(PAY_METHOD));
			
			if($bodyValidator!=null){
				$bodyValidator->validate($this->webMessageDTO);
			}
		}
		
		/*
		else if(CELLPHONE_REG_ITEM == $serviceMode){
			$cellphoneRegItemValidator = new CellPhoneRegItemBodyValidator();
			$cellphoneRegItemValidator->validate($this->webMessageDTO);
		}else if(CELLPHONE_SELF_DLVER == $serviceMode){
			$cellphoneSelfDeliverValidator = new CellPhoneSelfDeliverBodyValidator();
			$cellphoneSelfDeliverValidator->validate($this->webMessageDTO);
		}else if(CELLPHONE_SMS_DLVER == $serviceMode){
			$cellphoneSmsDeliverValidator = new CellPhoneSmsDeliverBodyValidator();
			$cellphoneSmsDeliverValidator->validate($this->webMessageDTO);
		}else if(CELLPHONE_ITEM_CONFM == $serviceMode){
			$cellphoneItemConfirmValidator = new CellPhoneItemConfirmBodyValidator();
			$cellphoneItemConfirmValidator->validate($this->webMessageDTO);
		}
		*/
	}



	/**
	 * Creates the io adaptor service.
	 * 
	 * @param serviceMode the service mode
	 * 
	 * @return the io adaptor service
	 * 
	 * @throws ServiceException the service exception
	 */
	private function createIoAdaptorService($serviceMode,$payMethod, $useDomainEnable, $testFlag, $requestPgIp, $requestPgPort){
		// 전문 템플릿 생성
		$msgTemplateCreator = new MessageTemplateCreator();
		
		$requestTemplateDocument = $msgTemplateCreator->createRequestDocumentTemplate($serviceMode,$payMethod);
		$responseTemplateDocument = $msgTemplateCreator->createResponseDocumentTemplate($serviceMode,$payMethod);
		
		// 서비스클래스 생성
		$serviceFactory = new ServiceFactory();
		$ioAdaptorService  = $serviceFactory->createService($serviceMode);
		$ioAdaptorService->setRequestTemplateDocument($requestTemplateDocument);
		$ioAdaptorService->setResponseTemplateDocument($responseTemplateDocument);
		
		
		// 결제승인일 경우 암호화 데이터 처리 등록
		if(PAY_SERVICE_CODE == $serviceMode){
			$ioAdaptorService->registerSecureMessageProcessor(new SecureMessageProcessor());
		}
			
		// socket 통신 클래스 생성
		$ioAdaptorTransport = new IoAdaptorTransport($useDomainEnable);
		if ($testFlag != "") {
			// test 플레그를 통한 설정 - 테스트 서버 접속
			$ioAdaptorTransport->setTestFlag($testFlag);
		}
		if ($requestPgIp != "" && $requestPgPort != "") {
			// IP 포트 직접 설정
			$ioAdaptorTransport->setPgIp($requestPgIp, $requestPgPort);
		}
		$ioAdaptorService->setTransport($ioAdaptorTransport);
		return $ioAdaptorService;
	}
	
	/**
	 * Sets the param.
	 * 
	 * @param key the key
	 * @param value the value
	 */
	public function setParam($key, $value){
		$this->webMessageDTO->setParameter($key, $value);
	}
	
	/**
	 * Gets the param.
	 * 
	 * @param key the key
	 * 
	 * @return the param
	 */
	public function getParam($key){
		return $this->webMessageDTO->getParameter($key);
	}
	
	/**
	 * Sets the secure target params.
	 * 
	 * @param targetParams the target params
	 */
	public function setSecureTargetParams($targetParams){
		$this->webMessageDTO->setParameter(SECURE_PARAMS, $targetParams);
	}
	
}
?>
