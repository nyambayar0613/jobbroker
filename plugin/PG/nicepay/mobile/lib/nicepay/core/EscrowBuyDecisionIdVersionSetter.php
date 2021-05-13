<?php
require_once dirname(__FILE__).'/MessageIdVersionSetter.php';

/**
 * 
 * @author kblee
 *
 */
class EscrowBuyDecisionIdVersionSetter implements MessageIdVersionSetter{

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
		$webMessageDTO->setParameter(ID, "FED01");
	}
}
?>