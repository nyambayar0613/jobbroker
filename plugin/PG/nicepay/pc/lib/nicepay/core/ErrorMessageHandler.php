<?php
/**
 * 
 * @author kblee
 *
 */
class ErrorMessageHandler{
	
	/**
	 * 
	 */
	public function __construct(){
		
	}
	
	/**
	 * 
	 * @param unknown_type $exception
	 */
	public function doHandle($exception){
		$responseDTO = new WebMessageDTO();
		
		if($exception instanceof ServiceException){
			$se = $exception;
			$errorCode = $se->getErrorCode();
			$errorMsg = $se->getErrorMessage();
			$responseDTO->setParameter(ERROR_CODE, $errorCode);
			$responseDTO->setParameter(ERROR_MSG, $errorMsg);
		}else{
			$responseDTO->setParameter(ERROR_CODE, ErrorCodes::S999);
			$responseDTO->setParameter(ERROR_MSG, ETC_ERROR_MESSAGE);
		}
		return $responseDTO;
	}
}
?>
