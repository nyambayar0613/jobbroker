<?php
require_once dirname(__FILE__).'/CancelServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/CellPhoneRegItemIdVersionSetter.php';
require_once dirname(__FILE__).'/CellPhoneSelfDlverIdVersionSetter.php';
require_once dirname(__FILE__).'/CellPhoneSmsDlverIdVersionSetter.php';
require_once dirname(__FILE__).'/CellPhoneItemConfmIdVersionSetter.php';
require_once dirname(__FILE__).'/EscrowBuyDecisionIdVersionSetter.php';
require_once dirname(__FILE__).'/EscrowBuyRejectIdVersionSetter.php';
require_once dirname(__FILE__).'/EscrowDeliveryRegisterIdVersionSetter.php';
require_once dirname(__FILE__).'/PayBankServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/PayBankSSGServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/PayCardServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/PayCellPhoneServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/PayCpBillServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/PayReceiptServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/PayVbankBulkServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/PayVbankServiceIdVersionSetter.php';
require_once dirname(__FILE__).'/MessageIdVersionSetter.php';

/**
 * 
 * @author kblee
 *
 */
class MessageIdVersionFactory{
	
	private static $PAY_SERVICE_IDVER_CLZZ_MAP;
	
	private static $CANCEL_SERVICE_IDVER_CLZZ_MAP;
	
	private static $ESCROW_SERVICE_IDVER_CLZZ_MAP;

	/**
	 * 
	 */
	public function __construct(){
		
		if(MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP == null){
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP = array();
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[BANK_PAY_METHOD] = "PayBankServiceIdVersionSetter";
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[VBANK_PAY_METHOD] = "PayVbankServiceIdVersionSetter";
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[CARD_PAY_METHOD] = "PayCardServiceIdVersionSetter";
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[CELLPHONE_PAY_METHOD] = "PayCellPhoneServiceIdVersionSetter";
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[CPBILL_PAY_METHOD] = "PayCpBillServiceIdVersionSetter";
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[VBANK_BULK_PAY_METHOD] = "PayVBankBulkServiceIdVersionSetter";
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[CASHRCPT_PAY_METHOD] = "PayReceiptServiceIdVersionSetter";
			MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[BANK_SSG_PAY_METHOD] = "PayBankSSGServiceIdVersionSetter";
		}
		
		if(MessageIdVersionFactory::$CANCEL_SERVICE_IDVER_CLZZ_MAP == null){
			MessageIdVersionFactory::$CANCEL_SERVICE_IDVER_CLZZ_MAP = array();
			MessageIdVersionFactory::$CANCEL_SERVICE_IDVER_CLZZ_MAP[CANCEL_SERVICE_CODE] = "CancelServiceIdVersionSetter";
		}
		
		if(MessageIdVersionFactory::$ESCROW_SERVICE_IDVER_CLZZ_MAP == null){
			MessageIdVersionFactory::$ESCROW_SERVICE_IDVER_CLZZ_MAP = array();
			MessageIdVersionFactory::$ESCROW_SERVICE_IDVER_CLZZ_MAP[ESCROW_DELIVERY_REGISTER] = "EscrowDeliveryRegisterIdVersionSetter";
			MessageIdVersionFactory::$ESCROW_SERVICE_IDVER_CLZZ_MAP[ESCROW_BUY_DECISION] = "EscrowBuyDecisionIdVersionSetter";
			MessageIdVersionFactory::$ESCROW_SERVICE_IDVER_CLZZ_MAP[ESCROW_BUY_REJECT] = "EscrowBuyRejectIdVersionSetter";
		}
		
	}
	
	/**
	 * 
	 * @param  $serviceMode
	 * @param  $payMethod
	 */
	public function  create($serviceMode,$payMethod){
		// 서비스모드에 따른 version과 ID설정
  		$serviceIdVersionSetter = null;
		if(PAY_SERVICE_CODE == $serviceMode){
			$serviceIdVersionSetter = MessageIdVersionFactory::$PAY_SERVICE_IDVER_CLZZ_MAP[$payMethod];
		}else if(CANCEL_SERVICE_CODE == $serviceMode){
			$serviceIdVersionSetter = MessageIdVersionFactory::$CANCEL_SERVICE_IDVER_CLZZ_MAP[$serviceMode];
		}else if(ESCROW_SERVICE_CODE == $serviceMode){
			$serviceIdVersionSetter = MessageIdVersionFactory::$ESCROW_SERVICE_IDVER_CLZZ_MAP[$payMethod];
		}else{
			throw new Exception("Not Supported ServiceCode or PayMethod");
		}
		
		if($serviceIdVersionSetter!=null){
			$reflectionClass = new ReflectionClass($serviceIdVersionSetter);
			if($reflectionClass->implementsInterface("MessageIdVersionSetter") && $reflectionClass->isInstantiable()){
				return $reflectionClass->newInstance();
			}else{
				throw new Exception("Not Existed PayServiceIdVersionSetter");
			}
		}else{
			throw new Exception("Not Existed PayServiceIdVersionSetter");
		}
		/*
		else if(CELLPHONE_REG_ITEM == $serviceMode){
			return new CellPhoneRegItemIdVersionSetter();
		}else if(CELLPHONE_SELF_DLVER == $serviceMode){
			return new CellPhoneSelfDlverIdVersionSetter();
		}else if(CELLPHONE_SMS_DLVER == $serviceMode){
			return new CellPhoneSmsDlverIdVersionSetter();
		}else if(CELLPHONE_ITEM_CONFM == $serviceMode){
			return new CellPhoneItemConfmIdVersionSetter();
		}else{
			return null;
		}
		*/
		
	}
}
?>
