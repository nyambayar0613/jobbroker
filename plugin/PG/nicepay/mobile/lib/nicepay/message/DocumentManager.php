<?php
require_once dirname(__FILE__).'/ModelLoader.php';
/**
 * 
 * @author kblee
 *
 */
class DocumentManager{
	
	/** Document Map */
	private $map;
	
	

	/** Header */
	private $header = null;
	
	/**
	 * Constructor
	 */
	private function __construct(){
	}
	
	/**
	 * 
	 * @param $xmlFile
	 */
	public static function newInstance($xmlFile){
		
		$docMgr = new DocumentManager();
		try {
			$loader = new ModelLoader();
			$loader->load($xmlFile,$docMgr);
		}catch(Exception $e){
			throw $e;
		}
		return $docMgr;
	}
	
	/**
	 * getMap
	 * @return Map<String,Document>
	 */
	public function getMap(){
		return $this->map;
	}
	/**
	 * getMessage
	 * @param id
	 * @return Document
	 */
	public function getMessage($id){
		return $this->map[$id];
	}
	/**
	 * addAll
	 * @param subMap
	 */
	public function addAll($subMap){
		foreach($subMap as $key=>$value){
			$this->map[$key] = $value;
		}
		
	}
	/**
	 * getHeader
	 * @return Header
	 */
	public function getHeader(){
		return $this->header;
	}
	/**
	 * setHeader
	 * @param header
	 */
	public function setHeader($header){
		$this->header = $header;
	}
}
?>
