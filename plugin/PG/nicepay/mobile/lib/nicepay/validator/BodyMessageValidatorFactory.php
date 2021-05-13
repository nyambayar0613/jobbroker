<?php
require_once dirname(__FILE__).'/BankBodyMessageValidator.php';
require_once dirname(__FILE__).'/BankSSGBodyMessageValidator.php';
require_once dirname(__FILE__).'/BuyDecisionBodyMessageValidator.php';
require_once dirname(__FILE__).'/BuyRejectBodyMessageValidator.php';
require_once dirname(__FILE__).'/CardBodyMessageValidator.php';
require_once dirname(__FILE__).'/CashReceiptBodyMessageValidator.php';
require_once dirname(__FILE__).'/CellPhoneBodyMessageValidator.php';
require_once dirname(__FILE__).'/CpBillBodyMessageValidator.php';
require_once dirname(__FILE__).'/DeliveryRegisterBodyMessageValidator.php';
require_once dirname(__FILE__).'/VBankBodyMessageValidator.php';
require_once dirname(__FILE__).'/VBankBulkBodyMessageValidator.php';
require_once dirname(__FILE__).'/BodyMessageValidator.php';

/**
 * 
 * @author kblee
 *
 */
class BodyMessageValidatorFactory{
	
	private static $BODY_MESSAGE_VALIDATOR_MAP;
	
	/**
	 * 
	 */
	public function __construct(){
		if(BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP == null){
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP = array();
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[BANK_PAY_METHOD] ="BankBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[CARD_PAY_METHOD] ="CardBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[VBANK_PAY_METHOD] ="VBankBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[CELLPHONE_PAY_METHOD] ="CellPhoneBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[VBANK_BULK_PAY_METHOD] ="VBankBulkBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[CPBILL_PAY_METHOD] ="CpBillBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[CASHRCPT_PAY_METHOD] ="CashReceiptBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[ESCROW_DELIVERY_REGISTER] ="DeliveryRegisterBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[ESCROW_BUY_DECISION] ="BuyDecisionBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[ESCROW_BUY_REJECT] ="BuyRejectBodyMessageValidator";
			BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[BANK_SSG_PAY_METHOD] ="BankSSGBodyMessageValidator";
		}	
	}
	
	/**
	 * 
	 * @param $payMethod
	 */
	public function createValidator($payMethod){
		
		$validatorClazz = null;
		
		$validatorClazz = BodyMessageValidatorFactory::$BODY_MESSAGE_VALIDATOR_MAP[$payMethod];
		
		if($validatorClazz!=null){
			$reflectClass = new ReflectionClass($validatorClazz);
			if($reflectClass->implementsInterface("BodyMessageValidator") && $reflectClass->isInstantiable()){
				$reflectClass->newInstance();
			}else{
				throw new Exception("As Creating BodyValidator, Break out Exception.. ");
			}
		}else{
			return null;
		}
		
	}
	
}
?>
