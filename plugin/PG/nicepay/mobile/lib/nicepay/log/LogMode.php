<?php
class LogMode{
	
	private static $EVENT_LOG_MODE = false;
	
	private static $APP_LOG_MODE = false;
	
	public static function isEventLogable(){
		return self::$EVENT_LOG_MODE;
	}
	
	/**
	 * Checks if is app logable.
	 * 
	 * @return true, if is app logable
	 */
	public static function isAppLogable(){
		return self::$APP_LOG_MODE;
	}
	
	/**
	 * Enable trans log mode.
	 */
	public static function enableEventLogMode(){
		self::$EVENT_LOG_MODE = true;
	}
	
	/**
	 * Enable app log mode.
	 */
	public static function enableAppLogMode(){
		self::$APP_LOG_MODE = true;
	}
	
}

?>
