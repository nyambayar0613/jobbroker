<?php
/**
 * 
 * @author kblee
 *
 */
interface WebParamGather{

	/**
	 * Default Constructor
	 */
	public function __construct();
	
	/**
	 * 
	 * @param $request
	 */
	public function gather($request);
}

?>