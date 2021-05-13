<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class BuyDecisionWebParamGather implements WebParamGather  {

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
		return $webParam;
	}
}
?>