<?php
require_once dirname(__FILE__).'/MessageIdVersionSetter.php';

/**
 * 
 * @author kblee
 *
 */
class PayCpBillServiceIdVersionSetter implements MessageIdVersionSetter{

	/**
	 * Default constructor
	 */
	public function __construct(){
	
	}
	
	/**
	 * 
	 * @see MessageIdVersionSetter::fillIdAndVersion()
	 */
 	public function fillIdAndVersion($webMessageDTO) {
		$webMessageDTO->setParameter(VERSION, "NPG01");
		$webMessageDTO->setParameter(ID, "FCB01");
	}
}
?>