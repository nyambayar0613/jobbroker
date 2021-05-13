<?php
/**
 * 
 * @author kblee
 *
 */
class WebMessageDTO {
	
	/**
	 * 
	 * @var $messageDTO
	 */
	private $messageDTO;
	
	/**
	 * 
	 * @var $loopGroupMap
	 */
	private $loopGroupMap;
	
	/**
	 * 
	 */
	public function __construct(){
		$messageDTO = array();
		$loopGroupMap = array();
	}

	public function getWebMessageDTOMap(){
        	return $this->messageDTO;

        }

	public function getLoopGroupMap(){
		return $this->loopGroupMap;
	}
	
	/**
	 * 
	 * @param $key
	 * @param $value
	 */
	public function setParameter($key,$value){
		//$this->messageDTO[$key] = iconv("UTF-8", "EUC-KR",$value);
		$this->messageDTO[$key] = $value;

	}
	
	/**
	 * 
	 * @param $key
	 */
	public function getParameter($key){
		
		return isset($this->messageDTO[$key]) ? $this->messageDTO[$key] : "";
		//return $this->messageDTO[$key];

	}

	public function getParameterUTF($key){
		return iconv( "EUC-KR","UTF-8",$this->messageDTO[$key]);
	}
	
	/**
	 * 
	 * @param $paramSet
	 */
	
	public function add($paramSet){
		$dataMap = $paramSet->getWebMessageDTOMap();
		if(isset($dataMap)){
			foreach($dataMap as $key=>$value){
				$this->messageDTO[$key] = $value;
			}
		}
	}
	
	/**
	 * 
	 * @param $key
	 */
	public function getLoopGroup($key){
		return $this->loopGroupMap[$key];
	}
	
	/**
	 * 
	 * @param $key
	 * @param $loopGroup
	 */
	public function putLoopGroup($key,$loopGroup){
		$this->loopGroupMap[$key] = $loopGroup;
	}
	
	/**
	 * 
	 */
	public function toString(){
		$data = "";
		$data.= "======================================================\n";
		$data.= "                      PARAM SET                       \n";
		$data.= "======================================================\n";
		
		foreach($this->messageDTO as $key=>$value){
			$data = $data."[".$key."] -> [".trim($value)."]\n";
		}
		$data.= "======================================================\n";
		if(isset($loopGroupMap) && sizeof($loopGroupMap) > 0){
			$data.="                     REPEAT SET                       \n";
			$data.= "======================================================\n";
			foreach($this->loopGroupMap as $key=>$value){
				$data.= "Loop Key :".$key."\n";
				
				$loopGroup = $value;
				$loopGroupLength = sizeof($loopGroup);
				for ($i=0;$i < $loopGroupLength;$i++){
					$loopData = $loopGroup[$i];
					foreach($loopData as $key=>$value){
						$data.=$i.": [".$key."] -> [".trim($value)."]\n";
					}
				}
				$data.= "======================================================\n";
				
			}
		}
		
		return $data;
	}

}
?>
