<?php

require_once dirname(__FILE__).'/../../secure/Crypt/TripleDES.php';

/**
 * 
 * @author kblee
 *
 */
class BlockEncrypt{
	
	/**
	 * singleton instance.
	 */
	private static $instance;
	
	/**
	 * encrypt/decrypt key
	 */
	private $keyData;
	
	/**
	 * Create a single BlockEncrypt class.
	 */
	private function __construct(){
		$this->initailizePrivateKey();
	}
	
	/**
	 * Configure encrypt key from key file.
	 */
	private function initailizePrivateKey(){
		$filePath = dirname(__FILE__).'/nicepay.key';
		
		$fp = fopen($filePath,'r');
		
		$this->keyData = fread($fp,24);
		fclose($fp);	
	}
	
	/**
	 * Get a BlockEncrypt instance.
	 */
	public static function getInstance(){
		if(!isset(BlockEncrypt::$instance)){
			BlockEncrypt::$instance = new BlockEncrypt();
		}
		return BlockEncrypt::$instance;
	} 
	
	/**
	 * encrypt plainText with configured key.  
	 */
	public function encrypt($plainText){
		$aes = new Crypt_TripleDES(CRYPT_DES_MODE_ECB);	
		$aes->setKey($this->keyData);
		
		return $aes->encrypt($plainText);
	}
	
	/**
	 * decrypt cipherText with configured key.
	 */
	public function decrypt($cipher){
		$aes = new Crypt_AES(CRYPT_AES_MODE_ECB);
		$aes->setKey($this->keyData);

		return $aes->decrypt($cipher);
	}

}

?>
