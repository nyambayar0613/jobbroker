<?php
		/**
		* /application/nad/config/model/alice_map_model.class.php
		* @author Harimao
		* @since 2013/06/11
		* @last update 2015/04/10
		* @Module v3.5 ( Alice )
		* @Brief :: Map Model Class
		* @Comment :: 지도 기본 모델 클래스
		*/
		class alice_map_model extends DBConnection {

			var $config_table	= "alice_config";	 // 기본 환경설정 정보 테이블 (지도 정보를 담고 있다)

			var $success_code = array(
					'0000' => '',
			);

			var $fail_code = array(
					'0000' => '',
			);


				// 지도 정보 추출
				function get_map( $map_point="" ){

					global $alice, $env, $utility;

						$use_map = $env['use_map'];

						$result = "";

						switch($use_map){
							## 다음
							case 'daum':

								if($env['daum_map_key']){

									/*
									$result .= "<script type=\"text/javascript\" src=\"http://apis.daum.net/maps/maps3.js?apikey=".$env['daum_map_key']."\" charset=\"utf-8\"></script>\n";
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/daum.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['admin_config_path']."' );\n";
									$map_point = ($map_point!='') ? $map_point : "'37.537123', '127.005523'";
									$result .= "map_api.map_point = ['37.537123', '127.005523', '4'];\n";	// 기본 위치, 줌
									$result .= "</script>";
									*/

								}

							break;
							## 네이버
							case 'naver':

								if($env['naver_map_key']){

									$result .= "<script type=\"text/javascript\" src=\"http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=".$env['naver_map_key']."\"></script>\n";
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/naver.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['admin_config_path']."' );\n";
									$map_point = ($map_point!='') ? $map_point : "'37.5010226', '127.0396037'";
									$result .= "map_api.map_point = ['37.5010226', '127.0396037', '10'];\n";	// 기본 위치, 줌
									$result .= "</script>";

								}

							break;
							## 구글
							case 'google':

								if($env['google_map_key']){

									$result .= "<script type=\"text/javascript\" src=\"http://maps.googleapis.com/maps/api/js?key=".$env['google_map_key']."&sensor=true\"></script>";
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/google.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['admin_config_path']."' );\n";
									$map_point = ($map_point!='') ? $map_point : "'37.5010226', '127.0396037'";
									$result .= "map_api.map_point = ['37.5010226', '127.0396037', '18'];\n";	// 기본 위치, 줌
									$result .= "</script>";

								}

							break;
						}


					echo $result;

				}

				// 채용공고 상세보기
				function detail_map( $map_point="" ){

					global $alice, $env, $utility;


						$use_map = $env['use_map'];

						$result = "";

						switch($use_map){
							
							## 다음
							case 'daum':

								if($env['daum_map_key']){

									$result .= "<script type=\"text/javascript\" src=\"http://apis.daum.net/maps/maps3.js?apikey=".$env['daum_map_key']."\" charset=\"utf-8\"></script>\n";
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/daum.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['alba_path']."' );\n";
									$result .= "map_api.map_point = [".$map_point.", '4'];\n";	// 기본 위치, 줌
									$result .= "</script>\n";

								}

							break;

							## 네이버
							case 'naver':

								if($env['naver_map_key']){

									$result .= "<script type=\"text/javascript\" src=\"http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=".$env['naver_map_key']."\"></script>\n";
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/naver.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['alba_path']."' );\n";
									$result .= "map_api.map_point = [".$map_point.", '10'];\n";	// 기본 위치, 줌
									$result .= "</script>";

								}

							break;

							## 구글
							case 'google':
								
								if($env['google_map_key']){

									$result .= "<script type=\"text/javascript\" src=\"http://maps.googleapis.com/maps/api/js?key=".$env['google_map_key']."&sensor=true\"></script>";
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/google.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['alba_path']."' );\n";
									$result .= "map_api.map_point = [".$map_point.", '18'];\n";	// 기본 위치, 줌
									$result .= "</script>";

								}

							break;

						}


					return $result;

				}

				// 지도검색 메뉴
				function search_map( $map_point="" ){

					global $alice, $env, $utility;

						$use_map = $env['use_map'];

						$result = "";

						switch($use_map){

							## 다음
							case 'daum':

								if($env['daum_map_key']){

									//$result .= "<script type=\"text/javascript\" src=\"http://apis.daum.net/maps/maps3.js?apikey=".$env['daum_map_key']."\" charset=\"utf-8\"></script>\n";
									$result .= "<script type=\"text/javascript\" src=\"//dapi.kakao.com/v2/maps/sdk.js?appkey=".$env['daum_map_key']."&libraries=services\"></script>\n";  
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/daum.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['map_path']."' );\n";
									//$map_point = ($map_point!='') ? $map_point : "'37.537123', '127.005523'";
									$map_point = ($map_point!='') ? $map_point : "'35.87015900695213', '127.84559918940543'";
									$result .= "map_api.map_point = [".$map_point.", '12'];\n";	// 기본 위치, 줌
									$result .= "</script>";

								}

							break;

							## 네이버
							case 'naver':

								if($env['naver_map_key']){
								
									$result .= "<script type=\"text/javascript\" src=\"http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=".$env['naver_map_key']."\"></script>\n";
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/naver.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['map_path']."' );\n";
									//$map_point = ($map_point!='') ? $map_point : "'37.537123', '127.005523'";
									$map_point = ($map_point!='') ? $map_point : "'35.87015900695213', '127.84559918940543'";
									$result .= "map_api.map_point = [".$map_point.", '3'];\n";	// 기본 위치, 줌
									$result .= "</script>\n";

								}

							break;

							## 구글
							case 'google':
							
								if($env['google_map_key']){

									$result .= "<script type=\"text/javascript\" src=\"http://maps.googleapis.com/maps/api/js?key=".$env['google_map_key']."&sensor=true\"></script>";
									$result .= "<script type=\"text/javascript\" src='".$alice['js_path']."/google.api.js'></script>\n";
									$result .= "<script>\n";
									$result .= "var map_api = new map_api( '".$alice['map_path']."' );\n";
									//$map_point = ($map_point!='') ? $map_point : "'37.5010226', '127.0396037'";
									$map_point = ($map_point!='') ? $map_point : "'35.87015900695213', '127.84559918940543'";
									$result .= "map_api.map_point = [".$map_point.", '8'];\n";	// 기본 위치, 줌
									$result .= "</script>\n";

								}

							break;
						}


					return $result;

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