<?php
		/**
		* /application/nad/config/model/alice_description_model.class.php
		* @author Harimao
		* @since 2014/03/07
		* @last update 2014/03/07
		* @Module v3.5 ( Alice )
		* @Brief :: DB scheme, FILE Description
		* @Comment :: 데이터베이스, 파일 디렉토리 구조 클래스
		*/
		class alice_description_model extends DBConnection {

			var $description_table = "alice_description";

			var $success_code = array(
					'0000' => '코멘트가 입력 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '코멘트 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);


				// 구조 테이블 Scheme
				function description_scheme( ){

					global $alice;

						$_scheme = "
							CREATE TABLE `".$this->description_table."` (
							`no` integer unsigned NOT NULL auto_increment,
							`kind` enum('F','D','T') default 'F',
							`location` varchar(255) NOT NULL default '',
							`object` varchar(255) NOT NULL default '',
							`description` varchar(255) default NULL,
							PRIMARY KEY (`no`)
							) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COMMENT 'Description';
						";


					return $_scheme;

				}

				// kind fetch rows
				function description_kind( $table="", $kind, $object="" ){

					global $is_demo;

						$result = array();

						if($table){

							$query = " select * from `".$this->description_table."` where `kind` = '".$kind."' and `location` = '".$table."' and `object` <> '' ";

						} else {

							$query = " select * from `".$this->description_table."` where `kind` = '".$kind."' and `object` = '".$object."' ";

						}

						$exists_table = ( $this->_query($query,false) ) ? true : false;

						if(!$exists_table) 
							$this->_query( $this->description_scheme() );	// description 테이블 생성
						

						$CDATA = $this->query_fetch_rows($query);


						$DATAS = array();

						if($table){	// 테이블 지정

							if($CDATA){
								foreach($CDATA as $CROW) $DESCRIPTION[$CROW['object']] = $CROW['description'];
							}

							$result['DESCRIPTION'] = $DESCRIPTION;
							$result['DATA'] = $this->query_fetch_rows("desc `".$table."` ");


						} else {	 // 미지정

							if($CDATA){
								foreach($CDATA as $CROW) $DESCRIPTION[$CROW['location']] = $CROW['description'];
							}

							$result['DESCRIPTION'] = $DESCRIPTION;
							$result['DATA'] = $this->query_fetch_rows("show tables");
													
						}
						
					
					return $result;

				}

				function searchdir($path, $maxdepth = -1, $mode = "FULL", $d = 0){
					
						$dirlist = array ();
						
						if(substr($path,-1)!= '/') 
							$path .= '/';

						if($mode != "FILES") 
							$dirlist[] = $path;

						if($handle = opendir($path)) {
							while(false !==($file = readdir($handle))) {
								if($file != '.' && $file != '..' ) {
									$file = $path.$file;
									if(!is_dir($file)) { 
										if($mode != "DIRS") $dirlist[] = $file;
									} else if($d >=0 && ($d < $maxdepth || $maxdepth < 0)) {
										$dirlist = @array_merge($dirlist, $this->searchdir($file . '/', $maxdepth, $mode, $d + 1));
									}
								}
							}
							closedir($handle);
						}

						if($d == 0) 
							natcasesort($dirlist);

					
					return $dirlist;

				}

				function printDate($timestamp) {

					return date("Y-m-d",$timestamp)." <font color='#3366CC'>".date("H:i:s",$timestamp)."</font>";

				}


				/**
				* 에러코드에 맞는 에러를 토해낸다.
				*/
				function _errors( $err_code ){

						$result = $this->fail_code[$err_code];

					return $result;

				}

				/**
				* 완료코드에 맞는 에러를 토해낸다.
				*/
				function _success( $success_code ){

						$result = $this->success_code[$success_code];

					return $result;

				}

		}	// class end.
?>