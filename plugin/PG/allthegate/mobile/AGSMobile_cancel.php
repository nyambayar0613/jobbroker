<?
	///////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// 올더게이트 모바일 카드 결제취소 페이지
	//
	///////////////////////////////////////////////////////////////////////////////////////////////////
	
	require_once ("./lib/AGSMobile.php");
	
	
	$tracking_id = $_REQUEST["tracking_id"];
	$transaction = $_REQUEST["transaction"];
	$SendNo = $_REQUEST["SendNo"];
	$AdmNo = $_REQUEST["AdmNo"];
	$AdmDt = $_REQUEST["AdmDt"];
	$store_id = $_REQUEST["StoreId"];
	$Store_OrdNo = $_REQUEST["Store_OrdNo"];		// 취소 원거래건 확인을 위한 상점측 정보

	$log_path = null;	
	// log파일 저장할 폴더의 경로를 지정합니다.
    // 경로의 값이 null로 되어있을 경우 "현재 작업 디렉토리의 /lib/log/"에 저장됩니다.

	if ( Cancel_Check($Store_OrdNo) == True ){
    
		$agsMobile = new AGSMobile($store_id,$tracking_id,$transaction,$log_path);

		$agsMobile->setLogging(true);  //true : 로그기록, false : 로그기록안함.

		$ret = $agsMobile->cancel($AdmNo, $AdmDt, $SendNo);
		
		// 상점은 아래에서 처리하세요
		if ($ret['status'] == "ok") {
			
			echo "업체ID : ".$ret["data"]["StoreId"]."<br/>";     
			echo "승인번호: ".$ret["data"]["AdmNo"]."<br/>";   
			echo "승인시각: ".$ret["data"]["AdmTime"]."<br/>";   
			echo "코드: ".$ret["data"]['Code']."<br/>";   
		
		}else {
			//취소 통신 실패
			echo "승인 실패 : ".$ret['message']; // 에러 메시지
		}

	}else{

			echo "승인실패 : 취소 원거래건을 찾지 못했습니다."; // 취소요청건이 상점 결제건이 아닌 경우 처리
	}

	function Cancel_Check($Store_OrdNo) 
	{
		$flag = False;
		/***********************************************************************************
		*여기서 상점측 원거래 정보를 가져옵니다.
		*취소요청 건의 원거래가 상점측 원거래 정보와 동일하고
		*취소가 가능한 상태이면 True, 아니면 False
		* $Order			//ex. 상점 원거래정보	
		************************************************************************************/
		/*
			if ( $Store_OrdNo == $Order ){
				$flag = True;
			}else{
				$flag = False;
			}
		*/
	//	************************************************************************************/
		
		return $flag;

	}
	
?>