<?php
		/**
		* /application/nad/config/contoller/alice_map_control.class.php
		* @author Harimao
		* @since 2015/06/11
		* @last update 2015/04/10
		* @Module v3.5 ( Alice )
		* @Brief :: Map Control Class
		* @Comment :: 지도 기본 컨트롤 클래스
		*/
		class alice_map_control extends alice_map_model {


				// 네이버 지도 검색
				function get_naver_geocode( $search_addr ){

					global $alice, $env, $utility;

						$map_key = $env['naver_map_key'];

						//$url = "http://map.naver.com/api/geocode.php?query=".urlencode($search_addr)."&key=".$map_key."&coord=latlng";
						$url = "http://openapi.map.naver.com/api/geocode?key=".$map_key."&encoding=utf-8&coord=latlng&query=".urlencode($search_addr);

						if(version_compare(PHP_VERSION, '5.0.0', '>') && function_exists("simplexml_load_file") && ini_get('allow_url_fopen')) {

							$xml = simplexml_load_file($url);

							$result = $this->map_data_xml_formalize($xml);

						} else {

							// 버전이 맞지 않는 경우 클래스를 불러와 사용
							//$xml = new XMLParser($utility->file_get_contents($url));
							$url_file = $utility->file_get_contents($url);
							
							$filename = $alice['tmp_path'] . "/naver_location.xml";

							if (is_writable($filename)) {

								// that's where $somecontent will go when we fwrite() it.
								if (!$handle = fopen($filename, 'w')) {
									 echo "Cannot open file ($filename)";
									 exit;
								}

								// Write $somecontent to our opened file.
								if (fwrite($handle, $url_file) === FALSE) {
									echo "Cannot write to file ($filename)";
									exit;
								}

							}

							fclose($handle);
							
							$result = $this->naver_map_data_xml_formalize2($filename);

						}


					return $result;

				}

				// 네이버 지도 데이터 XML
				function naver_map_data_xml_formalize($datas) {

						$result = "";

						$items = $datas->item;

						if($items){

							foreach($datas->item as $item) {

								$address = trim($item->address);
								$sido = trim($item->addrdetail->sido);
								$sigugun = trim($item->addrdetail->sido->sigugun);
								$dongmyun = trim($item->addrdetail->sido->sigugun->dongmyun);
								$mapx = $item->point->x;
								$mapy = $item->point->y;

								$result  .= "<item>";
								$result .= "<address>".$address."</address>";
								$result .= "<sido>".$sido."</sido>";
								$result .= "<sigugun>".$sigugun."</sigugun>";
								$result .= "<dongmyun>".$dongmyun."</dongmyun>";
								$result .= "<mapx>".$mapx."</mapx>";
								$result .= "<mapy>".$mapy."</mapy>";
								$result .= "</item>";

							}	// foreach end.

						}


					return $result;

				}

				// 네이버 지도 데이터 XML
				function naver_map_data_xml_formalize2( $file ) {

					global $alice;
						
						include_once $alice['path'] . "engine/library/simplexml.class.php";

						$sxml = new simplexml;

						$datas = $sxml->xml_load_file($file);

						$result = array();

						$i = 0;
						foreach($datas->result->items as $item){
							$result[$i]['address'] = $item->address;
							$result[$i]['mapx'] = $item->point->x;
							$result[$i]['mapy'] = $item->point->y;
						$i++;
						}	// foreach end.


					return $result;

				}


				// 구글 지도 검색
				function get_google_geocode( $search_addr ){

					global $env, $utility;
					global $snoopy;

						$map_key = $env['google_map_key'];

						$address = explode("~",$search_addr);

						$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address[0])."&sensor=true&language=ko";
						//$url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".urlencode($search_addr)."&sensor=true";
						
						$snoopy->fetch($url);

						$content = str_replace('\r\n', '', $snoopy->results); 
						$result = str_replace(array('\r','\n'), array('',''), $content);


					return $result;

				}



				// 구글 지도 데이터 XML
				function google_map_data_xml_formalize($datas) {

						$result = array();

						$items = $datas->document->item;

						if($items){

							$i = 0;
							foreach($datas->document->item as $item) {

								$mapx = $item->point[0]->x[0]->tagData;
								$mapy = $item->point[0]->y[0]->tagData;
								$address = $item->address[0]->tagData;
								$sido = $item->addrdetail[0]->sido[0]->tagData;
								$sigugun = $item->addrdetail[0]->sido[0]->sigugun[0]->tagData;
								$dongmyun = $item->addrdetail[0]->sido[0]->sigugun[0]->dongmyun[0]->tagData;
								
								$result[$i]['address'] = $address;
								$result[$i]['sido'] = $sido;
								$result[$i]['sigugun'] = $sigugun;
								$result[$i]['dongmyun'] = $dongmyun;
								$result[$i]['mapx'] = $mapx;
								$result[$i]['mapy'] = $mapy;

							$i++;
							}	// foreach end.

						}


					return $result;

				}

		}	// class end.
?>