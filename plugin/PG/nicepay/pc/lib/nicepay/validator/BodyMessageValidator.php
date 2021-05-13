<?php

/**
 * 
 * @author kblee
 *
 */
interface BodyMessageValidator{

	/**
	 * Default constructor
	 */
	public function __construct();
	
	/**
	 * Message validator.
	 *
	 * @param WebMessageDTO $mdto
	 *
	 * @throws ServiceException the service exception
	 * 
	 * @see BodyMessageValidator::validate()
	 */
	public function validate($mdto);
}
?>