<?php
require_once dirname(__FILE__).'/MessageTemplateRepository.php';
/**
 * 
 * @author kblee
 *
 */
class MessageTemplateCreator {
	
	private static $PAY_REQ_MESSAGE_TEMPLATES;
	
	private static $CANCEL_REQ_MESSAGE_TEMPLATES;
	
	private static $ESCROW_REQ_MESSAGE_TEMPLATES;
	
	private static $PAY_RES_MESSAGE_TEMPLATES;
	
	private static $CANCEL_RES_MESSAGE_TEMPLATES;
	
	private static $ESCROW_RES_MESSAGE_TEMPLATES;
	
	
	/**
	 * 
	 */
	public function __construct(){
		if(MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES == null){
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES = array();
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[CARD_PAY_METHOD] = NPG01FCD01;
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[BANK_PAY_METHOD] = NPG01FBK01;
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[VBANK_PAY_METHOD] = NPG01FVK01;
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[CELLPHONE_PAY_METHOD] = NPG01FCP01;
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[CPBILL_PAY_METHOD] = NPG01FCB01;
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[VBANK_BULK_PAY_METHOD] = NPG01FVB01;
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[CASHRCPT_PAY_METHOD] = NPG01FCH01;
			MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[BANK_SSG_PAY_METHOD] = NPG01FSB01;
		}
		
		if(MessageTemplateCreator::$CANCEL_REQ_MESSAGE_TEMPLATES == null){
			MessageTemplateCreator::$CANCEL_REQ_MESSAGE_TEMPLATES = array();
			MessageTemplateCreator::$CANCEL_REQ_MESSAGE_TEMPLATES[CANCEL_SERVICE_CODE] = NPG01IPGC1;
		}
		
		if(MessageTemplateCreator::$ESCROW_REQ_MESSAGE_TEMPLATES == null){
			MessageTemplateCreator::$ESCROW_REQ_MESSAGE_TEMPLATES = array();
			MessageTemplateCreator::$ESCROW_REQ_MESSAGE_TEMPLATES[ESCROW_DELIVERY_REGISTER]=NPG01FER01;
			MessageTemplateCreator::$ESCROW_REQ_MESSAGE_TEMPLATES[ESCROW_BUY_DECISION]=NPG01FED01;
			MessageTemplateCreator::$ESCROW_REQ_MESSAGE_TEMPLATES[ESCROW_BUY_REJECT]=NPG01FEF01;
		}
		
		if(MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES == null){
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES = array();
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[CARD_PAY_METHOD] = NPG01FCD02;
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[BANK_PAY_METHOD] = NPG01FBK02;
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[VBANK_PAY_METHOD] = NPG01FVK02;
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[CELLPHONE_PAY_METHOD] = NPG01FCP02;
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[CPBILL_PAY_METHOD] = NPG01FCB02;
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[VBANK_BULK_PAY_METHOD] = NPG01FVB02;
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[CASHRCPT_PAY_METHOD] = NPG01FCH02;
			MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[BANK_SSG_PAY_METHOD] = NPG01FSB02;
		}
		
		if(MessageTemplateCreator::$CANCEL_RES_MESSAGE_TEMPLATES == null){
			MessageTemplateCreator::$CANCEL_RES_MESSAGE_TEMPLATES = array();
			MessageTemplateCreator::$CANCEL_RES_MESSAGE_TEMPLATES[CANCEL_SERVICE_CODE] = NPG01IPGC2;
		}
		
		if(MessageTemplateCreator::$ESCROW_RES_MESSAGE_TEMPLATES == null){
			MessageTemplateCreator::$ESCROW_RES_MESSAGE_TEMPLATES = array();
			MessageTemplateCreator::$ESCROW_RES_MESSAGE_TEMPLATES[ESCROW_DELIVERY_REGISTER]=NPG01FER02;
			MessageTemplateCreator::$ESCROW_RES_MESSAGE_TEMPLATES[ESCROW_BUY_DECISION]=NPG01FED02;
			MessageTemplateCreator::$ESCROW_RES_MESSAGE_TEMPLATES[ESCROW_BUY_REJECT]=NPG01FEF02;
		}
		
	}
	
	/**
	 * 
	 * @param $serviceMode
	 * @param $payMethod
	 */
	public function createRequestDocumentTemplate($serviceMode,$payMethod){
		$messageTemplateRepository = MessageTemplateRepository::getInstance();
		$messageID = "";
		if($serviceMode == PAY_SERVICE_CODE){
			$messageID = MessageTemplateCreator::$PAY_REQ_MESSAGE_TEMPLATES[$payMethod];
		}else if($serviceMode == CANCEL_SERVICE_CODE){
			$messageID = MessageTemplateCreator::$CANCEL_REQ_MESSAGE_TEMPLATES[$serviceMode];
		}else if($serviceMode == ESCROW_SERVICE_CODE){
			$messageID =  MessageTemplateCreator::$ESCROW_REQ_MESSAGE_TEMPLATES[$payMethod];
		}
		
		if($messageID != null && $messageID !=""){
			return $messageTemplateRepository->getDocumentTemplate($messageID);
		}else{
			return null;
		}
		
	}
	
	/**
	 * 
	 * @param $serviceMode
	 * @param $payMethod
	 */
	public function createResponseDocumentTemplate($serviceMode,$payMethod){
		$messageTemplateRepository = MessageTemplateRepository::getInstance();
		$messageID = "";
		if($serviceMode == PAY_SERVICE_CODE){
			$messageID = MessageTemplateCreator::$PAY_RES_MESSAGE_TEMPLATES[$payMethod];
		}else if($serviceMode == CANCEL_SERVICE_CODE){
			$messageID = MessageTemplateCreator::$CANCEL_RES_MESSAGE_TEMPLATES[$serviceMode];
		}else if($serviceMode == ESCROW_SERVICE_CODE){
			$messageID =  MessageTemplateCreator::$ESCROW_RES_MESSAGE_TEMPLATES[$payMethod];
		}
		
		if($messageID != null && $messageID !=""){
			return $messageTemplateRepository->getDocumentTemplate($messageID);
		}else{
			return null;
		}
		
	}
	
}
?>
