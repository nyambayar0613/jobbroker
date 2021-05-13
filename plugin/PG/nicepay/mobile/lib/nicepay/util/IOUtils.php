<?php
/**
 * 
 * @author kblee
 *
 */
abstract class IOUtils{
	
	/**
	 * 
	 * @param  $buffer
	 * @param  $column
	 * @param  $mdto
	 */
	public static function writeToStream($buffer, $column, $mdto){
		if($column instanceof Loop){
			$buffer = IOUtils::writeLoopColumn($buffer,$column,$mdto);
		} else if($column instanceof DynamicColumn ){
			$buffer = IOUtils::writeDynamicColumn($buffer,$column,$mdto);
		} else {
			$buffer  = IOUtils::writeColumn($buffer,$column,$mdto);
		}
		return $buffer;
	}
	
	/**
	 * Read from stream.
	 * 
	 * @param is the is
	 * @param column the column
	 * @param mdto the mdto
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	public static function readFromStream($buffer, $column, $mdto){
		if ($column instanceof Loop) {
			$buffer = IOUtils::readLoopColumn($buffer,$column,$mdto);
		}else if($column instanceof DynamicColumn){
			$buffer = IOUtils::readDynamicColumn($buffer,$column,$mdto);
		}else{
			$buffer = IOUtils::readColumn($buffer,$column,$mdto);
		}
		return $buffer;
	}
	
	/**
	 * Read column.
	 * 
	 * @param is the is
	 * @param column the column
	 * @param mdto the mdto
	 * @throws IOException 
	 */
	private static function readColumn($buffer, $column, $mdto) {
			
		$str = substr(implode($buffer),0,$column->getSize());
		for($i = 0 ; $i < $column->getSize() ; $i++ ){
			unset($buffer[$i]);
		}
		
		$buffer = array_values($buffer);
		$mdto->setParameter($column->getName(), $str);
		return $buffer;
	}

	/**
	 * Read column.
	 * 
	 * @param is the is
	 * @param column the column
	 * @param mdto the mdto
	 * @throws IOException 
	 */
	private static function readDynamicColumn($buffer, $dynamicColumn, $mdto){
		$column = $dynamicColumn->getColumn();
		$lengthStr = substr(implode($buffer),0,$dynamicColumn->getSize());
		$lengthInt = (int)$lengthStr;
			
		for($i = 0 ; $i < $dynamicColumn->getSize() ; $i++ ){
			unset($buffer[$i]);
		}
		
		$buffer = array_values($buffer);
		
		
		$realData = substr(implode($buffer),0,$lengthInt);
		
		for($i = 0 ; $i < $lengthInt ; $i++ ){
			unset($buffer[$i]);
		}
		
		$buffer = array_values($buffer);
		
		$mdto->setParameter($column->getName(), $realData);
		return $buffer;
	}

	/**
	 * Read column.
	 * 
	 * @param is the is
	 * @param column the column
	 * @param mdto the mdto
	 * @throws IOException 
	 */
	private static function readLoopColumn($buffer, $loopColumn, $mdto) {
		
		$columnLength = $loopColumn->getSize();
		
		$loopCnt = (int)substr(implode($buffer),0,$columnLength);
		
		for($i = 0 ; $i < $columnLength ; $i++ ){
			unset($buffer[$i]);
		}
		
		$buffer = array_values($buffer);
		
		$loopGroup = new LoopGroup();
		
		$map = $loopColumn->getMap();
		
		for($i = 0 ; $i < $loopCnt ; $i++){
			
			foreach($map as $key=>$value){
				$column = $value;
				$loopData = new LoopData();
				if($column instanceof DynamicColumn){
					$buffer = IOUtils::readDynamicColumnLoop($buffer,$column,$loopData);
				}else{
					$buffer = IOUtils::readColumnLoop($buffer,$column,$loopData);
				}
				
				$loopGroup->add($loopData);
			}
		}
		
		$mdto->putLoopGroup($loopColumn->getName(), $loopGroup);
		return $buffer;
	}

	/**
	 * 	
	 * @param is
	 * @param column
	 * @param loopData
	 * @throws IOException 
	 */
	private static function readColumnLoop($buffer, $column,$loopData){
		$str = substr(implode($buffer),0,$column->getSize());
		
		for($i = 0 ; $i < $column->getSize() ; $i++ ){
			unset($buffer[$i]);
		}
		
		$buffer = array_values($buffer);
		
		$loopData->setParameter($column->getName(), $str);
		return $buffer;
	}

	/**
	 * 
	 * @param is
	 * @param column
	 * @param loopData
	 * @throws IOException 
	 */
	private static function readDynamicColumnLoop($buffer, $dynamicColumn, $loopData){
		
		$column = $dynamicColumn->getColumn();
		$lengthStr = substr(implode($buffer),0,$dynamicColumn->getSize());
		$lengthInt = (int)$lengthStr;
		
		for($i = 0 ; $i < $dynamicColumn->getSize() ; $i++ ){
			unset($buffer[$i]);
		}
		
		$buffer = array_values($buffer);
		
		$realData = substr(implode($buffer),0,$lengthInt);
		
		for($i = 0 ; $i < $lengthInt ; $i++ ){
			unset($buffer[$i]);
		}
		
		$buffer = array_values($buffer);
		
		$loopData->setParameter($column->getName(), $realData);
		return $buffer;
	}

	/**
	 * Write column.
	 * 
	 * @param os the os
	 * @param column the column
	 * @param mdto the mdto
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private static function writeColumn($buffer, $column,$mdto) {
		$value = $mdto->getParameter($column->getName());
		if($value == null || !isset($value)) $value ="";
		$buffer = IOUtils::write($buffer,$column, $value );
		return $buffer;
	}

	/**
	 * Write column.
	 * 
	 * @param os the os
	 * @param mdto the mdto
	 * @param dynamicColumn the dynamic column
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private static function writeDynamicColumn($buffer, $dynamicColumn, $mdto){
		$column = $dynamicColumn->getColumn();
		$dynamicValue = $mdto->getParameter($column->getName());
		
		if($dynamicValue == null || !isset($dynamicValue)) $dynamicValue = "";	        
	
		$dynamicValueSize = strlen($dynamicValue);
		
		$buffer = IOUtils::write($buffer,$dynamicColumn,(string)$dynamicValueSize);
		
		$buffer = array_merge($buffer,str_split($dynamicValue));
		return $buffer;	
	}

	/**
	 * Write column.
	 * 
	 * @param os the os
	 * @param mdto the mdto
	 * @param loopColumn the loop column
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private static function writeLoopColumn($buffer, $loopColumn,$mdto) {
		
		$loopGroup = $mdto->getLoopGroup($loopColumn->getName());

		if (loopGroup != null) {

			$loopSize = $loopGroup->size();
			
			$buffer = IOUtils::write($buffer, $loopColumn, (string)$loopSize);
			
			for($idx=0 ; $idx < $loopSize ; $idx++){
				$loopData = $loopGroup->get($idx);
				$map = $loopColumn->getMap();
				foreach($map as $key=>$value){
					$col = $value;
					if($col instanceof  DynamicColumn){
						$buffer = IOUtils::writeDynamicColumnLoop($buffer,$col,$loopData);
					}else{
						$buffer = IOUtils::writeColumnLoop($buffer,$col,$loopData);
					}
				}
			}
			
		} else {
			
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("Loop Value Not Found : ".$loopColumn->getName());
			}
			
			$buffer = IOUtils::write($buffer,$loopColumn,"0");
		}
		return $buffer;
	}
	
	/**
	 * Write column.
	 * 
	 * @param os the os
	 * @param dynamicCol the dynamic col
	 * @param loopData the loop data
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private static function writeDynamicColumnLoop($buffer, $dynamicCol, $loopData) {

		$column = $dynamicCol->getColumn();
		$dynamicValue = $loopData->getParameter($column->getName());
		
		if($dynamicValue == null ) $dynamicValue = "";		

		$dynamicSize = strlen($dynamicValue);
		
		
		$buffer = IOUtils::write($buffer,$dynamicCol,(string)$dynamicSize);
		
		$buffer = array_merge($buffer,str_split($dynamicValue));
		return $buffer;
	}

	/**
	 * Write column.
	 * 
	 * @param os the os
	 * @param col the col
	 * @param loopData the loop data
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private static function writeColumnLoop($buffer, $col, $loopData) {
		$value = $loopData.getParameter($col->getName());
		if($value == null) $value ="";
		$buffer = array_merge($buffer,str_split($value));
		return $buffer;
	}

	/**
	 * write.
	 * 
	 * @param out the out
	 * @param column the column
	 * @param str the str
	 * 
	 * @return size
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private static function  write($buffer,$column,$str){
		switch($column->getMode()){
			case Column::MODE_A:
				$buffer = IOUtils::fixPadWrite($column->getName(),$buffer,$column->getSize(),$str," ",false);
				break;
			case Column::MODE_AH:
				$buffer = IOUtils::fixPadWriteAH($column->getName(),$buffer,$column->getSize(),$str," ",false);
				break;
			case Column::MODE_AN:
				$buffer = IOUtils::fixPadWrite($column->getName(),$buffer,$column->getSize(),$str," ",false);
				break;
			case Column::MODE_N:
				$buffer = IOUtils::fixPadWrite($column->getName(),$buffer,$column->getSize(),$str,"0",true);
				break;
			default:
				$buffer = IOUtils::fixPadWrite($column->getName(),$buffer,$column->getSize(),$str," ",false);
				break;
		}
		return $buffer;
	}
	
	
	/**
	 * fixPadWrite.
	 * 
	 * @param name the name
	 * @param out the out
	 * @param fix the fix
	 * @param str the str
	 * @param pad the pad
	 * @param left the left
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private static function fixPadWrite($name,$buffer,$fix,$str,$pad,$left) {
		if($str == null||!isset($str)) $str = "";
		$bSize = strlen($str);
		if($bSize > $fix){
			if(LogMode::isAppLogable())	{
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->warnAppLog($name." Column Data Fix Size Over: fix:".$fix." size:".$bSize);
			}
			$bSize = $fix;
		}
		$padSize = $fix-$bSize;
		$paddingStr = "";
		if($left){ 
			for($i=0;$i<$padSize;$i++){ 
				//out.write((byte)pad);
				$paddingStr.=$pad;
			}
			$buffer = array_merge($buffer,str_split($paddingStr));
			
		}
		
		if($str != null){
			$buffer = array_merge($buffer,str_split($str));
		}
		
		if(!$left){
			for($i=0;$i<$padSize;$i++){
				$paddingStr.=$pad;
				
			}
			$buffer = array_merge($buffer,str_split($paddingStr));
		}
		return $buffer;
	}
	
	/**
	 * fixPadWriteAH
	 * <pre>
	 * 한글이 입력되어 있을 수 있으므로 한글이 깨지지 않도록 byte 를 짤라 낸다.
	 * </pre>
	 * 
	 * @param name the name
	 * @param out the out
	 * @param fix the fix
	 * @param str the str
	 * @param pad the pad
	 * @param left the left
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private static function fixPadWriteAH($name,$buffer,$fix,$str,$pad,$left){
		if($str==null || !isset($str)) $str = "";
		if($str != null){
			if(strlen($str)>$fix){
				
				if(LogMode::isAppLogable()) {
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->warnAppLog($name." Column Data Fix Size Over: fix:".$fix." size:".((string)(strlen($str))));
				}
				
				$str = substr($str,0,$fix);
			} 
		}
		$bSize = strlen($str);
		if($bSize > $fix){
			if(LogMode::isAppLogable()) {
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->warnAppLog($name." Column Data Fix Size Over: fix:".$fix." size:".$bSize);
			}
			
			
			$bSize = $fix;
		}
		$padSize = $fix-$bSize;
		$paddingStr = "";
		if($left){
			for($i=0;$i<$padSize;$i++){
				$paddingStr.=$pad;
			}
			$buffer = array_merge($buffer,str_split($paddingStr));
		}
		if($str != null){
			$buffer = array_merge($buffer,str_split($str));
		}
		
		if(!$left){
			for($i=0;$i<$padSize;$i++){
				$paddingStr.=$pad;
			}
			$buffer = array_merge($buffer,str_split($paddingStr));
		}
		return $buffer;
	}
	
}

?>
