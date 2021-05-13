<?php
		/**
		* /engine/library/utility.class.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/02/12
		* @Module v3.3 ( Alice )
		* @Brief :: Utility Class
		* @Comment :: 모두 사용되는 함수들
		*/
		class utility {


				// 임시 번호를 생성하는 함수 
				function get_unique_code( $prefix = '' ){

						$mdate = substr(microtime(),2,4);

						$result = $prefix ? $prefix . '_' . date("ymdHis") . $mdate : date("YmdHis") . '_' . $mdate;

					return $result;

				}


				// 임시 번호를 생성하는 함수 2
				function get_suffle_code( $val="" ){

						$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

				        shuffle($chars_array);

						$shuffle = implode("", $chars_array);

						$result = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $val)));

					return $result;

				}


				// 임시 번호를 생성하는 함수 3
				function getOrderNumber($length) {

						$md5Temp = md5(uniqid(rand()));
						$unique = substr($md5Temp, 0, $length);
						$sumTemp = (date("Y")+date("m")+date("d")+date("H")+date("i")+date("s")+19)*997;
						$lengthTemp = strlen($sumTemp);
						$checksum = substr($sumTemp,$lengthTemp-2,2);
						$ordernum = "S".$unique.$checksum;
					
					return strtoupper($ordernum);

				}


				// SQL 쿼리 문자열 생성
				function QueryString( $arr ){
					
						foreach($arr as $field => $value) $field_vals[count($field_vals)] = $value!==NULL ? 

							is_array(unserialize($value)) ? "`$field` = '$value'" : "`$field` = '" . addslashes($value) . "'" : "`$field` = '' ";

					return @join(', ', $field_vals);

				}

				// SQL 쿼리 문자열 생성 2
				function query_string( $arr ) {
					
						$field_vals = array();
						
						foreach($arr as $field => $value) $field_vals[] = ($value===NULL) ? "`".$field."` = NULL" : "`".$field."` = '".addslashes($value)."' ";


					return @join(', ', $field_vals);
				}


				// 에러 로그 작성
				function write_log($message){

						global $realpath;

						$dir = $realpath . 'engine/_error/';
						
						if(!file_exists($dir)){
							mkdir($dir);
						}
						
						date_default_timezone_set('Asia/Seoul');
						
						$logData = date("YmdGis")." : ".$message;
						
						error_log( $logData . PHP_EOL ,3 ,$dir . date("Ymd").".log");
				}

				
				// 파일의 확장자를 구하는 함수
				function get_extension( $file ){

						return strtolower(substr(strrchr($file,"."),1));

				}


				// 자바스크립트 오류 메시지 토해내고 이동
				// 이동 경로가 없는 경우 바로 전 페이지로 이동
				function popup_msg_js( $msg, $url="" ){
					
						$path = parse_url($_SERVER['PHP_SELF']);
						
						$query = $_SERVER['QUERY_STRING'];

						$back_url = $path['path'].'?'.$query;
					
						$back_url = base64_encode($back_url);			

						$result = "<script>";

							if($msg) 

								$result .= "alert('$msg');";

							if($url) {

								$result .= "location.replace('$url');";

							} else {

								$result .= "history.go(-1)";

							}

						$result .= "</script>";
						

					echo $result;

					exit;
				}


				// 자바스크립트 오류 메시지 토해내고 정지 (ajax 에서 주로 사용)
				function popup_msg_ajax( $msg ){
					
						$result = "<script>";

							if($msg) {

								$result .= "alert('$msg');";

							}

						$result .= "</script>";
						

					echo $result;

					exit;
				}


				// 자바스크립트 오류 메시지 토해내기만 함
				function popup_msg_alert( $msg ){
					
						$result = "<script>";

							if($msg) {

								$result .= "alert('$msg');";

							}

						$result .= "</script>";

						
					echo $result;
				}


				// 단순 페이지 이동
				function location_href( $href ){
					
						$result = "<script>";

							if($href) {

								$result .= "location.replace('".$href."');";

							}

						$result .= "</script>";

						
					echo $result;

					exit;
				}


				// 자바스크립트 오류 메시지 토해내고 창 닫기
				function popup_msg_close( $msg ){
					
						$result = "<script>";

							if($msg) {

								$result .= "alert('$msg');";

								$result .= "self.close();";

							}

						$result .= "</script>";

						
					echo $result;
				}

				// 부모창 새로고침, 창 닫기
				function popup_close_replace( ){
					
						$result = "<script>";

						$result .= "window.opener.location.reload();";	// 파폭에서도 되나?

						$result .= "self.close();";

						$result .= "</script>";

						
					echo $result;
				}


				// https를 사용하는 경우에는 로그인시 다르게 나간다. 
				function get_https( $flag=false ){
					
						global $is_https;

						if($flag) {

							return "http://" . $_SERVER['HTTP_HOST'];

						}
						
						if($is_https) {

							return "https://" . $_SERVER['HTTP_HOST'];

						} else {

							return "";

						}
						
				}


				// 도메인에 http를 붙인다
				function add_http( $domain ){

					global $is_https;					

					if( strpos($domain, 'http' ) === FALSE){
                        $https_url_chk = $is_https ? "https://" : "http://";
						return $https_url_chk . $domain;

					} else {

						return $domain;

					}

				}


				// url에 http:// 를 붙인다
				function set_http( $url ) {
					
						if (!trim($url)) return;

						if (!preg_match("/^(http|https|ftp|telnet|news|mms)\:\/\//i", $url))
							$url = "http://" . $url;


					return $url;

				}


				// 도메인에 http를 없앤다
				function remove_http( $domain ){
					
					if( stristr($domain, 'http://' ) ){

						$trans = array("http://" => "", "https://" => "");

						return strtr($domain, $trans);

					} else {

						return $domain;

					}

				}


				// unique file name 생성
				function get_unique_file( $file, $no='' ){

						$ext = self::get_extension($file);

						$code= self::get_unique_code() . $no;

					return $code . '.' . $ext;

				}


			   /*
				*
				* 썸네일 함수
				* src_file = 원본파일이름(디렉토리 포함)
				* dest_file = 저장할 파일 이름(디렉토리 포함)
				* sFactor = 크기(지정하지 않을 경우, 원본 크기 대로 섬네일)
				*
				*/
				function _thumbnail($src_file, $dest_file, $sFactor='', $width='', $height='',$org_img=''){

						$img_info = @getimagesize($src_file);
						
						if($width>=$img_info[0]) $width = $img_info[0];
						if($height>=$img_info[1]) $height = $img_info[1];
						
						$src_img = '';		//원본이미지 카피본
						$dst_img = '';		//만들어낼 이미지
						$dst_width = '';	//만들어질 가로 사이즈
						$dst_height = '';	//만들어질 세로 사이트		

						//이미지가 아닐경우에는 그냥 옮겨 버린다.
						if(!$img_info || !is_array($img_info))
							return move_uploaded_file($src_file, $dest_file);
					
						
						$org_width = $img_info[0];  //원본 가로사이즈
						$org_height = $img_info[1]; //원본 세로사이즈

						switch($img_info[2]) {
							case 1:
								$src_img =@imagecreatefromgif($src_file);			    
								break;
							case 2:
								$src_img = @imagecreatefromjpeg($src_file);			    
								break;
							case 3:
								$src_img =@imagecreatefrompng($src_file);			    
								break;			
							case 6:
								$src_img =$this->ImageCreateFromBMP($src_file);
								break;
							break;
							case 4:
								return move_uploaded_file($src_file, $dest_file);
						}

						if(!$src_img)
							return move_uploaded_file($src_file, $dest_file);

						if($org_img) //원본이미지 저장
							move_uploaded_file($src_file, $org_img);  
						

						//가로, 세로 사이즈의 비율을 구한다.
						$dst_width = $img_info[0]; 
						$dst_height = $img_info[1]; 

						if($sFactor)	{	//이미지 사이즈를 지정한 경우
							
							if($img_info[0]  > $sFactor){  //지정한 사이즈보다 클때
								$per= $sFactor/$img_info[0];
								$dst_width=ceil($img_info[0]*$per);
								$dst_height=ceil($img_info[1]*$per);
							} else {
								$dst_width=ceil($img_info[0]);
								$dst_height=ceil($img_info[1]);
							}
						} else {	//지정하지 않은 경우는 원본 사이즈로 한다.
							$fixed = $width && intval($width, 10) && $height && intval($height, 10);
							if($fixed) :
								$dst_width = $width;
								$dst_height = $height;
							else :
								$dst_width=ceil($img_info[0]);
								$dst_height=ceil($img_info[1]);
							endif;
						}

						
						$srcx = 0;
						$srcy = 0;
						
						//이미지를 만들어 냄.
						if($img_info[2] == 1){
						  $dst_img = imagecreate($dst_width, $dst_height);
						}else{
						  $dst_img = imagecreatetruecolor($dst_width, $dst_height);
						}

						$bgc = imagecolorallocate($dst_img, 255, 255, 255);
						imagefilledrectangle($dst_img, 0, 0, $dst_width, $dst_height, $bgc);
						

						if($fixed){
							imagecopyresampled($dst_img, $src_img, 0,0,$srcx,$srcy,$width, $height, $org_width,$org_height);
						} else {
							imagecopyresampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, imagesx($src_img),imagesy($src_img));
						}
						
						if($img_info[2] == 1) {
							imageinterlace($dst_img);
							@imagegif($dst_img, $dest_file);
						
						} else if($img_info[2] == 2) {
							imageinterlace($dst_img);
							@imagejpeg($dst_img, $dest_file,100);			
							
						} else if($img_info[2] == 3) {
							imageinterlace($dst_img);
							@ImagePNG($dst_img, $dest_file);

						} else if($img_info[2] == 6) {	// bitmap
							@imagegif($dst_img, $dest_file, 100);
						}

						imagedestroy($dst_img);
						imagedestroy($src_img);

						//return $dest_file;
						return true;

				}

			   /*
				*
				* $file_name   : 파일명
				* $width       : 썸네일의 폭
				* $height      : 썸네일의 높이 (지정하지 않으면 썸네일의 넓이를 사용)
				* $width, $height에 모두 값이 없으면, 이미지 사이즈 그대로 thumb을 생성
				* $is_create   : 썸네일이 이미 있을 때, 새로 생성할지 여부를 결정
				* $is_crop     : 세로 높이가 $height를 넘을 때 crop 할 것인지를 결정
				*                0 : crop 하지 않습니다
				*                1 : 기본 crop
				*                2 : 중간을 기준으로 crop
				* $quality     : 썸네일의 quality (jpeg, png에만 해당하며, gif에는 해당 없슴)
				* $small_thumb : 1 (true)이면, 이미지가 썸네일의 폭/높이보다 작을 때에도 썸을 생성
				*                2이면, 이미지가 썸네일의 폭/높이보다 작을 때 확대된 썸을 생성
				* $watermark   : 워터마크 출력에 대한 설정 
				*                $watermark[][filename] - 워터마크 파일명
				*                $watermark[location] - center, top, top_left, top_right, bottom, bottom_left, bottom_right
				*                $watermark[x],$watermark[y] - location에서의 offset
				* $filter      : php imagefilter, http://kr.php.net/imagefilter
				*                $filter[type], [arg1] ... [arg4]
				* $noimg       : $noimg(이미지파일)
				* $thumb_type  : 저장할 썸네일의 형식 (jpg/gif/png. 나머지는 원본대로)
				*/
				function thumbnail($file_name, $width=0, $height=0, $is_create=false, $is_crop=2, $quality=90, $small_thumb=1, $watermark="", $filter="", $noimg="", $thumb_type="", $mb_id="") {

					global $alice, $ym;

						// memory limit 설정 변경
						@ini_set("memory_limit", -1);

						// 썸네일 디렉토리
						$real_dir = dirname($_SERVER['DOCUMENT_ROOT'] . "/" . $alice['app'] . "/data");
						if($mb_id) $file_name = $alice['data_member_path'] . '/' . $mb_id . '/' . $file_name;
						else $file_name = $alice['data_pin_path'] . '/' . $ym . '/' . $file_name;
						$thumb_dir = dirname($file_name);
						$file = basename($file_name);

						// 썸네일을 저장할 디렉토리
						$thumb_path = $thumb_dir . "/" . $width . "x" . $height;

						if (!file_exists($thumb_dir)) {
							@mkdir($thumb_dir, 0707);
							@chmod($thumb_dir, 0707);
						}

						if (!file_exists($thumb_path)) {
							@mkdir($thumb_path, 0707);
							@chmod($thumb_path, 0707);
						}

					
						$index_file = $thumb_path . '/index.html';	// index.html 파일 생성
						if(!file_exists($index_file)){	// 디렉토리 보안을 위해서
							$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);
						}


						$source_file = $thumb_dir . "/" . $file;

						$size = @getimagesize($source_file);
						$size_org = $size;


						// 이미지 파일이 없는 경우
						if (!$size[0]) {

							// $nomimg에 설정이 없으면 빈 이미지 파일을 생성
							if ($noimg) 
								return $noimg;
							else {
								if (!$width) $width = 30;
								if (!$height)  $height = $width;

								$thumb_file = $thumb_dir . "/" . $width . "x" . $height . "_noimg.gif";


								if (@file_exists($thumb_file))
								;
								else {
									$target = imagecreate($width, $height);
									$bg_color = imagecolorallocate($target, 250, 250, 250);
									$font_color = imagecolorallocate($target, 0, 0, 0);
									$font_size = 12;
									$ttf = "$real_dir/img/han.ttf";
									$text = "no image...";
									$size = imagettfbbox($font_size, 0, $ttf, $text);
									$xsize = abs($size[0]) + abs($size[2])+($padding*2);
									$ysize = abs($size[5]) + abs($size[1])+($padding*2);
									$xloc = $width/2-$xsize/2;
									$yloc = $height/2-$ysize/2;
									imagefttext($target, $font_size, 0, $xloc, $yloc, $font_color, $ttf, $text);
									//imagecopy($target, $target, 0, 0, 0, 0, $width, $height);
									imagegif($target, $thumb_file, $quality);
									@chmod($thumb_file, 0606); // 추후 삭제를 위하여 파일모드 변경
								}
								return str_replace($real_dir, "", $thumb_file);
							}
						}

						$thumb_file = $thumb_path . "/" . $file;

						// 썸파일이 있으면서 소스파일보다 생성 날짜가 최근일 때
						if (@file_exists($thumb_file)) {
							$thumb_time = @filemtime($thumb_file);
							$source_time = @filemtime($source_file);
							if ($is_create == false && $source_time < $thumb_time) {
								return str_replace($real_dir, "", $thumb_file);
							}
						}

						// $width, $height 값이 모두 없는 경우는 현재 사이즈 그대로 thumb을 생성
						if (!$width && !$height) $width = $size[0];

						// 작은 이미지의 경우에도 썸네일을 생성하는 옵션이 없고, 원본 이미지의 size가 thumb보다 작으면 썸네일을 만들지 않는다 (높이가 지정되지 않으면 pass~!)
						//if (!$small_thumb && $width >= $size[0] && $height && $height >= $size[1]) return str_replace($real_dir, "", $source_file);

						$is_imagecopyresampled = false;
						$is_large = false;


						if ($size[2] == 1)	// gif
							$source = imagecreatefromgif($source_file);
						else if ($size[2] == 2) {	// jpeg
							// php.net에서 - As of PHP 5.1.3, if you are dealing with corrupted JPEG images 
							//               you should set the 'gd.jpeg_ignore_warning' directive to 1 to ignore warnings that could mess up your code.
							// 어지간한 경고는 무시하는데, 메모리 부족이 나면 그냥 쥑어 버립니다. 아무런 워닝이나 오류도 없이. 상황종료
							@ini_set('gd.jpeg_ignore_warning', 1);

							/*
							// $msize=php의 할당메모리, $isize=24bit plain에서 본 필요 메모리
							// 메모리가 부족하면 워닝이고 뭐고간에 그냥 죽으므로, 썸을 못 만든다.
							$msize = memory_get_usage();

							$isize = $size['bits'] / 8 * $size[0] * $size[1];
							if ($isize > $msize)
							return $file_name;
							*/

							$source = imagecreatefromjpeg($source_file);

							// jpeg 파일의 오류가 나왔을 때, 워터마크가 있으면 오류생성? - 워터마크 없으면 원본을 그냥 사용 (빈도가 낮으니까)
							if (!$source) {
								if (trim($watermark) && count($watermark) > 0)
								;
								else
								return $file_name;
							}
						}
						else if ($size[2] == 3)	 // png
							$source = imagecreatefrompng($source_file);
						else if ($size[2] == 6) {	// bmp
							// bmp 파일은 gif 형식으로 썸네일을 생성
							$source = $this->ImageCreateFromBMP($source_file);
							$size[2] = 1;
						} else if ($size[2] == 5) {	// psd
							// psd로 썸네일 만들기
							$source = imagecreatefrompsd($source_file);
							$size[2] = 1;
						} else {
							return str_replace($real_dir, "", $source_file);
						}

						// 썸네일 확대
						if ($small_thumb == 2) {
							$size0 = $size[0];
							$size1 = $size[1];

							if ($width) {
								$size[0] = $width;
								$size[1] = (int) $width * ($size1/$size0);
							} else if ($height) {
								$size[1] = $height;
								$size[0] = (int) $height * ($size0/$size1);
							} else
								return str_replace($real_dir, "", $source_file);

							$target = imagecreatetruecolor($size[0], $size[1]);
							imagecopyresampled($target, $source, 0, 0, 0, 0, $size[0], $size[1], $size0, $size1);
							$source = $target;

							unset($target);
						}

						if ($width) {
							$x = $width;
							if ($height) {
								if ($width > $size[0]) {  // $width가 이미지 폭보다 클때 ($width의 resize는 불필요)
									if ($height > $size[1]) {
										$x = $size[0];
										$tmp_y = $size[1];
										$target = imagecreatetruecolor($x, $tmp_y);
										imagecopyresampled($target, $source, 0, 0, 0, 0, $x, $tmp_y, $size[0], $size[1]);
									} else {
										if ($is_crop) { // 넘치는 높이를 잘라줘야 합니다
											$x = $size[0];
											$y = $size[1];
											$tmp_y = $height;
											$target = imagecreatetruecolor($x, $tmp_y);
											$tmp_target = imagecreatetruecolor($x, $tmp_y);
											imagecopyresampled($tmp_target, $source, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);
											imagecopy($target, $tmp_target, 0, 0, 0, 0, $x, $tmp_y);
										} else {
											$y = $height;
											$rate = $y / $size[1];
											$x = (int)($size[0] * $rate);
											$target = imagecreatetruecolor($x, $y);
											imagecopyresampled($target, $source, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);
										}
									}
								} else { // $width가 이미지 폭보다 작을 때 (폭의 resize가 필요)
									$y = $height;
									$rate = $x / $size[0];
									$tmp_y = (int)($size[1] * $rate);
									if ($height > $tmp_y) {
										if ($height < $size[1]) {
											if ($is_crop) {     // 높이가 작으므로 이미지의 폭만 crop
												$rate = $y / $size[1];
												$tmp_x = (int)($size[0] * $rate);
												$target = imagecreatetruecolor($x, $y);
												$tmp_target = imagecreatetruecolor($tmp_x, $y);
												imagecopyresampled($tmp_target, $source, 0, 0, 0, 0, $tmp_x, $y, $size[0], $size[1]);
												// copy하는 위치가 이미지의 수평중심이 되게 조정
												$src_x = (int)(($tmp_x - $x)/2);
												imagecopy($target, $tmp_target, 0, 0, $src_x, 0, $x, $y);
											} else {
												$target = imagecreatetruecolor($x, $tmp_y);
												imagecopyresampled($target, $source, 0, 0, 0, 0, $x, $tmp_y, $size[0], $size[1]);
											}
										} else {
											// 썸 생성후의 높이가 최종 높이보다 낮으므로 이미지의 폭만 crop
											if ($is_crop == 1) {          // 좌측에서 부터
												$tmp_x = (int)$size[0];
												$tmp_y = (int)$size[1];
												$target = imagecreatetruecolor($x, $tmp_y);
												imagecopyresampled($target, $source, 0, 0, 0, 0, $x, $tmp_y, $x, $tmp_y);
											} else if ($is_crop == 2) {   // 중간에서
												$tmp_x = (int)($size[0]/2) - (int)($x/2);
												$tmp_y = (int)$size[1];
												$target = imagecreatetruecolor($x, $tmp_y);
												imagecopyresampled($target, $source, 0, 0, $tmp_x, 0, $x, $tmp_y, $x, $tmp_y);
											} else {                      // 생각없이 썸 생성
												$target = imagecreatetruecolor($x, $tmp_y);
												imagecopyresampled($target, $source, 0, 0, 0, 0, $x, $tmp_y, $size[0], $size[1]);
											}
										}
									} else {
										if ($is_crop) {
											$target = imagecreatetruecolor($x, $y);
											$tmp_target = imagecreatetruecolor($x, $tmp_y);
											imagecopyresampled($tmp_target, $source, 0, 0, 0, 0, $x, $tmp_y, $size[0], $size[1]);
											imagecopy($target, $tmp_target, 0, 0, 0, 0, $x, $y);
										} else {
											$rate = $y / $size[1];
											$tmp_x = (int)($size[0] * $rate);
											$target = imagecreatetruecolor($tmp_x, $y);
											imagecopyresampled($target, $source, 0, 0, 0, 0, $tmp_x, $y, $size[0], $size[1]);
										}
									}
								}
							} else { // $height에 값이 없는 경우 (crop은 해당 사항이 없죠? ^^)
								if ($width >= $size[0]) { // 썸네일의 폭보다 $width가 더 크면, 이미지의 폭으로 썸에일을 만듭니다 (확대된 썸은 허용않음)
									$x = $size[0];
									$tmp_y = $size[1];
								} else {
									$rate = $x / $size[0];
									$tmp_y = (int)($size[1] * $rate);
								}
								$target = imagecreatetruecolor($x, $tmp_y);
								imagecopyresampled($target, $source, 0, 0, 0, 0, $x, $tmp_y, $size[0], $size[1]);
							}
						} else {	 // $width는 없고 $height만 있는 경우
							if ($height > $size[1]) {   // 썸네일의 높이보다 $height가 더 크면, 이미지의 높이로 썸네일을 만듭니다 (확대된 썸은 허용않음)
								$y = $size[1];
								$tmp_x = $size[0];
								$target = imagecreatetruecolor($tmp_x, $y);
								imagecopyresampled($target, $source, 0, 0, 0, 0, $tmp_x, $y, $size[0], $size[1]);
							} else {
								$x = $size[0];
								$y = $height;
								$tmp_y = $size[1];
								if ($is_crop) {
									$target = imagecreatetruecolor($x, $y);
									$tmp_target = imagecreatetruecolor($x, $tmp_y);
									imagecopyresampled($tmp_target, $source, 0, 0, 0, 0, $x, $tmp_y, $size[0], $size[1]);
									imagecopy($target, $tmp_target, 0, 0, 0, 0, $x, $tmp_y);
								} else {
									$rate = $y / $size[1];
									$tmp_x = (int)($size[0] * $rate);
									$target = imagecreatetruecolor($tmp_x, $y);
									imagecopyresampled($target, $source, 0, 0, 0, 0, $tmp_x, $y, $size[0], $size[1]);
								}
							}
						}

						// 이미지 퀄러티를 재조정
						ob_start();
						if ($size[2] == 1)
							imagegif($target, "", $quality);
						else if ($size[2] == 2)
							imagejpeg($target, "", $quality);
						else if ($size[2] == 3)
							imagepng($target, "", round(10 - ($quality / 10))); //imagepng의 퀄리티는 0~9까지 사용 가능합니다 (Lusia). 0(no compression) 입니다

						$tmp_image_str = ob_get_contents();
						ob_end_clean();
						$target = imagecreatefromstring($tmp_image_str);

						unset($tmp_image_str);

						// watermark 이미지 넣어주기
						if (trim($watermark) && count($watermark) > 0) {
							foreach ($watermark as $w1) {
								// 파일이름과 디렉토리를 구분
								$w1_file = $w1['filename'];
								if (!$w1_file) continue;

								$w_dir = dirname($w1_file);
								$w_file = basename($w1_file);

								$w1_file = $w_dir . "/" . $w_file;

								// 워터마크 파일이 없으면 워터마크를 찍지 않습니다
								if (!file_exists($w1_file)) break;

								// 워터마크 이미지의 width, height
								$sizew = getimagesize($w1_file);
								$wx = $sizew[0];
								$wy = $sizew[1];
								// watermark 이미지 읽어들이기
								if ($sizew[2] == 1)
									$w1_source = imagecreatefromgif($w1_file);
								else if ($sizew[2] == 2)
									$w1_source = imagecreatefromjpeg($w1_file);
								else if ($sizew[2] == 3)
									$w1_source = imagecreatefrompng($w1_file);

								// $target 이미지의 width, height
								$sx = imagesx($target);
								$sy = imagesy($target);

								switch ($w1[location]) {
									case "center" : 
										$tx = (int)($sx/2 - $wx/2) + $w1[x];
										$ty = (int)($sy/2 - $wy/2) + $w1[y];
									break;
									case "top" :
										$tx = (int)($sx/2 - $wx/2) + $w1[x];
										$ty = $w1[y];
									break;
									case "top_left" :
										$tx = $w1[x];
										$ty = $w1[y];
									break;
									case "top_right" :
										$tx = $sx - $wx - $w1[x];
										$ty = $w1[y];
									break;
									case "bottom" :
										$tx = (int)($sx/2 - $wx/2) + $w1[x];
										$ty = $sy - $w1[y] - $wy;
									break;
									case "bottom_left" :
										$tx = $w1[x];
										$ty = $sy - $w1[y] - $wy;
									break;
									case "bottom_right" : 
									default :
										$tx = $sx - $w1[x] - $wx;
										$ty = $sy - $w1[y] - $wy;
								}

								imagecopyresampled($target, $w1_source, $tx, $ty, 0, 0, $wx, $wy, $wx, $wy);

							}

						}

						// php imagefilter
						//if ($filter and $size[2] == 2) { //$size[2] == 2 , jpg만 필터 적용
						if ($filter) {
							$filter_type = $filter[type];
							switch($filter_type) {
								case  IMG_FILTER_COLORIZE : imagefilter($target, $filter_type, $filter[arg1], $filter[arg2], $filter[arg3], $filter[arg4]); break;
								case  IMG_FILTER_PIXELATE : imagefilter($target, $filter_type, $filter[arg1], $filter[arg2]); break;
								case  IMG_FILTER_BRIGHTNESS :
								case  IMG_FILTER_CONTRAST :
								case  IMG_FILTER_SMOOTH   : imagefilter($target, $filter_type, $filter[arg1]); break;
								case  IMG_FILTER_NEGATE   :
								case  IMG_FILTER_GRAYSCALE:
								case  IMG_FILTER_EDGEDETECT:
								case  IMG_FILTER_EMBOSS   :
								case  IMG_FILTER_GAUSSIAN_BLUR :
								case  IMG_FILTER_SELECTIVE_BLUR:
								case  IMG_FILTER_MEAN_REMOVAL:  imagefilter($target, $filter_type); break;
								case  99: UnsharpMask4($target, $filter[arg1], $filter[arg2], $filter[arg3]); break;
								default : ; // 필터 타입이 틀리면 아무것도 안합니다
							}
						}

						$quality=100;
						if ($size[2] == 1 || $thumb_type=="gif")
							imagegif($target, $thumb_file, 100);    // gif
						else if ($size[2] == 2 || $thumb_type=="jpg")
							imagejpeg($target, $thumb_file, 100);   // jpeg
						else if ($size[2] == 3 || $thumb_type=="png") {
							// Turn off alpha blending and set alpha flag
							imagealphablending($target, false);
							imagesavealpha($target, true);
							imagepng($target, $thumb_file, 0); //imagepng의 퀄리티는 0~9까지 사용 가능합니다 (Lusia). 0(no compression) 입니다
						} else
							imagegif($target, $thumb_file, 100);

						@chmod($thumb_file, 0606); // 추후 삭제를 위하여 파일모드 변경

						// 메모리를 부숴줍니다 - http://kr2.php.net/manual/kr/function.imagedestroy.php
						if ($target) imagedestroy($target);
						if ($source) imagedestroy($source);
						if ($tmp_target)  imagedestroy($tmp_target);


					return str_replace($real_dir, "", $thumb_file);

				}


				/*********************************************/
				/* Fonction: ImageCreateFromBMP              */
				/* Author:   DHKold                          */
				/* Contact:  admin@dhkold.com                */
				/* Date:     The 15th of June 2005           */
				/* Version:  2.0B                            */
				/*********************************************/
				function ImageCreateFromBMP($filename) {
				
						//Ouverture du fichier en mode binaire
						if (! $f1 = fopen($filename,"rb")) return FALSE;

						//echo $filename;

						//1 : Chargement des ent?tes FICHIER
						$FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));

						if ($FILE['file_type'] != 19778) return FALSE;

						//2 : Chargement des ent?tes BMP
						$BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' . '/Vcompression/Vsize_bitmap/Vhoriz_resolution' . '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
						$BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
						if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
						$BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
						$BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
						$BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
						$BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
						$BMP['decal'] = 4-(4*$BMP['decal']);
						if ($BMP['decal'] == 4) $BMP['decal'] = 0;

						//3 : Chargement des couleurs de la palette
						$PALETTE = array();
						if ($BMP['colors'] < 16777216) {
							$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
						}

						//4 : Cr?ation de l'image
						$IMG = fread($f1,$BMP['size_bitmap']);
						$VIDE = chr(0);

						$res = imagecreatetruecolor($BMP['width'],$BMP['height']);
						$P = 0;
						$Y = $BMP['height']-1;
						while ($Y >= 0) {
							$X=0;
							while ($X < $BMP['width']) {
								if ($BMP['bits_per_pixel'] == 24)
									$COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
								elseif ($BMP['bits_per_pixel'] == 16) {  
									$COLOR = unpack("v",substr($IMG,$P,2));
									$blue  = (($COLOR[1] & 0x001f) << 3) + 7;
									$green = (($COLOR[1] & 0x03e0) >> 2) + 7;
									$red   = (($COLOR[1] & 0xfc00) >> 7) + 7;
									$COLOR[1] = $red * 65536 + $green * 256 + $blue;
								} elseif ($BMP['bits_per_pixel'] == 8) {  
									$COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
									$COLOR[1] = $PALETTE[$COLOR[1]+1];
								} elseif ($BMP['bits_per_pixel'] == 4) {
									$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
									if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
									$COLOR[1] = $PALETTE[$COLOR[1]+1];
								} elseif ($BMP['bits_per_pixel'] == 1) {
									$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
									if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
									elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
									elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
									elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
									elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
									elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
									elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
									elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
									$COLOR[1] = $PALETTE[$COLOR[1]+1];
								} else
									return FALSE;

								imagesetpixel($res,$X,$Y,$COLOR[1]);

								$X++;
								$P += $BMP['bytes_per_pixel'];
							}
							$Y--;
							$P+=$BMP['decal'];
						}

						//Fermeture du fichier
						fclose($f1);


					return $res;

				}


				function createThumb_list($img_width, $img_height, $imgSource, $imgThumb) {
				
					global $get_img;

						// 이미지체크 
						if($get_img[2]==1){
							$img_org = imagecreatefromgif($imgSource);            //원본 이미지: gif
						}else if($get_img[2]==2){
							$img_org = imagecreatefromjpeg($imgSource);            //원본 이미지: jpg
						}else if($get_img[2]==3){
							$img_org = imagecreatefrompng($imgSource);            //원본 이미지: png
						}else if($get_img[2]==6){
							$img_org = ImageCreateFromBMP($imgSource);
						}else{
							continue;
						}


					$target = imagecreatetruecolor($img_width,$img_height); // 리사이징 이미지 생성
					Imagecopyresampled($img_org, $img_org, 0, 0, 0, 0, $img_width, $img_height, $get_img[0], $get_img[1]);  // 리사이징 temp 생성
					imagecopy($target, $img_org, 0, 0, 0, 0, $img_width, $img_height); // 리사이징 temp target에 복사
					imagejpeg($target,$imgThumb,100);
				}


				// $get_img 변수를 global 로 설정할수 없는 경우 사용한다
				function createThumb_lists($get_img,$img_width, $img_height, $imgSource, $imgThumb) {
				
						// 이미지체크 
						if($get_img[2]==1){
							$img_org = imagecreatefromgif($imgSource);            //원본 이미지: gif
						}else if($get_img[2]==2){
							$img_org = imagecreatefromjpeg($imgSource);            //원본 이미지: jpg
						}else if($get_img[2]==3){
							$img_org = imagecreatefrompng($imgSource);            //원본 이미지: png
						}else if($get_img[2]==6){
							$img_org = ImageCreateFromBMP($imgSource);
						}else{
							//continue;
							;
						}


					$target = imagecreatetruecolor($img_width,$img_height); // 리사이징 이미지 생성
					@Imagecopyresampled($img_org, $img_org, 0, 0, 0, 0, $img_width, $img_height, $get_img[0], $get_img[1]);  // 리사이징 temp 생성
					@imagecopy($target, $img_org, 0, 0, 0, 0, $img_width, $img_height); // 리사이징 temp target에 복사
					@imagejpeg($target,$imgThumb,100);
				}


				// 파일의 경로를 가지고 옵니다 (불당팩, /lib/common.lib.php에 정의된 함수)
				function file_path($path) {

						$dir = dirname($path);
						$file = basename($path);

						if (substr($dir,0,1) == "/") {
							$real_dir = dirname($_SERVER['DOCUMENT_ROOT'] . "/" . $alice['app'] . "/data");
							$dir = $real_dir . $dir;
						}


					return $dir . "/" . $file;
				}

				function getResizeImg( $fileName, $sizeWidth, $sizeHeight ) {

						$img_size = @getimagesize($fileName);

						$result = array();

						if ($img_size[0] > 1) {

							### 이미지중 큰 길이 쪽을 원하는 사이즈로 만든다 
							if (($img_size[0]> $sizeWidth) || ($img_size[1] > $sizeHeight)){

								if ($img_size[0]> $img_size[1]) {

									$result['width'] = $sizeWidth;
									$result['height'] = floor ($img_size[1]*($sizeWidth/$img_size[0])); 

								} else {
									
									$result['width'] = floor ($img_size[0]*($sizeHeight/$img_size[1])); 
									$result['height'] = $sizeHeight;

								}

							}
							
						} else {

							$result = false;

						}


					return $result;

				} 

				// 이름이나 별명을 감출때 사용하는 함수 :: *** 로 표시
				function make_pass_($val){

					$val= str_replace(" ", "", $val);

					if (!ctype_alnum($val)){

						if(mb_strlen($val)=="2"){

							$cnt = mb_strlen($val)-1;	
							
							$tail = "*";

						} else {

							$cnt = mb_strlen($val)-3;	
							
							$tail = "***";

						}

					} else {

						$val = substr($val,0,5);
						
						$cnt = mb_strlen($val)-3;	
						
							$tail = "***";

					}

					return mb_substr($val, 0, $cnt).$tail;
				}



				// 이름이나 별명을 감출때 사용하는 함수 :: 00 로 표시
				function make_pass_00( $val ){

						$val= str_replace(" ", "", $val);


						if (!ctype_alnum($val)){

							if( mb_strlen($val) >= 9 ){	// UTF-8 기준 3글자 이상

								$cnt = mb_strlen($val) - 6;

								$tail = "00";

							} else if( mb_strlen($val) == 6 ){	// UTF-8 기준 2글자

								$cnt = mb_strlen($val) - 3;

								$tail = "0";

							}

						} else {

							$val = substr($val,0,5);
							
							$cnt = mb_strlen($val)-3;	
							
							$tail = "000";

						}

					
					return mb_substr($val, 0, $cnt).$tail;

				}


				// 이름이나 별명을 감출때 사용하는 함수 :: ○○ 로 표시
				function make_pass_○○( $val ){

						$val= str_replace(" ", "", $val);


						if (!ctype_alnum($val)){

							if( mb_strlen($val) >= 9 ){	// UTF-8 기준 3글자 이상

								$cnt = mb_strlen($val) - 6;

								$tail = "○○";

							} else if( mb_strlen($val) == 6 ){	// UTF-8 기준 2글자

								$cnt = mb_strlen($val) - 3;

								$tail = "○○";

							}

						} else {

							$val = substr($val,0,5);
							
							$cnt = mb_strlen($val)-3;	
							
							$tail = "○○○";

						}

					
					return mb_substr($val, 0, $cnt).$tail;

				}


				//문자열 자르는 함수
				function str_cut($str, $len, $suffix="…") { // 문자열 끊기 (이상의 길이일때는 ... 로 표시)

					global $alice;

						if (strtoupper($alice['charset']) == 'UTF-8') {

							$c = substr(str_pad(decbin(ord($str{$len})),8,'0',STR_PAD_LEFT),0,2); 

							if ($c == '10') 
								for (;$c != '11' && $c{0} == 1;$c = substr(str_pad(decbin(ord($str{--$len})),8,'0',STR_PAD_LEFT),0,2)); 

							return substr($str,0,$len) . (strlen($str)-strlen($suffix) >= $len ? $suffix : ''); 

						} else {

							$s = substr($str, 0, $len);
							$cnt = 0;

							for ($i=0; $i<strlen($s); $i++)
								if (ord($s[$i]) > 127)
									$cnt++;

							$s = substr($s, 0, $len - ($cnt % 2));
							
							if (strlen($s) >= strlen($str))
								$suffix = "";

							return $s . $suffix;
						}

				}


				/**
				 * @brief 주어진 문자를 주어진 크기로 자르고 잘라졌을 경우 주어진 꼬리를 담
				 * @param string 자를 원 문자열
				 * @param cut_size 주어진 원 문자열을 자를 크기
				 * @param tail 잘라졌을 경우 문자열의 제일 뒤에 붙을 꼬리
				 * @return string
				 * @XE 발췌
				 **/
				function cut_str($string,$cut_size=0,$tail = '...') {

						if($cut_size<1 || !$string) return $string;

						$chars = Array(12, 4, 3, 5, 7, 7, 11, 8, 4, 5, 5, 6, 6, 4, 6, 4, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 4, 4, 8, 6, 8, 6, 10, 8, 8, 9, 8, 8, 7, 9, 8, 3, 6, 7, 7, 11, 8, 9, 8, 9, 8, 8, 7, 8, 8, 10, 8, 8, 8, 6, 11, 6, 6, 6, 4, 7, 7, 7, 7, 7, 3, 7, 7, 3, 3, 6, 3, 9, 7, 7, 7, 7, 4, 7, 3, 7, 6, 10, 6, 6, 7, 6, 6, 6, 9);
						$max_width = $cut_size*$chars[0]/2;
						$char_width = 0;

						$string_length = strlen($string);
						$char_count = 0;

						$idx = 0;
						while($idx < $string_length && $char_count < $cut_size && $char_width <= $max_width) {
							$c = ord(substr($string, $idx,1));
							$char_count++;
							if($c<128) {
								$char_width += (int)$chars[$c-32];
								$idx++;
							}
							else if (191<$c && $c < 224) {
									  $char_width += $chars[4];
									  $idx += 2;
								}
							else {
								$char_width += $chars[0];
								$idx += 3;
							}
						}

						$output = substr($string,0,$idx);
						if(strlen($output)<$string_length) $output .= $tail;


					return $output;

				}


				// 문자열에 utf8 문자가 들어 있는지 검사하는 함수
				// 코드 : http://in2.php.net/manual/en/function.mb-check-encoding.php#95289
				function is_utf8($str) { 

						$len = strlen($str); 

						for($i = 0; $i < $len; $i++) {

							$c = ord($str[$i]); 

							if ($c > 128) { 

								if (($c > 247)) return false; 

								elseif ($c > 239) $bytes = 4; 

								elseif ($c > 223) $bytes = 3; 

								elseif ($c > 191) $bytes = 2; 

								else return false; 

								if (($i + $bytes) > $len) return false; 

								while ($bytes > 1) {
									$i++; 
									$b = ord($str[$i]); 
									if ($b < 128 || $b > 191) return false; 
									$bytes--; 
								}
							}
						}


					return true;

				}


				// 파일 최대 업로드 용량 체크 :: 파일 업로드시 사용
				// 절대경로로 체크하면 된다.
				function file_upload_max( $filename ){

						//echo ini_get('post_max_size')." <=<br/>";
						$server_max_size = ini_get('upload_max_filesize');		// 10M 요런 형태
						$upload_max_size = intval(substr(ini_get('upload_max_filesize'),0,-1)) * 1024 * 1024;		// byte 환산

						// 업로드할 파일 용량이 최대 용량을 넘을경우
						if($filename['size'] > $upload_max_size) {

							$this->popup_msg_ajax("파일 업로드 최대 용량을 넘어섰습니다.");

							$result = false;

						} else {

							$result = true;

						}


					return $result;

				}


				// iconv 함수를 그냥 사용해도 되지만, 가끔 작동하지 않거나 오류인 경우 체크를 해준다.
				function convert_charset( $from_charset, $to_charset, $str ) {

						if( function_exists('iconv') ){

							return iconv($from_charset, $to_charset, $str);

						} else if( function_exists('mb_convert_encoding') ) {

							return mb_convert_encoding($str, $to_charset, $from_charset);

						} else {

							die("Not found 'iconv' or 'mbstring' library in server.");

						}

				}


				// 문자열이 한글, 영문, 숫자, 특수문자로 구성되어 있는지 검사
				function check_string($str, $options) {

					global $alice;

						$s = '';
						for($i=0;$i<strlen($str);$i++) {
							$c = $str[$i];
							$oc = ord($c);

							// 한글
							if ($oc >= 0xA0 && $oc <= 0xFF) {	// 0xA0 => 160, 0xFF => 255
								if ($alice['charset'] == 'utf-8') {
									if ($options & _ALICE_HANGUL_) {
										$s .= $c . $str[$i+1] . $str[$i+2];
									}
									$i+=2;
								} else {
									// 한글은 2바이트 이므로 문자하나를 건너뜀
									$i++;
									if ($options & _ALICE_HANGUL_) {
										$s .= $c . $str[$i];
									}
								}
							}
							// 숫자
							else if ($oc >= 0x30 && $oc <= 0x39) {
								if ($options & _ALICE_NUMERIC_) {
									$s .= $c;
								}
							}
							// 영대문자
							else if ($oc >= 0x41 && $oc <= 0x5A) {
								if (($options & _ALICE_ALPHABETIC_) || ($options & _ALICE_ALPHAUPPER_)) {
									$s .= $c;
								}
							}
							// 영소문자
							else if ($oc >= 0x61 && $oc <= 0x7A) {
								if (($options & _ALICE_ALPHABETIC_) || ($options & _ALICE_ALPHALOWER_)) {
									$s .= $c;
								}
							}
							// 공백
							else if ($oc >= 0x20) {
								if ($options & _ALICE_SPACE_) {
									$s .= $c;
								}
							}
							else {
								if ($options & _ALICE_SPECIAL_) {
									$s .= $c;
								}
							}
						}


					// 넘어온 값과 비교하여 같으면 참, 틀리면 거짓
					return ($str == $s);

				}


				// 휴대폰번호 정규식 체크
				function check_phone($p1, $p2, $p3){

						if(empty($p1) || empty($p2) || empty($p3)) return false;

						$phone = $p1.'-'.$p2.'-'.$p3;

						$pattern = "/^([0]{1}[0-9]{1,2})-([1-9]{1}[0-9]{2,3})-([0-9]{4})$/";
						
					return preg_match($pattern, $phone);

				}


				// 전화,휴대폰 번호 '-' 빼기 :: 정규식
				function phone_mdash( $num ){

						$phone = preg_replace('/[^\d]/','',$num);

					return $phone;

				}


				// 전화,휴대폰 번호 '-' 넣기
				function phone_pdash( $num ){

						$_tmp = str_replace('-','', $num);

						if( !is_numeric($_tmp) ) // 전화번호로 입력받은 값이 숫자로된건지 확인
							return false;

						$num_len = strlen($_tmp); // 전화번호의 길이를 파악

						$_num = $_tmp[0] . $_tmp[1] . $_tmp[2];

						if( $num_len == 10 ) {
							//$_num=='010' || $_num=='011' || $_num=='016' || $_num=='017' || $_num=='018' || $_num=='019'

							$number =$_tmp[0].$_tmp[1].$_tmp[2] . "-" . $_tmp[3].$_tmp[4].$_tmp[5] . "-" . $_tmp[6].$_tmp[7].$_tmp[8].$_tmp[9];

						} else if( $num_len == 11 ) {

							$number =$_tmp[0].$_tmp[1].$_tmp[2] . "-" . $_tmp[3].$_tmp[4].$_tmp[5].$_tmp[6] . "-" . $_tmp[7].$_tmp[8].$_tmp[9].$_tmp[10];

						}
						

					return $number;

				}


				// 작업 시간을 확인하기 위한 함수
				// 속도 측정시 이용.
				function get_time() {

						list($usec, $sec) = explode(" ", microtime());

					return ((float)$usec + (float)$sec);

				}


				// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL
				function get_paging($write_pages, $cur_page, $total_page, $url, $add="") {

						$str = "";
						if ($cur_page > 1) {
							$str .= "<a href='" . $url . "1" . $add . "'>처음</a>";
							//$str .= "[<a href='" . $url . ($cur_page-1) . "'>이전</a>]";
						}

						$start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
						$end_page = $start_page + $write_pages - 1;

						if ($end_page >= $total_page) $end_page = $total_page;

						if ($start_page > 1) $str .= " &nbsp;<a href='" . $url . ($start_page-1) . $add . "'>이전</a>";

						if ($total_page > 1) {
							for ($k=$start_page;$k<=$end_page;$k++) {
								if ($cur_page != $k)
									$str .= " &nbsp;<a href='" . $url . $k . $add . "'>" . $k . "</a>";
								else
									$str .= " &nbsp;<span class='col'>" . $k . "</span> ";
							}
						}

						if ($total_page > $end_page) $str .= " &nbsp;<a href='" . $url . ($end_page+1) . $add . "'>다음</a>";

						if ($cur_page < $total_page) {
							$str .= " &nbsp;<a href='" . $url . $total_page . $add . "'>맨끝</a>";
						}

						$str .= "";


					return $str;

				}


				// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL :: 사용자측
				function user_get_paging($write_pages, $cur_page, $total_page, $url, $add="") {

						$str = "";
						if ($cur_page > 1) {
							$str .= "<a href='" . $url . "1" . $add . "' class='prev'>처음</a>";
							//$str .= "[<a href='" . $url . ($cur_page-1) . "'>이전</a>]";
						}

						$start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
						$end_page = $start_page + $write_pages - 1;

						if ($end_page >= $total_page) $end_page = $total_page;

						if ($start_page > 1) $str .= "<a href='" . $url . ($start_page-1) . $add . "' class='prev'>이전</a>";

						if ($total_page > 1) {
							for ($k=$start_page;$k<=$end_page;$k++) {
								if ($cur_page != $k)
									$str .= "<a href='" . $url . $k . $add . "' class='page'>" . $k . "</a>";
								else
									//$str .= " &nbsp;<span class='col'>" . $k . "</span> ";
									$str .= "<a href='" . $url . $k . $add . "' class='page now'>" . $k . "</a>";
							}
						}

						if ($total_page > $end_page) $str .= "<a href='" . $url . ($end_page+1) . $add . "' class='next'>다음</a>";

						if ($cur_page < $total_page) {
							$str .= "<a href='" . $url . $total_page . $add . "' class='next'>맨끝</a>";
						}

						$str .= "";


					return $str;

				}


				// 스킨경로를 얻는다
				// 사용예 :: $get_themes = $utility->get_skin_dir( $alice['theme_path'] . '/'  );
				function get_skin_dir( $dirname, $len="" ){

						$result_array = array();

						$handle = opendir($dirname);
						
						while ($file = readdir($handle)) {

							if($file == "."||$file == "..") continue;

							if (is_dir($dirname.$file)) $result_array[] = $file;

						}

						closedir($handle);

						sort($result_array);


					return $result_array;

				}


				// 접속자 정보
				function get_user_agent(){

					/*
						ie :: Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; BTRS123387; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; InfoPath.2)
						ff :: Mozilla/5.0 (Windows NT 5.1; rv:13.0) Gecko/20100101 Firefox/13.0.1
						chrome :: Mozilla/5.0 (Windows NT 5.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11
						safari :: Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2
						opera :: Opera/9.80 (Windows NT 5.1; U; ko) Presto/2.10.229 Version/11.6
					*/
						$result = array();
						$user_agent = $_SERVER['HTTP_USER_AGENT'];

						/* 브라우저 확인 */
							if( preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent) ) {		// 망할 ie 일때

								$result['browser'] = 'ie';

								// IE 버전별 체크
								if( preg_match('/MSIE 5.0/i', $user_agent) ){
									$result['browser'] .= " ie5";
								} else if( preg_match('/MSIE 6.0/i', $user_agent) ){
									$result['browser'] .= " ie6";
								} else if( preg_match('/MSIE 7.0/i', $user_agent) ){
									$result['browser'] .= " ie7";
								} else if( preg_match('/MSIE 8.0/i', $user_agent) ){
									$result['browser'] .= " ie8";
								} else if( preg_match('/MSIE 9.0/i', $user_agent) ){
									$result['browser'] .= " ie9";
								} else if( preg_match('/MSIE 10.0/i', $user_agent) ){
									$result['browser'] .= " ie10";
								}
								
								$ub = "MSIE";

							} else if( preg_match('/Firefox/i',$user_agent) ){		// FF

								$result['browser'] = "gecko";
								$ub = "Firefox";

							} else if( preg_match('/Chrome/i',$user_agent) ){		// Chrome

								$result['browser'] = "webkit safari chrome";
								$ub = "Chrome";

							} else if( preg_match('/Safari/i',$user_agent) ){		// Safari


								$result['browser'] = "webkit safari";
								$ub = "Safari";
								
								$known = array('Version', $ub, 'other');
								$pattern = '#(?<browser>' . join('|', $known) .
								')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
								if (!preg_match_all($pattern, $user_agent, $matches)) {
									// we have no matching number just continue
								}

								$i = count($matches['browser']);
								if ($i != 1) {
									if (strripos($user_agent,"Version") < strripos($user_agent,$ub)){
										$version= $matches['version'][0];
									} else {
										$version= $matches['version'][1];
									}
								} else {
									$version= $matches['version'][0];
								}

								$result['browser'] .= " safari" . floor($version);


							} else if( preg_match('/Opera/i',$user_agent) ){		// Opera
								
								$result['browser'] = "opera";
								$ub = "Opera";

								$known = array('Version', $ub, 'other');
								$pattern = '#(?<browser>' . join('|', $known) .
								')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
								if (!preg_match_all($pattern, $user_agent, $matches)) {
									// we have no matching number just continue
								}

								$i = count($matches['browser']);
								if ($i != 1) {
									if (strripos($user_agent,"Version") < strripos($user_agent,$ub)){
										$version= $matches['version'][0];
									} else {
										$version= $matches['version'][1];
									}
								} else {
									$version= $matches['version'][0];
								}

								$result['browser'] .= " opera" . floor($version);

							} else if( preg_match('/Netscape/i',$user_agent) ){		// Netscape

								$result['browser'] = "netscape";
								$ub = "Netscape";

								$known = array('Version', $ub, 'other');
								$pattern = '#(?<browser>' . join('|', $known) .
								')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
								if (!preg_match_all($pattern, $user_agent, $matches)) {
									// we have no matching number just continue
								}

								$i = count($matches['browser']);
								if ($i != 1) {
									if (strripos($user_agent,"Version") < strripos($user_agent,$ub)){
										$version= $matches['version'][0];
									} else {
										$version= $matches['version'][1];
									}
								} else {
									$version= $matches['version'][0];
								}

								$result['browser'] .= " netscape" . floor($version);

							}
						/* //브라우저 확인 */

						/* OS 확인 */
							//$result['os'] = $this->get_os($user_agent);
							if (preg_match('/linux/i', $user_agent)) {
								$result['os'] = 'linux';
							} elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
								$result['os'] = 'mac';
							} elseif (preg_match('/windows|win32/i', $user_agent)) {
								$result['os'] = 'win';
							}
						/* //OS 확인 */

						$result['language'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);		// 국가 확인


					return implode(" ",$result);

				}


				// 단순 브라우저 확인
				function user_agent(){

					$user_agent = $_SERVER['HTTP_USER_AGENT'];

						if( preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent) )		// 망할 ie 일때
							$result = "IE";
						else if( preg_match('/Firefox/i',$user_agent) )		// FF
							$result = "FF";
						else if( preg_match('/Chrome/i',$user_agent) )		// Chrome
							$result = "Chrome";
						else if( preg_match('/Safari/i',$user_agent) )		// Safari
							$result = "Safari";
						else if( preg_match('/Opera/i',$user_agent) )		// Opera
							$result = "Opera";
						else if( preg_match('/Netscape/i',$user_agent) )		// Netscape
							$result = "Netscape";


					return $result;

				}


				// IE 브라우저 버전 체크
				function _IE_Vercheck(){

					$user_agent = $_SERVER['HTTP_USER_AGENT'];

					/* 브라우저 확인 */
						if( preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent) ) {		// 망할 ie 일때

							// IE 버전별 체크
							if( preg_match('/MSIE 5.0/i', $user_agent) ){
								$result = "5";
							} else if( preg_match('/MSIE 6.0/i', $user_agent) ){
								$result = 6;
							} else if( preg_match('/MSIE 7.0/i', $user_agent) ){
								$result = 7;
							} else if( preg_match('/MSIE 8.0/i', $user_agent) ){
								$result = 8;
							} else if( preg_match('/MSIE 9.0/i', $user_agent) ){
								$result = 9;
							}

						} else {

							$result = false;	// ie 가 아닌 경우 false

						}

					
					return $result;

				}


				// 브라우저별 나눔고딕 font style
				function _fontStyle( $user_agent ){

					global $alice;

						$result = "<style>@font-face { ";

						if( preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent) ) {		// 망할 ie 일때

							$result .= "font-family: 'NanumGothic'; src: url('".$alice['helper_css_path']."/fonts/NanumGothic.eot');\n";

						} else {	 // 비 IE

							$result .= "font-family: 'NanumGothic'; font-style: normal; font-weight: normal; src: local('NanumGothic'), local('나눔고딕'),";
							
							if( preg_match('/Firefox/i',$user_agent) || preg_match('/Chrome/i',$user_agent) ){		// FF & Chrome

								$result .= " url('".$alice['helper_css_path']."/fonts/NanumGothic.woff') format('woff');\n";

							} else if( preg_match('/Safari/i',$user_agent) || preg_match('/Opera/i',$user_agent) ){	//  Safari & Opera

								$result .= " url('".$alice['helper_css_path']."/fonts/NanumGothic.ttf') format('truetype');\n";

							}

						}

						$result .= " }</style>";


					return $result;

				}



				// OS 를 알아내자
				// 그누보드 참고
				function get_os($agent) { 

					$agent = strtolower($agent); 

					//echo $agent; echo "<br/>"; 

						if (preg_match("/windows 98/", $agent))                { $result = "98"; } 
						else if(preg_match("/iphone/", $agent))                { $result = "iPhone"; } //iPhone 
						else if(preg_match("/ipad/", $agent))                  { $result = "iPad"; } //iPad 
						else if(preg_match("/ipod/", $agent))                  { $result = "iPod"; } //iPod 
						else if(preg_match("/android/", $agent))                { $result = "Android"; } //Android 
						else if(preg_match("/psp/", $agent))                    { $result = "PSP"; } //PSP 
						else if(preg_match("/playstation/", $agent))            { $result = "PLAYSTATION"; } //PLAYSTATION 
						else if(preg_match("/berry/", $agent))                  { $result = "BlackBerry"; } //BlackBerry 
						else if(preg_match("/symbian/", $agent))                { $result = "Symbian"; } //Symbian 
						else if(preg_match("/ericsson/", $agent))              { $result = "SonyEricsson"; } //SonyEricsson 
						else if(preg_match("/nokia/", $agent))                  { $result = "Nokia"; } //Nokia 
						else if(preg_match("/benq/", $agent))                  { $result = "BenQ"; } //BenQ 
						else if(preg_match("/mot/", $agent))                    { $result = "Motorola"; } //Motorola 
						else if(preg_match("/nintendo/", $agent))              { $result = "Nintendo"; } //Nintendo 
						else if(preg_match("/palm/", $agent))                  { $result = "Palm"; } //Palm 
						else if(preg_match("/sch/", $agent))                    { $result = "T*옴니아"; } //T*옴니아 
						else if(preg_match("/sph/", $agent))                    { $result = "애니콜"; } //삼성폰 
						else if(preg_match("/sgh/", $agent))                    { $result = "옴니아"; } //옴니아 
						else if(preg_match("/sch/", $agent))                    { $result = "T*옴니아"; } //T*옴니아 
						else if(preg_match("/im-s/", $agent))                  { $result = "스카이폰"; } //스카이폰 
						else if(preg_match("/lg/", $agent))                    { $result = "LG 사이언"; } //LG 사이언 
						else if(preg_match("/googleproducer|google web preview/", $agent))            { $result = "Google Web Preview"; } //Google Web Preview and Feedfetcher 
						else if(preg_match("/google-site-verification/", $agent))  { $result = "Google Webmaster tools"; } //Google Webmaster tools 
						else if(preg_match("/feedfetcher-google/", $agent))        { $result = "Feedfetcher-Google"; } //Feedfetcher-Google 
						else if(preg_match("/desktop google reader/", $agent))      { $result = "Desktop Google Reader"; } //Desktop Google Reader 
						else if(preg_match("/appengine-google/", $agent))          { $result = "AppEngine-Google"; } //AppEngine-Google 
						else if(preg_match("/google wireless transcoder/", $agent)) { $result = "Google Wireless Transcoder"; } //Google Wireless Transcoder 
						else if(preg_match("/google/", $agent))            { $result = "Google Robot"; } //구글로봇 
						else if(preg_match("/mediapartners/", $agent))      { $result = "Google AdSense"; } //구글애드센스 
						else if(preg_match("/-mobile/", $agent))            { $result = "Google-Mobile Robot"; } //구글모바일로봇 
						else if(preg_match("/naver blog/", $agent))        { $result = "NAVER Blog Rssbot"; } //네이버블로그로봇 
						else if(preg_match("/naver|yeti/", $agent))        { $result = "NAVER Robot"; } //네이버로봇 
						else if(preg_match("/daumsearch/", $agent))        { $result = "DaumSearch validator"; } //다음검색 검사기 
						else if(preg_match("/daum/", $agent))              { $result = "DAUM Robot"; } //다음로봇 
						else if(preg_match("/yahooysmcm/", $agent))        { $result = "YahooYSMcm"; } //야후!문맥광고 
						else if(preg_match("/yahoocachesystem/", $agent))  { $result = "YahooCacheSystem"; } //야후!캐싱시스템 
						else if(preg_match("/yahoo/", $agent))              { $result = "Yahoo! Robot"; } //야후!로봇 
						else if(preg_match("/natefeedfetcher/", $agent))    { $result = "NATEFeed Fetcher"; } //네이트FeedFetcher 
						else if(preg_match("/egloosfeedfetcher/", $agent))  { $result = "Egloos FeedFetcher"; } //이글루스FeedFetcher 
						else if(preg_match("/empas|nate/", $agent))        { $result = "NATE Robot"; } //네이트로봇 
						else if(preg_match("/bingpreview/", $agent))        { $result = "BingPreview"; } //BingPreview로봇 
						else if(preg_match("/bing/", $agent))              { $result = "Bing Robot"; } //Bing로봇 
						else if(preg_match("/msn/", $agent))                { $result = "MSN Robot"; } //MSN로봇 
						else if(preg_match("/zum/", $agent))                { $result = "Zum Robot"; } //Zum로봇 
						else if(preg_match("/qrobot/", $agent))            { $result = "Qrobot"; } //Qrobot로봇 
						else if(preg_match("/archive|ia_archiver/", $agent)){ $result = "Archive Robot"; } //아카이브로봇 
						else if(preg_match("/twitter/", $agent))            { $result = "Twitter Robot"; } //Twitter로봇 
						else if(preg_match("/facebook/", $agent))          { $result = "Facebook Robot"; } //Facebook로봇 
						else if(preg_match("/whois/", $agent))              { $result = "Whois Search Robot"; } //Whois Search로봇 
						else if(preg_match("/checkprivacy/", $agent))      { $result = "KISA"; } //한국인터넷진흥원 
						else if(preg_match("/mj12/", $agent))              { $result = "MJ12bot"; } //MJ12bot 
						else if(preg_match("/baidu/", $agent))              { $result = "Baiduspider"; } //Baiduspider 
						else if(preg_match("/yandex/", $agent))            { $result = "YandexBot"; } //YandexBot로봇 
						else if(preg_match("/Sogou/", $agent))              { $result = "Sogou web spider"; } //Sogou로봇 
						else if(preg_match("/tweetedtimes/", $agent))      { $result = "TweetedTimes Bot"; } //TweetedTimes Bot 
						else if(preg_match("/discobot/", $agent))          { $result = "Discoveryengine Robot"; } //Discoveryengine로봇 
						else if(preg_match("/twiceler/", $agent))          { $result = "Twiceler Robot"; } //Twiceler로봇 
						else if(preg_match("/ezooms/", $agent))            { $result = "Ezooms Robot"; } //Ezooms로봇 
						else if(preg_match("/wbsearch/", $agent))          { $result = "WBSearchBot"; } //WBSearchBot 
						else if(preg_match("/proximic/", $agent))          { $result = "proximic"; } //proximic로봇 
						else if(preg_match("/GTWek/", $agent))              { $result = "GTWek"; } //GTWek로봇 
						else if(preg_match("/java|python|axel|dalvik|greatnews|hmschnl|huawei|jakarta|netcraft|parrotsite|readability|unwind|pagepeeker|shunix|crystalsemantics|turnitin|komodia|siteIntel|apercite/", $agent))          { $result = "Unknown Robot"; } //Unknown로봇 
						else if(preg_match("/cron/", $agent))              { $result = "WebCron"; } //WebCron 
						else if(preg_match("/capture/", $agent))            { $result = "WebCapture"; } //WebCapture로봇 
						else if(preg_match("/w3c/", $agent))                { $result = "W3C Validator"; } //W3C Validator 
						else if(preg_match("/wget/", $agent))              { $result = "Wget Validator"; } //Wget 
						else if(preg_match("/fetcher/", $agent))            { $result = "Feed Fetcher"; } //Feed Fetcher 
						else if(preg_match("/feed|reader|rss/", $agent))    { $result = "Feed Reader"; } //Feed Reader 
						else if(preg_match("/bot|slurp|scrap|spider|crawl|curl/", $agent))          { $result = "Robot"; } 
						else if(preg_match("/docomo/", $agent))                { $result = "DoCoMo"; } //DoCoMo 
						else if(preg_match("/windows 95/", $agent))            { $result = "Windows 95"; } 
						else if(preg_match("/windows nt 4\.[0-9]*/", $agent))  { $result = "Windows NT"; } 
						else if(preg_match("/windows nt 5\.0/", $agent))        { $result = "Windows 2000"; } 
						else if(preg_match("/windows nt 5\.1/", $agent))        { $result = "Windows XP"; } 
						else if(preg_match("/windows nt 5\.2/", $agent))        { $result = "Windows 2003"; } 
						else if(preg_match("/windows nt 6\.0/", $agent))        { $result = "Windows Vista"; } 
						else if(preg_match("/windows nt 6\.1/", $agent))        { $result = "Windows 7"; } 
						else if(preg_match("/windows nt 6\.2/", $agent))        { $result = "Windows 8"; } 
						else if(preg_match("/windows 9x/", $agent))            { $result = "Windows ME"; } 
						else if(preg_match("/windows ce/", $agent))            { $result = "Windows CE"; } 
						else if(preg_match("/linux/", $agent))                  { $result = "Linux"; } 
						else if(preg_match("/sunos/", $agent))                  { $result = "sunOS"; } 
						else if(preg_match("/irix/", $agent))                  { $result = "IRIX"; } 
						else if(preg_match("/phone|skt|lge|0450/", $agent))    { $result = "Mobile"; } 
						else if(preg_match("/internet explorer/", $agent))      { $result = "IE"; } 
						else if(preg_match("/mozilla/", $agent))                { $result = "Mozilla"; } 
						else if(preg_match("/macintosh/", $agent))              { $result = "Mac"; } 
						else { $result = "기타"; } 


					return $result; 

				}


				// 브라우저를 알아내자
				// 그누보드 참고
				// 통계시 사용
				function get_brow($agent) {

						$agent = strtolower($agent);

						if (preg_match("/msie 5.0[0-9]*/", $agent))				{ $result = "MSIE 5.0"; }
						else if(preg_match("/msie 5.5[0-9]*/", $agent))		{ $result = "MSIE 5.5"; }
						else if(preg_match("/msie 6.0[0-9]*/", $agent))		{ $result = "MSIE 6.0"; }
						else if(preg_match("/msie 7.0[0-9]*/", $agent))		{ $result = "MSIE 7.0"; }
						else if(preg_match("/msie 8.0[0-9]*/", $agent))		{ $result = "MSIE 8.0"; }
						else if(preg_match("/msie 9.0[0-9]*/", $agent))		{ $result = "MSIE 9.0"; }
						else if(preg_match("/msie 10.0[0-9]*/", $agent))		{ $result = "MSIE 10"; }
						else if(preg_match("/rv:11.0/", $agent))					{ $result = "MSIE 11"; }
						else if(preg_match("/msie 4.[0-9]*/", $agent))			{ $result = "MSIE 4.x"; }
						//else if(preg_match("/Edge*/", $agent))						{ $result = "Edge"; }
						else if(stristr($agent,'Edge'))									{ $result = "Edge"; }
						else if(preg_match("/firefox/", $agent))					{ $result = "FireFox"; }
						else if(preg_match("/chrome/", $agent))					{ $result = "Chrome"; }
						else if(preg_match("/x11/", $agent))						{ $result = "Netscape"; }
						else if(preg_match("/opera/", $agent))						{ $result = "Opera"; }
						else if(preg_match("/safari/", $agent))						{ $result = "Safari"; }
						else if(preg_match("/gec/", $agent))						{ $result = "Gecko"; }
						else if(preg_match("/bot|slurp/", $agent))				{ $result = "Robot"; }
						else if(preg_match("/internet explorer/", $agent))		{ $result = "IE"; }
						else if(preg_match("/mozilla/", $agent))					{ $result = "Mozilla"; }
						else { $result = "기타"; }


					return $result;
				}


				// 세션변수 생성
				function set_session( $session_name, $value ){

					if (PHP_VERSION < '5.3.0')
						session_register($session_name);

					// PHP 버전별 차이를 없애기 위한 방법
					$$session_name = $_SESSION["$session_name"] = $value;

				}


				// 파일 다운로드
				function make_downloads( $filepath, $original ){

						if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
							header("content-type: doesn/matter");
							header("content-length: ".filesize("$filepath"));
							header("content-disposition: attachment; filename=\"$original\"");
							header("content-transfer-encoding: binary");
						} else {
							header("content-type: file/unknown");
							header("content-length: ".filesize("$filepath"));
							header("content-disposition: attachment; filename=\"$original\"");
							header("content-description: php generated data");
						}
						header("pragma: no-cache");
						header("expires: 0");
						flush();

						$fp = fopen("$filepath", "rb");

						$download_rate = 10;

						while(!feof($fp)) {
							print fread($fp, round($download_rate * 1024));
							flush();
							usleep(1000);
						}
						fclose ($fp);
						flush();
				}


				// 파일 업로드
				function file_upload( $tmp_file, $filename, $dest_path, $files){

					global $alice, $chars_array;
						
						// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
						$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

						shuffle($chars_array);

						$shuffle = implode("", $chars_array);

						$upload_file = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));

						//$dest_file = $alice['peg_path'] . "/" . $upload_file;
						$dest_file = $dest_path . "/" . $upload_file;

						// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
						$error_code = move_uploaded_file($tmp_file, $dest_file) or die('파일 업로드 중 오류가 발생하였습니다.');

						// 올라간 파일의 퍼미션을 변경합니다.
						chmod($dest_file, 0606);

					
					// upload_file :: 파일명, dest_file :: 파일경로/파일명
					return array( 'upload_file' => $upload_file, 'dest_file' => $dest_file );

				}


				/**
				* Cheditor 호출
				*
				* cheditor 를 사용하기 위해 상단에서 call 을 한다
				*/
				function call_cheditor( $id, $width='100%', $height='250' ){

					global $alice;

						$result = "
							<script type='text/javascript'>
							var ed_".$id." = new cheditor('ed_".$id."');
							ed_".$id.".config.editorHeight = '".$height."';
							ed_".$id.".config.editorWidth = '".$width."';
							ed_".$id.".inputForm = 'tx_".$id."';
							</script>";

					
					return $result;

				}

		
				/**
				* 호출된 Cheditor 를 직접 사용하기 위한 textarea 를 생성한다.
				* 그리고 run 함수를 통한 에디터 작동
				*/
				function make_cheditor( $id, $content='' ){

					global $alice;

						$result = "
							<textarea name='".$id."' id='tx_".$id."' style='display:none;'>" . stripslashes($content) . "</textarea>
							<script type='text/javascript'>
							ed_".$id.".run();
							</script>";
					

					return $result;

				}


				/**
				* Cheditor 를 통한 textarea 생성 후 해당 내용을 적용한다.
				* 
				*/
				function input_cheditor( $id ){

						$result = "document.getElementById('tx_".$id."').value = ed_".$id.".outputBodyHTML();";


					return $result;

				}


				// colourPicker
				function gwsc( $color='' ) {
					$cs = array('00', '33', '66', '99', 'CC', 'FF');

					$color_arr = array();

					for($i=0; $i<6; $i++) {
						for($j=0; $j<6; $j++) {
							for($k=0; $k<6; $k++) {
								$c = $cs[$i] .$cs[$j] .$cs[$k];
								array_push($color_arr,$c);
							}
						}
					}
					
					$color_arr_cnt = count($color_arr);

					if(@in_array($color,$color_arr)){

						for($i=0;$i<$color_arr_cnt;$i++){
							$selected = ($color_arr[$i] == $color) ? 'selected' : '';
							echo "<option value='".$color_arr[$i]."' ".$selected.">".$color_arr[$i]."</option>";
						}

					} else {	 // 배열 안에 없다면 현재 color 값을 추가한다.

						array_push($color_arr,$color);
						$color_arr_cnt = count($color_arr);
						for($i=0;$i<$color_arr_cnt;$i++){
							$selected = ($color_arr[$i] == $color) ? 'selected' : '';
							echo "<option value='".$color_arr[$i]."' ".$selected.">".$color_arr[$i]."</option>";
						}

					}

				}


				// 쿠키변수 생성
				function set_cookie( $cookie_name, $value, $expire ){

					global $alice;

					setcookie(md5($cookie_name), base64_encode($value), $alice['server_time'] + $expire, '/', $alice['cookie_domain']);
					
				}

				
				// 쿠키변수값 얻음
				function get_cookie( $cookie_name ) {
					
					return base64_decode($_COOKIE[md5($cookie_name)]);

				}


				function is_hangul( $str ) {

						// 특정 문자가 한글의 범위내(0xA1A1 - 0xFEFE)에 있는지 검사
						for($i = 0; $i < strlen($str); $i++) {
							$char = ord($str[$i]);
							if($char >= 0xa1 && $char <= 0xfe)
								return true;
						}

					return false;

				}


				// TEXT 형식으로 변환
				// 그누보드 발췌
				function get_text( $str, $html=0 ) {

						// 3.31
						// TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
						if ($html == 0) {
							$str = $this->html_symbol($str);
						}

						$source[] = "/</";
						$target[] = "&lt;";
						$source[] = "/>/";
						$target[] = "&gt;";
						//$source[] = "/\"/";
						//$target[] = "&#034;";
						$source[] = "/\'/";
						$target[] = "&#039;";
						//$source[] = "/}/"; $target[] = "&#125;";
						if ($html) {
							$source[] = "/\n/";
							$target[] = "<br/>";
						}
						
						if ($html){

							$source[] = "/\n/";

							$target[] = "<br/>";

						}

					
					return preg_replace($source, $target, $str);

				}


				// HTML SYMBOL 변환
				// &nbsp; &amp; &middot; 등을 정상으로 출력
				// 그누보드 발췌
				function html_symbol( $str ) {

					return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);

				}


				// text field quoted 제거
				function remove_quoted( $str ){
					
					return preg_replace("/\"/", "&#034;", $this->get_text(stripslashes($str)));
				}


				// url 정보 알아내는 정규식
				function getUrlExp( $url ){

						//$regExp = "^([a-z://]*[^/?]*)([^$]*)";	// 정규식
						$regExp = "@^([a-z://]*[^/?]*)([^$]*)@i";

						preg_match($regExp, $url, $result);

						//$result[1] = $this->set_http($result[1]);
					
					return $result;

				}


				// url 디렉토리
				function getUrlDir( $url ){

						$getUrl = explode('/',$url);
						$getUrl_cnt = count($getUrl);

						if($getUrl_cnt > 1){

							$urls = "";
							for($i=1;$i<=$getUrl_cnt;$i++){
								if($getUrl_cnt != $i){
									$urls .= $getUrl[$i-1] . "/";
								}
							}

						} else {

							$urls = "/";

						}


					return $urls;

				}


				// snoopy 로 가져온 원격지의 이미지 정보를 추출 한다. (cURL 방식)
				function ranger($url){

						$headers = array(
							"Range: bytes=0-32768"
						);

						$curl = curl_init($url);

						curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

						$data = curl_exec($curl);

						curl_close($curl);


					return $data;
				}


				// 등록일이 현재 날짜를 지났는지 체크, 시간까지는 하지않고 날짜값으로만 한다.
				function valid_day($val){

						if(!$val || $val=='0000-00-00') {
							return false;
						}

						$time = strtotime(date("Y-m-d", mktime()));

						$str_time = strtotime($val);


					if($str_time >= $time) :
						return $val;
					else :
						return false;
					endif;
				}


				// 등록일이 현재 날짜/시간이 지났는지 체크
				function valid_dayTime($val){

						if(!$val || $val=='0000/00/00') :
							return false;
						endif;

						$time = strtotime(date("Y/m/d H:i:s", mktime()));	 // 정확한 계산을 위해 시간까지 체크

						$str_time = strtotime($val);


					if($str_time >= $time) :
						return $val;
					else :
						return false;
					endif;
				}


				// 디렉토리 통째로 삭제
				function rmdirAll($dir) {

						$dirs = @dir($dir);

						if($dirs){
							while(false !== ($entry = $dirs->read())) {
								if(($entry != '.') && ($entry != '..')) {
									if(@is_dir($dir.'/'.$entry)) {
										$this->rmdirAll($dir.'/'.$entry);
									} else {
										@unlink($dir.'/'.$entry);
									}
								}
							}

							$dirs->close();
							@rmdir($dir);
						}

				}


				// 단어 검색시 강조
				function search_font($stx, $str) {

						// 문자앞에 \ 를 붙입니다.
						$src = array("/", "|");
						$dst = array("\/", "\|");

						if (!trim($stx)) return $str;

						// 검색어 전체를 공란으로 나눈다
						$s = explode(" ", $stx);

						// "/(검색1|검색2)/i" 와 같은 패턴을 만듬
						$pattern = "";
						$bar = "";
						for ($m=0; $m<count($s); $m++):
							if (trim($s[$m]) == "") continue;
							$tmp_str = quotemeta($s[$m]);
							$tmp_str = str_replace($src, $dst, $tmp_str);
							$pattern .= $bar . $tmp_str . "(?![^<]*>)";
							$bar = "|";
						endfor;

						// 지정된 검색 폰트의 색상, 배경색상으로 대체
						$replace = "<span style='background-color:#80ff00;'>\\1</span><!-- color:#ff0000; -->";


					return preg_replace("/($pattern)/i", $replace, $str);

				}


				// 제목을 변환 :: 출력시 사용
				function conv_subject($subject, $len, $suffix="") {

					return $this->str_cut($this->get_text($subject), $len, $suffix);

				}


				// 파일의 용량을 구한다.
				function get_filesize($size) {

						if ($size >= 1048576) {
							$size = number_format($size/1048576, 1) . "M";
						} else if ($size >= 1024) {
							$size = number_format($size/1024, 1) . "K";
						} else {
							$size = number_format($size, 0) . "byte";
						}


					return $size;

				}

				// 게시글에 첨부된 파일을 얻는다. (배열로 반환)
				function get_file($bo_table, $wr_no) {

					global $db, $alice;

						$file["count"] = 0;
						$query = " select * from `alice_board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' order by `file_no` ";
						
						$result = $db->query_fetch_rows($query);
						foreach($result as $row){
							$no = $row['file_no'];
							$file[$no]['href'] = "./download.php?bo_table=".$bo_table."&wr_no=".$wr_no."&no=" . $no;
							$file[$no]['download'] = $row['file_download'];
							$file[$no]['path'] = $alice['data_board_path'] . "/" . $bo_table;
							$file[$no]['size'] = $this->get_filesize($row['file_filesize']);
							$file[$no]['datetime'] = $row['file_datetime'];
							$file[$no]['source'] = addslashes($row['file_source']);
							$file[$no]['file_content'] = $row['file_content'];
							$file[$no]['content'] = $this->get_text($row['file_content']);
							$file[$no]['view'] = $this->view_file_link($row['file_name'], $row['file_width'], $row['file_height'], $file[$no]['content']);
							$file[$no]['file'] = $row['file_name'];
							$file[$no]['image_width'] = $row['file_width'] ? $row['file_width'] : 640;
							$file[$no]['image_height'] = $row['file_height'] ? $row['file_height'] : 480;
							$file[$no]['image_type'] = $row['file_type'];
							$file["count"]++;
						}


					return $file;
				}


				// 파일을 보이게 하는 링크 (이미지, 플래쉬, 동영상)
				function view_file_link($file, $width, $height, $content="") {

					global $alice, $board;

						$ids = 0;

						if (!$file) return;

						$ids++;

						// 파일의 폭이 게시판설정의 이미지폭 보다 크다면 게시판설정 폭으로 맞추고 비율에 따라 높이를 계산
						/*
						if ($width > $board['bo_image_width'] && $board['bo_image_width']):
							$rate = $board['bo_image_width'] / $width;
							$width = $board['bo_image_width'];
							$height = (int)($height * $rate);
						endif;
						*/

						// 폭이 있는 경우 폭과 높이의 속성을 주고, 없으면 자동 계산되도록 코드를 만들지 않는다.
						if ($width)
							$attr = " width='$width' height='$height' ";
						else
							$attr = "";

						$upload_ext_img = explode('|',$board['bo_upload_ext_img']);
						$ext = $this->get_extension($file);	 // 확장자 검사

						if(in_array($ext,$upload_ext_img))
							return "<img src='".$alice['data_board_path'] . '/' . $board['bo_table']."/".urlencode($file)."' name='target_resize_image[]' onclick='image_window(this);' style='cursor:pointer;' title='$content'>";

				}


				// 내용을 변환
				function conv_content($content, $html){

						if ($html) {
							$source = array();
							$target = array();

							$source[] = "//";
							$target[] = "";

							if ($html == 2) { // 자동 줄바꿈
								$source[] = "/\n/";
								$target[] = "<br/>";
							}

							// 테이블 태그의 갯수를 세어 테이블이 깨지지 않도록 한다.
							$table_begin_count = substr_count(strtolower($content), "<table");
							$table_end_count = substr_count(strtolower($content), "</table");
							for ($i=$table_end_count; $i<$table_begin_count; $i++) {
								$content .= "</table>";
							}

							$content = preg_replace($source, $target, $content);
							$content = $this->bad_tag_convert($content);
							
							$content = preg_replace("#\/\*.*\*\/#iU", "", $content);

							$content = preg_replace("/(on)([a-z]+)([^a-z]*)(\=)/i", "&#111;&#110;$2$3$4", $content);
							$content = preg_replace("/(dy)(nsrc)/i", "&#100;&#121;$2", $content);
							$content = preg_replace("/(lo)(wsrc)/i", "&#108;&#111;$2", $content);
							$content = preg_replace("/(sc)(ript)/i", "&#115;&#99;$2", $content);
							$content = preg_replace("/\<(\w|\s|\?)*(xml)/i", "", $content);

							$content = preg_replace("/<(img[^>]+delete\.php[^>]+bo_table[^>]+)/i", "*** CSRF 감지 : &lt;$1", $content);
							$content = preg_replace("/<(img[^>]+delete_comment\.php[^>]+bo_table[^>]+)/i", "*** CSRF 감지 : &lt;$1", $content);
							$content = preg_replace("/<(img[^>]+logout\.php[^>]+)/i", "*** CSRF 감지 : &lt;$1", $content);
							$content = preg_replace("/<(img[^>]+download\.php[^>]+bo_table[^>]+)/i", "*** CSRF 감지 : &lt;$1", $content);

							$pattern = "";
							$pattern .= "(e|&#(x65|101);?)";
							$pattern .= "(x|&#(x78|120);?)";
							$pattern .= "(p|&#(x70|112);?)";
							$pattern .= "(r|&#(x72|114);?)";
							$pattern .= "(e|&#(x65|101);?)";
							$pattern .= "(s|&#(x73|115);?)";
							$pattern .= "(s|&#(x73|115);?)";
							$pattern .= "(i|&#(x6a|105);?)";
							$pattern .= "(o|&#(x6f|111);?)";
							$pattern .= "(n|&#(x6e|110);?)";
							$content = preg_replace("/".$pattern."/i", "__EXPRESSION__", $content);

						} else {	 // text 이면

							// & 처리 : &amp; &nbsp; 등의 코드를 정상 출력함
							$content = $this->html_symbol($content);

							// 공백 처리
							//$content = preg_replace("/  /", "&nbsp; ", $content);
							$content = str_replace("  ", "&nbsp; ", $content);
							$content = str_replace("\n ", "\n&nbsp;", $content);

							$content = $this->get_text($content, 1);

							$content = $this->url_auto_link($content);

						}


					return $content;
				}


				// 악성태그 변환
				function bad_tag_convert($code) {

					global $view;
					global $member, $is_admin;

						if ($is_admin && $member['mb_id'] != $view['mb_id']) {
							//$code = preg_replace_callback("#(\<(embed|object)[^\>]*)\>(\<\/(embed|object)\>)?#i",
							// embed 또는 object 태그를 막지 않는 경우 필터링이 되도록 수정
							$code = preg_replace_callback("#(\<(embed|object)[^\>]*)\>?(\<\/(embed|object)\>)?#i",
										create_function('$matches', 'return "<div class=\"embedx\">보안문제로 인하여 embed 또는 object 태그를 볼 수 없습니다. </div>";'),
										$code);
						}


					//return preg_replace("/\<([\/]?)(script|iframe)([^\>]*)\>/i", "&lt;$1$2$3&gt;", $code);
					// script 나 iframe 태그를 막지 않는 경우 필터링이 되도록 수정
					return preg_replace("/\<([\/]?)(script)([^\>]*)\>?/i", "&lt;$1$2$3&gt;", $code);
				}


				// way.co.kr 의 wayboard 참고
				function url_auto_link($str) {

					global $alice;

						// 속도 향상 031011
						$str = preg_replace("/&lt;/", "\t_lt_\t", $str);
						$str = preg_replace("/&gt;/", "\t_gt_\t", $str);
						$str = preg_replace("/&amp;/", "&", $str);
						$str = preg_replace("/&quot;/", "\"", $str);
						$str = preg_replace("/&nbsp;/", "\t_nbsp_\t", $str);
						$str = preg_replace("/([^(http:\/\/)]|\(|^)(www\.[^[:space:]]+)/i", "\\1<A HREF=\"http://\\2\" TARGET='_blank'>\\2</A>", $str);	//$config[cf_link_target]
						$str = preg_replace("/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i", "\\1<A HREF=\"\\2\" TARGET='_blank'>\\2</A>", $str);	//$config[cf_link_target]
						// 이메일 정규표현식 수정 061004
						//$str = preg_replace("/(([a-z0-9_]|\-|\.)+@([^[:space:]]*)([[:alnum:]-]))/i", "<a href='mailto:\\1'>\\1</a>", $str);
						$str = preg_replace("/([0-9a-z]([-_\.]?[0-9a-z])*@[0-9a-z]([-_\.]?[0-9a-z])*\.[a-z]{2,4})/i", "<a href='mailto:\\1'>\\1</a>", $str);
						$str = preg_replace("/\t_nbsp_\t/", "&nbsp;" , $str);
						$str = preg_replace("/\t_lt_\t/", "&lt;", $str);
						$str = preg_replace("/\t_gt_\t/", "&gt;", $str);


					return $str;
				}



				function file_get_contents($url, $mdate='') {

						if(empty($mdate)) $mdate = date("Y-m-d", time());
						
						$url_infos = parse_url($url);
						$fp = @fsockopen($url_infos['host'], ($url_infos['port']?$url_infos['port']:80), $errno, $errstr, 2);
						if(!is_resource($fp)) return false;
						if($url_infos['query']) $url_infos['path'] .= '?';
						$header = "GET $url_infos[path]$url_infos[query] HTTP/1.1\r\n";
						$header .= "Host: $url_infos[host]\r\n";
						$header .= "If-Modified-Since: $mdate\r\n\r\n";
						fputs($fp, $header);
						socket_set_timeout($fp, 4);

						$active = false;
						while(!feof($fp)) {
							$string = fgets($fp,1024);
							$socket_status = socket_get_status($fp);
							if($socket_status['timed_out']) return false;
							if($active) {
								//if(eregi('<', $string)===false)  continue; // XML 구조가 아닌 경우 스킵 처리
								$contents .= $string;
							} else {
								if(strpos($string, "\r\n", 0) == 0) $active = true;
								$_mdate = strpos($string, "Last-Modified:");
								$_location = strpos($string, "Location:");
								if($_mdate!==false) $new_mdate = trim(substr($string, $_mdate+14));
								if($_location!==false) {
									$new_location = trim(substr($string, $_location+9));
									break;
								}
							}
						}

						fclose($fp);


					return empty($new_location) ? $contents : $this->file_get_contents($new_location, $new_mdate);

				}


				/**
				* 임시 패스워드 생성
				* 길이에 따라 자리수가 늘어난다.
				*/		
				function make_passwd( $length='12' ){

						$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

				        shuffle($chars_array);

						$shuffle = implode("", $chars_array);

						$result = substr($shuffle,0,$length);

					
					return $result;

				}

				// 날짜 사이 계산
				function date_diff($date1, $date2) { 
					$count = 0; 
					//Ex 2012-10-01 ir 2012-10-20
					if(strtotime($date1) < strtotime($date2)) {
					  $current = $date1;                
					  while(strtotime($current) < strtotime($date2)){ 
						  $current = date("Y-m-d",strtotime("+1 day", strtotime($current))); 
						  $count++; 
					  } 
					}                 
					//Ex 2012-10-20 ir 2012-10-01
					else if(strtotime($date2) < strtotime($date1))
					{           
					  $current = $date2;                
					  while(strtotime($current) < strtotime($date1)){ 
						  $current = date("Y-m-d",strtotime("+1 day", strtotime($current))); 
						  $count++;  
					  }
					  $current = $current * -1;
					}


				return $count; 

				}

				// 파일명 변경 => 복사
				function file_rename_copy( $path, $save_path, $file, $no ){

						$file_full = explode('.',$file);
						$file_name = $file_full[0] . "_c_".$no;
						$file_extension = $file_full[1];
						
						$new_file = $file_name . '.' . $file_extension;

						@copy( $path . '/' . $file, $save_path . '/' . $new_file);
						

					return $new_file;

				}

				// 요일 알아내기
				function week_korean( $date ){

						$week_date = strftime("%w",strtotime($date));

						$week_korean = array('일', '월', '화', '수', '목', '금', '토');

						$result = $week_korean[$week_date];


					return $result;

				}

				// 성인 유무
				function is_adult( $birth_date ){

						$result = false;

						$adult_date = date("Ymd", strtotime("-19 years", time()) );
	 
						if( (int)$birth_date <= (int)$adult_date ) {

							$result = true;

						} else {

							$result = false;

						}


					return $result;

				}


				// 1원 단위 처리(R:반올림 C:올림 F:버림)
				// rate :: 10 => 1원 단위, 100 => 10원 단위, 1000 => 100원 단위
				function chg_1won($amount, $rate=10, $mode='F') {

						$remove_amount = round($amount) / $rate;                 // 소수점 반올림

						if ($mode == 'F') 
							$remove_amount = floor($remove_amount);
						else if ($mode == 'R') 
							$remove_amount = round($remove_amount);
						else if ($mode == 'C') 
							$remove_amount = ceil($remove_amount);

						$remove_amount = $remove_amount * $rate;

					return $remove_amount;
				}

		}	// class end.
?>