<?php
require_once dirname(__FILE__).'/CallbackHandler.php';
/**
 * 
 * @author kblee
 *
 */
class ServiceExceptionCallbackHandler implements CallbackHandler{
	
	/**
	 * 
	 * @param  $callbacks
	 */
	public function doHandle($callbacks){
		foreach($callbacks as $key=>$callback){
			$callback->doCallback();
		}
	}
	
}
?>
