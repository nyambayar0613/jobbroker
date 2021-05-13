<?php

require_once dirname(__FILE__).'/BankWebParamGather.php';
require_once dirname(__FILE__).'/BankSSGWebParamGather.php';
require_once dirname(__FILE__).'/BuyDecisionWebParamGather.php';
require_once dirname(__FILE__).'/BuyRejectWebParamGather.php';
require_once dirname(__FILE__).'/CancelWebParamGather.php';
require_once dirname(__FILE__).'/CardWebParamGather.php';
require_once dirname(__FILE__).'/CashReceiptWebParamGather.php';
require_once dirname(__FILE__).'/CellPhoneWebParamGather.php';
require_once dirname(__FILE__).'/CpBillWebParamGather.php';
require_once dirname(__FILE__).'/DeliveryRegisterWebParamGather.php';
require_once dirname(__FILE__).'/VBankWebParamGather.php';
require_once dirname(__FILE__).'/VBankBulkWebParamGather.php';
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class WebParamGatherFactory{
	
	private static $PAY_GATHER_CLASS_MAP;
	
	private static $CANCEL_GATHER_CLASS_MAP;
	
	private static $ESCROW_GATHER_CLASS_MAP;
	
	/**
	 * Default Constructor
	 */
	public function __construct(){
		
		if(WebParamGatherFactory::$PAY_GATHER_CLASS_MAP == null){
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP = array();
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[BANK_PAY_METHOD] = "BankWebParamGather";
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[CARD_PAY_METHOD] = "CardWebParamGather";
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[VBANK_PAY_METHOD] = "VBankWebParamGather";
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[CELLPHONE_PAY_METHOD] = "CellPhoneWebParamGather";
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[CPBILL_PAY_METHOD] = "CpBillWebParamGather";
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[VBANK_BULK_PAY_METHOD] = "VBankBulkWebParamGather";
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[CASHRCPT_PAY_METHOD] = "CashReceiptWebParamGather";
			WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[BANK_SSG_PAY_METHOD] = "BankSSGWebParamGather";
		}
		
		if(WebParamGatherFactory::$CANCEL_GATHER_CLASS_MAP == null){
			WebParamGatherFactory::$CANCEL_GATHER_CLASS_MAP = array();
			WebParamGatherFactory::$CANCEL_GATHER_CLASS_MAP[CANCEL_SERVICE_CODE] ="CancelWebParamGather";
		}
		
		if(WebParamGatherFactory::$ESCROW_GATHER_CLASS_MAP == null){
			WebParamGatherFactory::$ESCROW_GATHER_CLASS_MAP = array();
			WebParamGatherFactory::$ESCROW_GATHER_CLASS_MAP[ESCROW_DELIVERY_REGISTER] = "DeliveryRegisterWebParamGather";
			WebParamGatherFactory::$ESCROW_GATHER_CLASS_MAP[ESCROW_BUY_DECISION] = "BuyDecisionWebParamGather";
			WebParamGatherFactory::$ESCROW_GATHER_CLASS_MAP[ESCROW_BUY_REJECT] = "BuyRejectWebParamGather";
		}
		
		
	}
	
	/**
	 * 
	 * @param  $payMethod
	 */
	public function createParamGather($serviceMode,$payMethod){
		$webParamGather = null;
		if(PAY_SERVICE_CODE == $serviceMode){
			$webParamGather = WebParamGatherFactory::$PAY_GATHER_CLASS_MAP[$payMethod];
		}else if(CANCEL_SERVICE_CODE == $serviceMode){
			$webParamGather = WebParamGatherFactory::$CANCEL_GATHER_CLASS_MAP[$serviceMode];
		}else if(ESCROW_SERVICE_CODE == $serviceMode){
			$webParamGather = WebParamGatherFactory::$ESCROW_GATHER_CLASS_MAP[$payMethod];
		}
		
		if($webParamGather!=null){
			$reflectionClazz = new ReflectionClass($webParamGather);
			if($reflectionClazz->implementsInterface("WebParamGather") && $reflectionClazz->isInstantiable()){
				return $reflectionClazz->newInstance();
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
	
}
?>
