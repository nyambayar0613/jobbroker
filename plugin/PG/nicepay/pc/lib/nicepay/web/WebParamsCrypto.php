<?php

require_once dirname(__FILE__).'/../../secure/Crypt/AES.php';

class WebParamsCrypto {
	
	private $merchantKey;
	
	private $aes;
	
	/**
	 * 
	 * @param String $merchantKey
	 */
	public function __construct($merchantKey){
		$this->merchantKey = $merchantKey;
		$this->aes = new Crypt_AES(CRYPT_AES_MODE_ECB);
		$this->aes->setKey($this->initialPrivateKey());
	}
	
	
	/**
	 * 
	 * @return string
	 */	
	private function initialPrivateKey(){
		
		$needKey = substr($this->merchantKey,0,32);
		$hexBytes = str_split($needKey);
		
		$length = sizeof($hexBytes) / 2;
		
		$rawBytes = array();
		
		for($i = 0 ; $i < $length ;$i++){
			$high = base_convert((string)$hexBytes[$i*2],16,10);
			$low = base_convert((string)$hexBytes[$i*2+1],16,10);
			
			if($high == 0){
				$high = ord($hexBytes[$i*2]) % 16;
			} 
			
			if($low == 0){
				$low = ord($hexBytes[$i*2+1]) % 16;
			}
			
			$value = ( ($high << 4) | $low );
			
			if($value > 127) {
				$value-=256;
			}
			$rawBytes[$i] = chr($value);
			
		} // for end
		return implode($rawBytes);
		
	}
	
	/**
	 * 
	 * @param String $encryptText
	 */
	public function decrypt($encryptText){
					 
		return $this->aes->decrypt(base64_decode($encryptText));
		
	}

}
?>
