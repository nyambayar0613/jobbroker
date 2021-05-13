<?php

/**
 * 
 * @author kblee
 *
 */
interface MessageIdVersionSetter{

	/**
	 * Constructor
	 */
	public function __construct();
	
	/**
	 * 
	 * @param  $webMessageDTO
	 */
	public function fillIdAndVersion($webMessageDTO);
}
?>