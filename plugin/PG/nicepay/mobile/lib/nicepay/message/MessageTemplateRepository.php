<?php
require_once dirname(__FILE__).'/DocumentManager.php';
/**
 * 
 * @author kblee
 *
 */
class MessageTemplateRepository {
	/**
	 * 
	 * @var $documentManager
	 */
	private $documentManager;
	
	/**
	 * 
	 * @var $instance
	 */
	private static $instance;
	
	/**
	 * 
	 */
	private function __construct(){
		
		$this->documentManager = DocumentManager::newInstance("nice_mall.xml");
			
	}
	
	/**
	 * 
	 */
	public static function  getInstance(){
		if(!isset(MessageTemplateRepository::$instance)){
			MessageTemplateRepository::$instance = new MessageTemplateRepository();
		}
		return MessageTemplateRepository::$instance;
	}
	
	/**
	 * 
	 * @param $id
	 */
	public function getDocumentTemplate($id){
		return $this->documentManager->getMessage($id);
	}
	
}
?>
