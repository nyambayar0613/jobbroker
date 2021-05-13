<?php
require_once dirname(__FILE__).'/Header.php';
require_once dirname(__FILE__).'/Column.php';
require_once dirname(__FILE__).'/Document.php';
require_once dirname(__FILE__).'/DynamicColumn.php';
/**
 * 
 * @author kblee
 *
 */
class ModelLoader{
	
	/**
	 * 
	 */
	public function __construct(){
		
	}
	
	/**
	 * 
	 * @param $xmlFile
	 * @param $documentMgr
	 */
	public function load($xmlFile,$documentMgr){
		$xmlFile = dirname(__FILE__)."/".$xmlFile;
		$map = array();
		$header = null;
		$doc = new DOMDocument();
		
		if($doc->load($xmlFile)){
			$nodeList = $doc->getElementsByTagName("header");
			$headerNode = $nodeList->item(0);
			
			if($headerNode->hasChildNodes()){
				$childNodeList = $headerNode->childNodes;
				$header = new Header();
				foreach($childNodeList as $node){
					switch($node->nodeType){
						case XML_ELEMENT_NODE:
							$header->add($this->readColumn($node,new Column()));
							break;
					}
				}
				$header->setup();
				$documentMgr->setHeader($header);
				
			} // header child exists
			
			$messageNodeList = $doc->getElementsByTagName("message");
			foreach($messageNodeList as $messageNode){
				switch($messageNode->nodeType){
					case XML_ELEMENT_NODE:
						$document = $this->readMessage($messageNode);
						$document->setHeader($header);
						$map[$document->getVersion().$document->getId()] = $document;
						break;
				}
			}
			
			foreach($map as $key=>$value){
				$document = $map[$key];
				$prefixId = $document->getPrefixId();
				if($prefixId != null && $prefixId !=""){
					$targetMessage = $map[$prefixId];
					if($targetMessage != null){
						$document->appendPrefix($targetMessage);
					}else{
						echo "Not Found Prefix "+prefixId;
					}
				}
			}

			$documentMgr->addAll($map);
			
		}else{
			// error
			echo "전문 파일 로딩 실패";
		}
	}
	
	/**
	 * 
	 * @param $node
	 * @param $column
	 * @return Column
	 */
	private function readColumn($node,$column){
		$name = $node->getAttribute("name");
		$description = $node->getAttribute("description");
		$size = $node->getAttribute("size");
		$encrypt = $node->getAttribute("encrypt");
		$required = $node->getAttribute("required");
		$mode = $node->getAttribute("mode");

		$column->setName($name);
		$column->setDescription($description);
		$column->setSize((int)$size);
		$column->setEncrypt("Y" == $encrypt);
		$column->setRequired("Y" == $required);

		if($mode == "A"){
			$column->setMode(Column::MODE_A);
		}else if($mode == "N"){
			$column->setMode(Column::MODE_N);
		}else if($mode == "AN"){
			$column->setMode(Column::MODE_AN);
		}else if($mode = "AH"){
			$column->setMode(Column::MODE_AH);
		}

		return $column;
	}
	
	/**
	 * 
	 * @param $messageNode
	 * @return 
	 */
	private function readMessage($messageNode){
		$id = $messageNode->getAttribute("id");
		$version = $messageNode->getAttribute("version");
		$description = $messageNode->getAttribute("description");
		$prefixId = $messageNode->getAttribute("prefix");

		$document = new Document();
		$document->setId($id);
		$document->setVersion($version);
		$document->setDescription($description);
		$document->setPrefixId($prefixId);
		
		$messageNodechildNodeList = $messageNode->childNodes;
		
		foreach($messageNodechildNodeList as $messageChildNode){
			switch($messageChildNode->nodeType){
				case XML_ELEMENT_NODE:
					if("loop" == $messageChildNode->nodeName){
						$document->add($this->readMessageLoop($messageChildNode));
					}else if("dynamic" == $messageChildNode->nodeName){
						$document->add($this->readMessageDynamic($messageChildNode));
					}else{
						$document->add($this->readMessageColumn($messageChildNode));
					}
					break;
			}
		}
		
		return $document;
		
	}
	
	/**
	 * 
	 * @param $columnNode
	 */
	private function readMessageLoop($columnNode){
		$column = $this->readColumn($columnNode,new Loop());
		
		$loopList = $column->childNodes;
		
		foreach($loopList as $loopInnerNode){
			switch($loopInnerNode->nodeType){
				case XML_ELEMENT_NODE:
					if("dyanamic" == $loopInnerNode->nodeName){
						$column->add($this->readMessageDynamic($loopInnerNode));
					}else{
						$column->add($this->readMessageColumn($loopInnerNode));
					}
					
					break;
			}
		}
		
		return $column;
	}
	
	/**
	 * 
	 * @param $columnNode
	 */
	private function readMessageDynamic($columnNode){
		$dcolumn = null;
		$dynamicChildNodes = $columnNode->childNodes;
		foreach($dynamicChildNodes as $childNode){
			switch($childNode->nodeType){
				case XML_ELEMENT_NODE:
					if("column" == $childNode->nodeName){
						$valueColumn = $this->readColumn($childNode,new Column());
						$dcolumn = $this->readColumn($columnNode,new DynamicColumn($valueColumn));
					}
					
					break;
			 }
		}
		
		return $dcolumn;
	}
	
	/**
	 * 
	 * @param unknown_type $columnNode
	 */
	private function readMessageColumn($columnNode){
		$column = $this->readColumn($columnNode,new Column());
		return $column;
	}
	
}

?>
