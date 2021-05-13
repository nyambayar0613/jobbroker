<?php
		/*
		* /application/nad/config/process/description.php
		* @author Harimao
		* @since 2014/03/07
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Description process
		* @Comment :: Description 코멘트 및 기타 처리 프로세스
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		include_once $alice['admin_config_abs_path'] . "/model/alice_description_model.class.php";	// Description Model Class
		include_once $alice['admin_config_abs_path'] . "/controller/alice_description_control.class.php";

		$description_control = new alice_description_control();

		$mode = $_POST['mode'];

		$ajax = $_POST['ajax'];
		$ftable = $_POST['ftable'];
		$fobject = $_POST['fobject'];
		$flocation = $_POST['flocation'];
		$fkind = $_POST['fkind'];

		$description = $_POST['description'];

		switch($mode){

			case 'db_comment':

				if(empty($description)){	// 삭제

					$ROW = $db->query_fetch_rows(" select `no` from `".$description_control->description_table."` where `location` = '".$ftable."' and `object` = '".$fobject."' ");
					
					if($ROW['no']) 

						$result = $db->_query(" delete `".$description_control->description_table."` where `no`= ".$ROW['no']); // 삭제

				} else {
					
					$ROW = $db->query_fetch(" select `no` from `".$description_control->description_table."` where `location` = '".$ftable."' and `object` = '".$fobject."' ");

					if($ROW['no']) { // 수정

						$result = $db->_query(" update `".$description_control->description_table."` set `description` = '".$description."' where `no` = ".$ROW['no']);

					} else if($ftable) { // 신규등록

						$result = $db->_query(" insert into `".$description_control->description_table."` set `location` = '".$ftable."', `object` = '".$fobject."', `kind` = 'T', `description` = '".$description."' ");

					}

				}

				$json['result'] = $result;
				$json['ftable'] = $ftable;
				$json['fobject'] = $fobject;
				$json['description'] = $description;

			break;

			case 'file_comment':

				if(empty($flocation)) $flocation = "./";

				if(empty($description)) { // 삭제

					$ROW = $db->query_fetch(" select `no` from `".$description_control->description_table."` where `location` = '".$flocation."' and `object` = '".$fobject."' ");

					if($ROW['no']) 
						
						$result = $db->_query(" delete `".$description_control->description_table."` where `no` = " . $ROW['no']);

				} else {

					$ROW = $db->query_fetch(" select `no` from `".$description_control->description_table."` where `location` = '".$flocation."' and object='".$fobject."' ");

					if($ROW['no']) { // 수정

						$result = $db->_query("update `".$description_control->description_table."` set `description` = '".$description."' where `no` = " . $ROW['no']);

					} else if($flocation && $fobject) { // 신규등록

						$result = $db->_query("insert into `".$description_control->description_table."` set `location` = '".$flocation."', `kind` = '".$fkind."', `object` = '".$fobject."', `description` = '".$description."' ");

					}

				}

				$json['result'] = $result;
				$json['flocation'] = $flocation;
				$json['fobject'] = $fobject;
				$json['fkind'] = $fkind;
				$json['description'] = $description;

			break;

		}


		echo json_encode($json);

?>