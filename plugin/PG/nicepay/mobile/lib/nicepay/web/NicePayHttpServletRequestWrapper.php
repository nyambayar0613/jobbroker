<?php

require_once dirname(__FILE__).'/WebParamsCrypto.php';

class NicePayHttpServletRequestWrapper{
	
	private $httpRequest;
	
	const PRIVATE_ENC_KEY_NAME = 'EncodeKey';
	
	const PRIVATE_ENC_TARGET_NAME = 'EncodeParameters';
	
	public function __construct($httpRequest){
		$this->httpRequest = $httpRequest;
		$this->initailizeHttpRequestParams();
	}
	
	private function initailizeHttpRequestParams(){
		$httpParamMap = array();

		$decryptTargetNames = isset($this->httpRequest[NicePayHttpServletRequestWrapper::PRIVATE_ENC_TARGET_NAME]) ? 
			$this->httpRequest[NicePayHttpServletRequestWrapper::PRIVATE_ENC_TARGET_NAME] : "";

		$decryptKeySet = array();
		if(isset($decryptTargetNames) && $decryptTargetNames!==""){
			$decryptFormNames = explode(",",$decryptTargetNames);
			foreach($decryptFormNames as $key=>$value){
				$decryptKeySet[$key] = $value;
			}
		}
		
		foreach($this->httpRequest as $key=>$value){
			if(isset($decryptKeySet) && $this->isTargetDecrypt($key,$decryptKeySet)){
				
				$privateKey = isset($this->httpRequest[NicePayHttpServletRequestWrapper::PRIVATE_ENC_KEY_NAME]) ? 
					$this->httpRequest[NicePayHttpServletRequestWrapper::PRIVATE_ENC_KEY_NAME] : "";

				$webParamCrypto = new WebParamsCrypto($privateKey);
				$this->httpRequest[$key] = $webParamCrypto->decrypt($value);
			}
			
		}
	}
	
	public function getHttpRequestMap(){
		return $this->httpRequest;
	}
	
	private function isTargetDecrypt($formName, $decryptKeySet){
		$isEncrypt = false;
		foreach($decryptKeySet as $key=>$value){
			if($formName == $value){
				$isEncrypt = true;
				break;
			}
		}
		return $isEncrypt;
	}
}

?>
