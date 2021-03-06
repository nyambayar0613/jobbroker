<?php
		/**
		* /engine/library/db.class.php
		* @author Harimao
		* @since 2012/04/20
		* @last update 2013/05/24
		* @Module v3.5 ( Alice )
		* @Brief :: DB Class
		* @Comment :: DB Control Class
		*/
		class DBConnection {

			/*var $db_host		= "178.18.242.18";
			var $db_name		= "jobbroker";
			var $db_user		= "itwizard";
			var $db_pass		= "DP3Y5M32wD9TXWgt";*/
            var $db_host		= "192.168.0.103";
            var $db_name		= "jobbroker";
            var $db_user		= "mjobUser1";
            var $db_pass		= "mjobWizard$%";

			/**
			 * 	Connection link.
			 * 	@var string
			 */
			//private $connection;		// php5
			var $connection;
			
			/**
			 * Keeps the info of the last used connection.
			 * @var string
			 */
			//private $last_connection = null;		// php5
			var $last_connection = null;
			
			/**
			 * Keeps the info of the last used MySQL query.
			 * @var string
			 */
			//private $msql = '';	// php5
			var $msql = '';
			
			/**
			 * Returns the text of the error message from last MySQL operation.
			 * @var string
			 */
			//private $err_msg = '';	// php5
			var $err_msg = '';
			
			/**
			 * Returns the numerical value of the error message from last MySQL operation.
			 * @var integer
			 */
			//private $err_no = '';		// php5
			var $err_no = '';
			
			/**
			 * Is there any locked tables right now?
			 * @var boolean
			 */
			//private $is_locked = false;	// php5
			var $is_locked = false;


				//function DBConnection($db_host='', $db_user='', $db_pass='', $db_name='') {
				function DBConnection() {

						global $alice;

						$this->connection = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
						
						if ( $this->connection ) {

							if (strtolower($alice['charset']) == 'utf-8') {

								@mysql_query(" set names utf8 ");

							} else if (strtolower($alice['charset']) == 'euc-kr') {

								@mysql_query(" set names euckr ");

							}

							if ( mysql_select_db($this->db_name, $this->connection) ){

								$this->last_connection = &$this->connection;

								return $this->connection;

							} else { // if we can't select the database

								$this->display_errors( "DB ????????? ?????? ???????????????. DB name :: " . $this->db_name.'' );

								return false;
							}

						} else { // if we couldn't connect to the database

							$this->display_errors( "DB ?????? ??????\n\nDB ??????????????? ????????? ?????????. DB name :: ".$this->db_name.'' );

							return false;
						}

				}


				/**
				 * Send a MySQL query.
				 * @param  string  Query to run
				 * @return mixed
				 */
				function _query( $query, $error=TRUE ){

						$this->last_connection = &$this->connection;

						$this->msql = &$query;

						$result = mysql_query($query, $this->connection);

						//echo "<br/><br/>".$query."<br/><br/>";

						if ( $result ) {

							$this->queries_count++;

							return $result;

						} else {

							if ($error)	// error ??? ???????????????

								return $this->display_errors();
							
							else

								return false;

						}

				}


				/**
				 * Fetch a result row as an associative array.
				 * @param  string  The query which we send.
				 * @return array
				 * @???????????? _query ????????? ??????????????? ?????? 1?????? ????????? ????????? ????????????. (??????)
				 */
				function _fetch( $query ) {

					return mysql_fetch_assoc($query);

				}


				/**
				 * Fetch a result row as an associative array.
				 * @param  string  The query which we send.
				 * @query => fetch_assoc
				 * @return array
				 * @???????????? _query ????????? ???????????? ????????? ?????? 1?????? ????????? ????????? ????????????. (??????)
				 */
				function query_fetch($query) {

						$result = $this->_query($query);
				
						$row = $this->_fetch($result);


					return $row;

				}


				/**
				 * Fetch a result row as an associative array.
				 * @param  string  The query which we send.
				 * @query => fetch_assoc => rows
				 * @return array
				 * @???????????? ????????? ??????????????? ???????????? ???????????? ????????? ????????? ????????????. (??????)
				 */
				function query_fetch_rows($query) {

						$result = $this->_query($query);
				
						$total_row = array();

						while( $rows = $this->_fetch($result) ) {
					
							$total_row[] = $rows;

						}

					return $total_row;

				}


				/**
				 * Fetch a result row as an object
				 * @param  string  The query which we send.
				 * @return array
				 * @PHP > 5 :: ???????????? _query ????????? ??????????????? ?????? ????????? ?????? ????????? ????????????. (??????)
				 */
				function _ofetch($query) {

					return mysql_fetch_object($query);

				}


				/**
				 * Fetch a result row as an object
				 * @param  string  The query which we send.
				 * @query => fetch_object
				 * @return array
 				 * @PHP > 5 :: ???????????? _query ????????? ???????????? ????????? ?????? 1?????? ????????? ???????????? ????????? ????????????. (??????)
				 */
				function query_ofetch($query) {

						$result = $this->_query($query);
				
						$row = $this->_ofetch($result);

					return $row;

				}

				
				/**
				 * Fetch a result row as an associative array.
				 * @param  string  The query which we send.
				 * @query => fetch_assoc => rows
				 * @return array
				 * @PHP > 5 :: ???????????? ????????? ??????????????? ???????????? ???????????? ????????? ???????????? ????????? ????????????. (??????)
				 */
				function query_ofetch_rows($query) {

						$result = $this->_query($query);

						$total_row = array();

						while( $rows = $this->_ofetch($result) ) {
					
							$total_row[] = $rows;

						}

					return $total_row;

				}


				/**
				 * Fetch a result row as an associative array, a numeric array, or both.
				 * @param  string  The query which we send.
				 * @return array
				 */
				function afetch($query) {

					return mysql_fetch_array($query);

				}

				function num_rows($query) {
					return mysql_num_rows($query);
				}

				/**
				 * Fetch a result row as an associative array, a numeric array, or both.
				 * @param  string  The query which we send.
				 * @return array
				 */
				function query_afetch($query) {
						
						$result = $this->_query($query);

					return mysql_fetch_array($result);

				}
					

				/**
				 * Retuns the number of rows affected bt last used query.
				 * @return integer
				 * @???????????? ????????? ???????????? ?????? ????????? ????????????. (??????) - ??? ???????????? ????????? ????????? ????????? ???????????? ??????????????????.
				 */
				function affected_rows() {
						
					return mysql_affected_rows($this->last_connection);

				}


				/**
				 * Retuns the number of rows count bt last used query.
				 * @return integer
				 * @????????? ?????? ????????????.
				 */
				function _queryR( $query ) {

						$row = $this->query_fetch_rows($query);

					return count($row);

				}


				/**
				 * Returns the total number of executed queries. Usually goes to the end of scripts.
				 * @return integer
				 * @?????? ??????????????? ????????? ?????? ?????????????????? ???????????? ??????. (???????????? ???????????? ?????? ???????????? ?????????.)
				 */
				function num_queries() {

					return $this->queries_count;

				}
				

				/**
				 * Lock database table(s).
				 * @param   array  Array of table => Lock type
				 * @return  void
				 */
				function lock_tables($tables) {

						if ( is_array($tables) && count($tables) > 0 ) {

							$msql='';
							
							foreach ($tables as $name=>$type) {

								$msql .= (!empty($msql) ? ', ' : '') .'' . $name . ' ' . $type . '';

							}
							
							$this->_query('LOCK TABLES ' . $msql . '');

							$this->is_locked = true;

						}

				}
				

				/* Unlock database table(s) */
				function unlock_tables() {

						if ( $this->is_locked ) {

							$this->_query('UNLOCK TABLES');

							$this->is_locked = false;

						}

				}
				

				/**
				 * Returns the last unique ID (auto_increment field) from the last inserted row.
				 * @return  integer
				 */
				function last_id() {

					return mysql_insert_id($this->connection);

				}
				

				/**
				 * Escapes a value to make it safe for using in queries.
				 * @param  string  String to be escaped
				 * @param  bool    If escaping of % and _ is also needed
				 * @return string
				 */
				function string_escape($string, $full_escape=false) {

						$string = stripslashes($string);
						
						if ($full_escape) 
							$string = str_replace(array('%', '_'), array('\%', '\_'), $string);
						
						if ( function_exists('mysql_real_escape_string') ) {

							return mysql_real_escape_string($string, $this->connection);

						} else {

							return mysql_escape_string($string);

						}

				}
				

				/**
				 * Free result memory.
				 * @param  string   The result which we want to release.
				 * @return boolean
				 */
				function free_result($result) {

					return mysql_free_result($result);

				}


				/**
				 * Closes the MySQL connection.
				 * @param  none
				 * @return boolean
				 */
				function close() {

						$this->msql='';

					return mysql_close($this->connection);

				}
				

				/**
				 * Returns the MySQL error message.
				 * @return string
				 */
				function err_msg() {

						$this->err_msg = (is_null($this->last_connection)) ? '' : mysql_error($this->last_connection);

					return $this->err_msg;

				}
				

				/**
				 * Returns the MySQL error number.
				 * @return string
				 */
				function err_no() {

						$this->err_no = (is_null($this->last_connection)) ? 0 : mysql_errno($this->last_connection);

					return $this->err_no;

				}

				 
				/**
				 * If database error occur, the script will be stopped and an error message displayed.
				 * @param  string  The error message. If it's empty, it will be created with $this->sql.
				 * @return string
				 */
				function display_errors($error_message='') {

					global $is_debug;

						if ( $this->last_connection ) {

							$this->err_msg = $this->err_msg($this->last_connection);

							$this->err_no = $this->err_no($this->last_connection);

						}


						if(!$error_message)
							$error_message = "ERROR CODE ". $this->err_no . " : " . addslashes($this->msql);

						echo "<table border=0 cellpadding=3 cellspacing=1>\n";
						echo "<tr>\n";
						echo "<td colspan=2 align=center bgcolor=#cccccc><b><font size=2>???????????? ????????? ????????????.</b></font></td>\n";
						echo "</tr>\n";
						echo "<tr>\n";
						echo "<td bgcolor=#F5F5F5><font size=2>?????????</font></td>\n";
						echo "<td><font size=2>" . addslashes($this->msql) . "</font></td>\n";
						echo "</tr>\n";
						echo "<tr><td colspan=2 height=1 bgcolor=#CCCCCC></td></tr>\n";
						echo "<tr>\n";
						echo "<td bgcolor=#F5F5F5><font size=2>???????????????</font></td>\n";
						echo "<td><font size=2>" . $error_message . "</font></td>\n";
						echo "</tr>\n";
						echo "<tr><td colspan=2 height=1 bgcolor=#CCCCCC></td></tr>\n";
						echo "<td bgcolor=#F5F5F5><font size=2>?????????</font></td>\n";
						echo "<td><font size=2>" . $_SERVER['SCRIPT_FILENAME'] . "</font></td>\n";
						echo "</tr>\n";
						echo "<tr><td colspan=2 height=1 bgcolor=#CCCCCC></td></tr>\n";
						echo "</table>\n";

						exit;

				}


		}	// class end.

?>