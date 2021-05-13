<?php
require_once dirname(__FILE__).'/IoAdaptorService.php';
/**
 * Service Factory Class
 * @author kblee
 *
 */
class ServiceFactory{
	
	/**
	 * create a ServiceFactory instance
	 */
	public function __construct(){
		
	}
	
	/**
	 * 
	 * @param string $serviceMode
	 * @return AbtractService 
	 */
	public function createService($serviceMode){
		$service = new IoAdaptorService();
		return $service;
	}
}
?>
