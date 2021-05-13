<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class CpBillWebParamGather implements WebParamGather{

	/**
	 * Default Constructor
	 */
	public function __construct(){
		
	}

	/**
	 * 
	 * @see WebParamGather::gather()
	 */
	public function gather($request){
		$webParam = new WebMessageDTO();

		$carrier = isset($request["Carrier"]) ? $request["Carrier"] : "";
		$webParam->setParameter(CARRIER,$carrier);

		$dstAddr = isset($request["DstAddr"]) ? $request["DstAddr"] : "";
		$webParam->setParameter(DST_ADDR,$dstAddr);

		$iden = isset($request["Iden"]) ? $request["Iden"] : "";
		$webParam->setParameter(IDEN,$iden);

		return $webParam;
	}
}
?>
