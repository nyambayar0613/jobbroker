<?php
		/**
		* /engine/core/custom.php
		* @author Harimao
		* @since 2013/05/24
		* @last update 2013/05/24
		* @Module v3.5 ( Alice )
		* @Brief :: Application Customizing user add Classes
		* @Comment :: 커스터마이징시 클래스를 추가할 경우 사용한다.
		*/


		/* 
		 * Model Classes 
		 * 모델로 사용할 클래스 파일을 이곳에서 include 합니다.
		 * 파일의 경로는 /engine/app_config.php 파일에서 설정하시거나 고정 변수로 넣으신 후
		 * 경로에 맞게 아래와 같이 include 하시면 됩니다.
		 */

			// 예시입니다. ($alice['main_abs_path'] 와 같은 변수는 app_config.php 에서 설정 하시면 됩니다)
			//include_once $alice['main_abs_path'] . "/controller/alice_main_model.class.php";					

		/* // Model Classes */


		/* Control Classes */
			//include_once $alice['main_abs_path'] . "/controller/alice_main_control.class.php";					// 예시입니다.

		/* //Control Classes */


		/* Objectives Library Class */

			//$main_control = new alice_main_control();						// alice main 클래스에 대한 객체 생성

		/* //Objectives Library Class */

?>