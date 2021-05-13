<?
/**
 * 파일명 : AGSLib.php
 * 최종수정일자 : 2016/10/11
 *
 * 올더게이트 결제용 라이브러리 파일입니다.
 * Copyright NICEPayments.Co.,Ltd. All rights reserved.	
 *
 */

/* GLOBAL */
define("PROGRAM", "AgsPay40");
define("TYPE", "php");

/* LOG LEVEL */
define("FATAL", 1);
define("ERROR", 2);
define("WARN", 3);
define("INFO", 4);
define("DEBUG", 5);


class agspay40
{

	/**************************************************************************************
	*
	* [1] 올더게이트 결제시 사용할 로컬 통신서버 IP/Port 번호
	*
	* $LOCALADDR	: PG서버와 통신을 담당하는 암호화Process가 위치해 있는 IP
	* $LOCALPORT	: 포트
	* $ENCRYPT		: 0:안심클릭,일반결제 2:ISP
	* $CONN_TIMEOUT : 암호화 데몬과 접속 Connect타임아웃 시간(초)
	* $READ_TIMEOUT : 데이터 수신 타임아웃 시간(초)
	* 
	***************************************************************************************/	
	var $LOCALADDR = "121.133.126.1"; 
	var $LOCALPORT = "29760"; 
	var $ENCTYPE = 0; 
	var $CONN_TIMEOUT = 10; 
	var $READ_TIMEOUT = 30; 

	var $ERRMSG; 
	var $log;
	var $fp;

	var $REQUEST 	= array();
	var $RESULT 	= array();

	var $sDataMsg;
	var $sSendMsg;
	var $sRecvMsg;
	var $sRecvLen;
	
	var $SendValArray;
	var $RecvValArray;
	var $TID;




	/*
		Aegis 결제/취소 처리 
	*/
	function startPay(  )
	{
		$this->ERRMSG = "";
		
		/*
			Log 기록 객체생성						
   		*/
		$this->log = new PayLog( $this->REQUEST );
		if(!$this->log->InitLog()) 
		{
			$this->ERRMSG .= "로그파일을 열수가 없습니다.[".$this->REQUEST["AgsPayHome"]."]" ; 
			$this->RESULT["rSuccYn"] = "n";
			$this->RESULT["rResMsg"] = $this->ERRMSG;
			$this->RESULT["rCancelSuccYn"] = "n";
			$this->RESULT["rCancelResMsg"] = $this->ERRMSG;
			return false;
		}
		
		$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." ".$this->REQUEST["Type"]." Start!" );
		
		if($this->REQUEST["Type"] == "Cancel")
		{
			if($this->REQUEST["AuthTy"] == "virtual" )
			{
				$this->log->WriteLog( WARN, "Cannot Cancel AuthTy[".$this->REQUEST["AuthTy"]."]" );
				$this->log->CloseLog( "AuthTy[".$this->REQUEST["AuthTy"]."] End");
				return false;
			}
		}

		/*
			요청값 로그기록						
   		*/
		$this->writeLogArray($this->REQUEST);


		//취소요청
		if($this->REQUEST["Type"] == "Cancel")
		{
			if( $this->NetCancel() == false )
			{
				/*
					결과값 로그기록						
				*/			
				$this->log->WriteLog( ERROR,$this->REQUEST["AuthTy"]." ".$this->REQUEST["Type"]." Result Value [" );
				$this->writeLogArray($this->RESULT);
				$this->log->WriteLog( ERROR, "]" );

				$this->log->WriteLog( ERROR, $this->REQUEST["AuthTy"]." ".$this->REQUEST["Type"]." Fail End" );
				$this->payQuit();
				return false;
			}

			/*
				결과값 로그기록						
			*/			
			$this->log->WriteLog( WARN,$this->REQUEST["AuthTy"]." ".$this->REQUEST["Type"]." Result Value [" );
			$this->writeLogArray($this->RESULT);
			$this->log->WriteLog( WARN, "]" );

			$this->log->WriteLog( WARN, $this->REQUEST["AuthTy"]." ".$this->REQUEST["Type"]."  Success End" );
			//log 객체 닫기
			$this->log->CloseLog( $this->GetResult("rCancelResMsg") );
			return true;
		}
		
		if( empty( $this->REQUEST["StoreId"] ) || $this->REQUEST["StoreId"] == "" )
		{
			$this->ERRMSG .= "상점아이디 입력여부 확인요망 <br>";		//상점아이디
		}

		if( empty( $this->REQUEST["OrdNo"] ) || $this->REQUEST["OrdNo"] == "" )
		{
			$this->ERRMSG .= "주문번호 입력여부 확인요망 <br>";		//주문번호
		}

		if( empty( $this->REQUEST["ProdNm"] ) || $this->REQUEST["ProdNm"] == "" )
		{
			$this->ERRMSG .= "상품명 입력여부 확인요망 <br>";			//상품명
		}

		if( empty( $this->REQUEST["Amt"] ) || $this->REQUEST["Amt"] == "" )
		{
			$this->ERRMSG .= "금액 입력여부 확인요망 <br>";			//금액
		}

		if( empty( $this->REQUEST["DeviId"] ) || $this->REQUEST["DeviId"] == "" )
		{
			$this->ERRMSG .= "단말기아이디 입력여부 확인요망 <br>";	//단말기아이디
		}

		if( empty( $this->REQUEST["AuthYn"] ) || $this->REQUEST["AuthYn"] == "" )
		{
			$this->ERRMSG .= "인증여부 입력여부 확인요망 <br>";		//인증여부
		}

		if( strlen($this->ERRMSG) == 0 ){
			
			/* Make Tid */
			if( ($MakeTIDResult = $this->MakeNetCancID()) != true){
				$this->log->WriteLog( FATAL, "Make NetCancelID Fail" );
				$this->payQuit();
				return false;
			}else{
				$this->log->WriteLog( INFO, "Make NetCancelID OK" );
			}

			/* Make Pay Msg */
			if( ($MakeMsgResult = $this->MakeMsg()) != true){
				$this->log->WriteLog( FATAL, "Make Pay Msg Fail" );
				$this->ERRMSG = "결제요청전문생성 오류.";
				$this->RESULT["rSuccYn"] = "n";
				$this->RESULT["rResMsg"] = $this->ERRMSG;
				$this->payQuit();
				return false;
			}else{
				$this->log->WriteLog( INFO, "Make Pay Msg OK" );
			}



			/* Send & Recv Msg */				
			if( ($ParseResult = $this->SendRecvMsg()) != true){
				$this->log->WriteLog( FATAL, "Send & Recv Msg Fail" );
				$this->ERRMSG = "결제요청전문 송수신 오류.(결제내역을 꼭 확인해주세요)";
				$this->RESULT["rSuccYn"] = "n";
				$this->RESULT["rResMsg"] = $this->ERRMSG;
				$this->REQUEST["CancelMsg"] = "Send & Recv Msg Fail";
				$this->log->WriteLog( WARN, "NetCancel Call" );
				if( $this->NetCancel() == false )	//망취소
				{
					$this->log->WriteLog( FATAL, "NetCancel Fail End" );
					$this->payQuit();
					return false;
				}
				$this->log->WriteLog( INFO, "NetCancel Success End" );
				$this->payQuit();
				return false;
			}else{
				$this->log->WriteLog( INFO, "Send & Recv Msg OK" );
			}
			
			/* RecvMsg Parsing */
			if( ($ParseResult = $this->ParseMsg()) != true){
				$this->log->WriteLog( FATAL, "Msg Parsing Fail" );
				$this->ERRMSG = "결제결과전문 처리중 오류.(결제내역을 꼭 확인해주세요)";
				$this->RESULT["rSuccYn"] = "n";
				$this->RESULT["rResMsg"] = $this->ERRMSG;
				$this->REQUEST["CancelMsg"] = "Msg Parsing Fail";
				$this->log->WriteLog( WARN, "NetCancel Call" );
				if( $this->NetCancel() == false )	//망취소
				{
					$this->log->WriteLog( FATAL, "NetCancel Fail End" );
					$this->payQuit();
					return false;
				}
				$this->log->WriteLog( INFO, "NetCancel Success End" );
				$this->payQuit();
				return false;
			}else{
				$this->log->WriteLog( INFO, "Msg Parsing OK" );
			}

		}
		else
		{
			$this->RESULT["rSuccYn"] = "n";
			$this->RESULT["rResMsg"] = $this->ERRMSG;
		}

		/*
			결과값 로그기록						
   		*/
		
		$this->log->WriteLog( INFO,$this->REQUEST["AuthTy"]." ".$this->REQUEST["Type"]." Result Value [" );
		$this->writeLogArray($this->RESULT);
		$this->log->WriteLog( INFO, "]" );

		//log 객체 닫기
		$this->log->CloseLog( $this->GetResult("rResMsg") );

		return true;

	}	//startPay() End


	/*
		프로세스 종료                       
	*/
 	function payQuit() 
	{
		//log 객체 닫기
		$this->log->CloseLog( $this->GetResult("rResMsg") );
		
		/** 소켓 close **/
		if($this->fp != false ){
			fclose( $this->fp );
		}

	}

	/*
		프로세스 종료                       
	*/
 	function writeLogArray($array)
	{ 
		foreach ($array as $key => $value) 
		{
			$this->log->WriteLog( INFO, $key.":".$value );
		}
	}

	/*
		결제요청 Msg 송신 및 결과 Msg수신                       
	*/
 	function SendRecvMsg() 
	{
		$this->log->WriteLog( INFO, "Send & Recv Msg Start" );

		/****************************************************************************
		* 
		* 암호화Process와 연결을 하고 승인 데이터 송수신
		* 
		****************************************************************************/
				
		/** 승인 전문을 암호화Process로 전송 **/
		$this->log->WriteLog( INFO, "Send Data To PG Start [ " );
		$this->SendValArray = array();
		$this->SendValArray = explode( "|", $this->sSendMsg );
		$this->log->WriteLog( INFO, $this->SendValArray);
		$this->log->WriteLog( INFO, "] Send Data To PG End " );
		$this->log->WriteLog( INFO, "SendMsg : [".$this->sSendMsg."]" );	
		
		/** 소켓 open **/
		$this->log->WriteLog( INFO, "Connect IP:[".$this->LOCALADDR."] Port:[".$this->LOCALPORT."]" );
		$this->fp = fsockopen( $this->LOCALADDR, $this->LOCALPORT , &$errno, &$errstr, $this->CONN_TIMEOUT );
		
		if( !$this->fp )
		{
			$this->log->WriteLog( ERROR, "Socket Connect Error: [".$errno."-".$errstr."]" );

			/** 연결 실패로 인한 실패 메세지 전송 **/
			if($this->REQUEST["Type"] == "Cancel")
			{
				$this->RESULT["rCancelSuccYn"] = "n";
				$this->RESULT["rCancelResMsg"] = "Socket Connect Fail";
				$this->log->WriteLog( ERROR, $this->RESULT["rCancelResMsg"] );				
			}
			else
			{
				$this->RESULT["rSuccYn"] = "n";
				$this->RESULT["rResMsg"] = "Socket Connect Fail";
				$this->log->WriteLog( ERROR, $this->RESULT["rResMsg"] );
			}
			if($this->fp) fclose( $this->fp );
			return false;
		}
		/** 연결에 성공하였으므로 데이터를 받는다. **/			
		$this->log->WriteLog( INFO, "Socket Open OK" );

		fputs( $this->fp, $this->sSendMsg );
		
		socket_set_timeout($this->fp, $this->READ_TIMEOUT);
		
		/** 최초 6바이트를 수신해 데이터 길이를 체크한 후 데이터만큼만 받는다. **/
		/****************************************************************************
		*
		* PHP 버전에 따라 수신 데이터 길이 체크시 페이지오류가 발생할 수 있습니다
		* 에러메세지:수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패
		* 데이터 길이 체크 오류시 아래와 같이 변경하여 사용하십시오
		* $this->sRecvLen = fgets( $this->fp, 6 );
		* $this->sRecvMsg = fgets( $this->fp, $this->sRecvLen );
		*
		****************************************************************************/
		
		if($this->REQUEST["RecvLen"] == 7)
		{
			$this->sRecvLen = fgets( $this->fp, $this->REQUEST["RecvLen"] );
			$this->sRecvMsg = fgets( $this->fp, $this->sRecvLen + 1 );
		}
		else if($this->REQUEST["RecvLen"] == 6)
		{
			$this->sRecvLen = fgets( $this->fp, $this->REQUEST["RecvLen"] );
			$this->sRecvMsg = fgets( $this->fp, $this->sRecvLen);
		}
		else
		{
			$this->REQUEST["RecvLen"] = 7;
			$this->sRecvLen = fgets( $this->fp, $this->REQUEST["RecvLen"] );
			$this->sRecvMsg = fgets( $this->fp, $this->sRecvLen + 1 );
		}
		
		$this->log->WriteLog( INFO, "RecvMsg Length : [".$this->sRecvLen."]" );
		$this->log->WriteLog( INFO, "RecvMsg : [".$this->sRecvMsg."]" );

		/** 소켓 close **/			
		fclose( $this->fp );
		$this->log->WriteLog( INFO, "Socket Close OK");
		
		if( strlen( $this->sRecvMsg ) > 0 && strlen( $this->sRecvMsg ) == $this->sRecvLen )
		{
			/** 수신 데이터(길이) 체크 정상 **/
			$this->log->WriteLog( INFO, "RecvMsg Length Check OK");
				
			$this->RecvValArray = array();
			$this->RecvValArray = explode( "|", $this->sRecvMsg );
			
			/** null 또는 NULL 문자, 0 을 공백으로 변환 
			for( $i = 0; $i < sizeof( $this->RecvValArray); $i++ )
			{
				$this->RecvValArray[$i] = trim( $this->RecvValArray[$i] );
				
				if( !strcmp( $this->RecvValArray[$i], "null" ) || !strcmp( $this->RecvValArray[$i], "NULL" ) )
				{
					$this->RecvValArray[$i] = "";
				}
				
				if( IsNumber( $this->RecvValArray[$i] ) )
				{
					if( $this->RecvValArray[$i] == 0 ) $this->RecvValArray[$i] = "";
				}
			} 
			**/
			$this->log->WriteLog( INFO, "Send & Recv Msg End" );
			return true;
		}
		else
		{
			/** 수신 데이터(길이) 체크 에러시 통신오류에 의한 승인 실패로 간주 **/
			if($this->REQUEST["Type"] == "Cancel")
			{
				$this->RESULT["rCancelSuccYn"] = "n";
				$this->RESULT["rCancelResMsg"] = "Recv Msg Length Check Errror";
				$this->log->WriteLog( ERROR, $this->RESULT["rCancelResMsg"]." : sRecvLen[".$this->sRecvLen."]"."sRecvMsg Length[".strlen( $this->sRecvMsg )."]");
			}
			else
			{
				$this->RESULT["rSuccYn"] = "n";
				$this->RESULT["rResMsg"] = "Recv Msg Length Check Errror";
				$this->log->WriteLog( ERROR, $this->RESULT["rResMsg"]." : sRecvLen[".$this->sRecvLen."]"."sRecvMsg Length[".strlen( $this->sRecvMsg )."]");
			}

			return false;

		}

	}	//SendMsg() End

	/*
		웹을 통한 Msg 송신 및 결과 Msg수신                       
	*/
 	function SendRecvMsgWeb() 
	{
		//추후 작업예정
		return false;
	}

	/*
		Make Pay Msg                       
	*/
 	function MakeMsg() 
	{
		$this->log->WriteLog( INFO, "Make Msg Start" );
		/****************************************************************************
		* ※ 결제 형태 변수의 값에 따른 결제 구분
		*
		* ＊ AuthTy  = "card"		신용카드결제
		*	 - SubTy = "isp"		안전결제ISP
		*	 - SubTy = "visa3d"		안심클릭
		*	 - SubTy = "normal"		일반결제
		*
		* ＊ AuthTy  = "iche"		일반-계좌이체
		* 
		* ＊ AuthTy  = "virtual"	일반-가상계좌(무통장입금)
		* 
		* ＊ AuthTy  = "hp"			핸드폰결제
		*
		* ＊ AuthTy  = "ars"		ARS결제
		*
		****************************************************************************/
		
		if( strcmp( $this->REQUEST["AuthTy"], "card" ) == 0 )
		{
			if( strcmp( $this->REQUEST["SubTy"], "isp" ) == 0 )
			{
				/****************************************************************************
				*
				* [1-1] 신용카드결제 - ISP
				* 
				* -- 이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				* 
				* -- 승인 요청 전문 포멧
				* + 데이터길이(6) + ISP구분코드(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.)
				* 결제종류(6)		| 업체ID(20)		| 회원ID(20)	 		| 결제금액(12)		| 
				* 주문번호(40)	| 단말기번호(10)	| 수신인(40)			| 수신인전화(21)		| 
				* 배송지(100)	| 주문자명(40)	| 주문자연락처(100)	| 기타요구사항(350)	|
				* 상품명(300)	| 통화코드(3)	 	| 일반할부기간(2)		| 무이자할부기간(2)	| 
				* KVP카드코드(22)	| 세션키(256)	| 암호화데이터(2048) 	| 카드명(50)	 		|
				* 회원 IP(20)	| 회원 Email(50)	| 망취소ID (50) |
				* 
				****************************************************************************/
				
				$this->ENCTYPE = 2;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/
				
				$this->sDataMsg = $this->ENCTYPE.
					"plug15"."|".
					$this->REQUEST["StoreId"]."|".
					$this->REQUEST["UserId"]."|".
					$this->REQUEST["Amt"]."|".
					$this->REQUEST["OrdNo"]."|".
					$this->REQUEST["DeviId"]."|".
					$this->REQUEST["RcpNm"]."|".
					$this->REQUEST["RcpPhone"]."|".
					$this->REQUEST["DlvAddr"]."|".
					$this->REQUEST["OrdNm"]."|".
					$this->REQUEST["OrdPhone"]."|".
					$this->REQUEST["Remark"]."|".
					$this->REQUEST["ProdNm"]."|".
					$this->REQUEST["KVP_CURRENCY"]."|".
					$this->REQUEST["partial_mm"]."|".
					$this->REQUEST["noIntMonth"]."|".
					$this->REQUEST["KVP_CARDCODE"]."|".
					$this->REQUEST["KVP_SESSIONKEY"]."|".
					$this->REQUEST["KVP_ENCDATA"]."|".
					$this->REQUEST["KVP_CONAME"]."|".
					$this->REQUEST["UserIp"]."|".
					$this->REQUEST["UserEmail"]."|".
					$this->RESULT["NetCancID"]."|";
		
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." "."Make MSG OK " );
			}
			else if( ( strcmp( $this->REQUEST["SubTy"], "visa3d" ) == 0 ) || ( strcmp( $this->REQUEST["SubTy"], "normal" ) == 0 ) )
			{
				/****************************************************************************
				* 
				* [1-2] 신용카드결제 - VISA3D, 일반
				* 
				* -- 이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				* 
				* -- 승인 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 하며 카드번호,유효기간,비밀번호,주민번호는 암호화된다.)
				* 결제종류(6)			| 업체ID(20)					| 회원ID(20)			| 결제금액(12)	| 주문번호(40)	|
				* 단말기번호(10)		| 카드번호(16)				| 유효기간(6)			| 할부기간(4)		| 인증유무(1)		| 
				* 카드비밀번호(2)		| 주민등록번호/사업자번호(10)	| 수신인(40)			| 수신인전화(21)	| 배송지(100)	|
				* 주문자명(40)		| 주문자연락처(100)			| 기타요구사항(350)	| 상품명(300)	| MPI_CAVV | MPI_MD64 | MPI_ECI | 망취소ID (50) |
				* 
				****************************************************************************/
				
				$this->ENCTYPE = 0;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/
				
				$this->sDataMsg = $this->ENCTYPE.
					"plug15"."|".
					$this->REQUEST["StoreId"]."|".
					$this->REQUEST["UserId"]."|".
					$this->REQUEST["Amt"]."|".
					$this->REQUEST["OrdNo"]."|".
					$this->REQUEST["DeviId"]."|".
					$this->encrypt_aegis($this->REQUEST["CardNo"])."|".
					$this->encrypt_aegis($this->REQUEST["ExpYear"].$this->REQUEST["ExpMon"])."|".
					$this->REQUEST["Instmt"]."|".
					$this->REQUEST["AuthYn"]."|".
					$this->encrypt_aegis($this->REQUEST["Passwd"])."|".
					$this->encrypt_aegis($this->REQUEST["SocId"])."|".
					$this->REQUEST["RcpNm"]."|".
					$this->REQUEST["RcpPhone"]."|".
					$this->REQUEST["DlvAddr"]."|".
					$this->REQUEST["OrdNm"]."|".
					$this->REQUEST["UserIp"].";".$this->REQUEST["OrdPhone"]."|".
					$this->REQUEST["UserEmail"].";".$this->REQUEST["Remark"]."|".
					$this->REQUEST["ProdNm"]."|".
					$this->REQUEST["MPI_CAVV"]."|".
					$this->REQUEST["MPI_MD64"]."|".
					$this->REQUEST["MPI_ECI"]."|".
					$this->REQUEST["UserEmail"]."|".
					$this->RESULT["NetCancID"]."|";
				
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." "."Make MSG OK " );
			}
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "iche" ) == 0 && strcmp( $this->REQUEST["ICHE_SOCKETYN"], "Y" ) == 0)
		{
				/****************************************************************************
				* 
				* [2-1] 인터넷뱅킹 계좌이체(소켓) 처리
				* 
				* -- 이부분은 인터넷뱅킹 결제 처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				* 
				* -- 인터넷뱅킹 결제 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.)
				* 결제종류(10)			| 업체ID(20)			| 주문번호(40)			| 예금주명(20)			| 거래금액(8)		|
				* 은행코드(2)			| 예금주주민번호(13)	| 주문자연락처(16)		| 이메일주소(50)		| 상품명(100)		| 
				* 이용기관주문번호(50)	| FNBC 거래번호(20)		| 이체시각(14)			| 현금영수증발행여부(1)	| 회원아이디(20)	|
				* 거래자구분(2)			| 신분확인번호(13)		| 에스크로사용여부(1)	| 에스크로회원번호(17)	| 에스크로결제금액(8)|
				* 에스크로수수료금액(8) |
				* 
				****************************************************************************/

				$this->ENCTYPE = R;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/

				$this->sDataMsg = $this->ENCTYPE.
					"RB-PayReq"."|".
					$this->REQUEST["StoreId"]."|".
					$this->REQUEST["OrdNo"]."|".
					$this->REQUEST["ICHE_OUTBANKMASTER"]."|".
					$this->REQUEST["Amt"]."|".
					$this->REQUEST["ICHE_OUTBANKNAME"]."|".
					$this->REQUEST["ICHE_OUTACCTNO"]."|".
					$this->REQUEST["OrdPhone"]."|".
					$this->REQUEST["UserEmail"]."|".
					$this->REQUEST["ProdNm"]."|".
					$this->REQUEST["ICHE_POSMTID"]."|".
					$this->REQUEST["ICHE_FNBCMTID"]."|".
					$this->REQUEST["ICHE_APTRTS"]."|".
					$this->REQUEST["ICHE_CASHYN"]."|".
					$this->REQUEST["UserId"]."|".
					$this->REQUEST["ICHE_CASHGUBUN_CD"]."|".
					$this->REQUEST["ICHE_CASHID_NO"]."|".
					$this->REQUEST["ICHE_ECWYN"]."|".
					$this->REQUEST["ICHE_ECWID"]."|".
					$this->REQUEST["ICHE_ECWAMT1"]."|".
					$this->REQUEST["ICHE_ECWAMT2"]."|".
					$this->RESULT["NetCancID"]."|";
				
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make MSG OK " );
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "iche" ) == 0 && strcmp( $this->REQUEST["ICHEARS_SOCKETYN"], "Y" ) == 0)
		{
				/****************************************************************************
				* 
				* [2-2] 텔레뱅킹 계좌이체(소켓) 처리
				* 
				* -- 이부분은 텔레뱅킹 결제 처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				* 
				* -- 텔레뱅킹 결제 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.)
				* 결제종류(10)			| 업체ID(20)			| 주문번호(40)			| 예금주명(20)			|
				* 거래금액(8)			| 은행코드(2)			| 예금주주민번호(13)	| 주문자연락처(16)		| 
				* 이메일주소(50)		| 상품명(100)			| 이용기관주문번호(50)	| FNBC 거래번호(20)		| 
				* 이체시각(14)			| 현금영수증발행여부(1)	| 회원아이디(20)		| 거래자구분(2)			|
				* 신분확인번호(13)		| 에스크로사용여부(1)	| 에스크로회원번호(17)	| 에스크로결제금액(8)	|
				* 에스크로수수료금액(8) |
				* 
				****************************************************************************/

				$this->ENCTYPE = B;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/

				$this->sDataMsg = $this->ENCTYPE.
					"TB-PayReq"."|".
					$this->REQUEST["StoreId"]."|".
					$this->REQUEST["OrdNo"]."|".
					$this->REQUEST["ICHEARS_POSMTID"]."|".
					$this->REQUEST["ICHEARS_ADMNO"]."|".
					$this->REQUEST["ICHEARS_CENTERCD"]."|".
					$this->REQUEST["Amt"]."|".
					$this->REQUEST["ICHE_OUTACCTNO"]."|".
					$this->REQUEST["ICHE_OUTBANKMASTER"]."|".
					$this->REQUEST["ICHEARS_HPNO"]."|".
					$this->REQUEST["UserEmail"]."|".
					$this->REQUEST["ProdNm"]."|".
					$this->REQUEST["ICHE_ECWYN"]."|".
					$this->REQUEST["ICHE_ECWID"]."|".
					$this->REQUEST["ICHE_ECWAMT1"]."|".
					$this->REQUEST["ICHE_ECWAMT2"]."|".
					$this->REQUEST["ICHE_CASHYN"]."|".
					$this->REQUEST["ICHE_CASHGUBUN_CD"]."|".
					$this->REQUEST["ICHE_CASHID_NO"]."|".
					$this->RESULT["NetCancID"]."|";
				
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make MSG OK " );

		}
		else if( strcmp( $this->REQUEST["AuthTy"], "virtual" ) == 0 ) //가상계좌추가
		{
			/****************************************************************************
			*
			* [3] 가상계좌 결제
			* 
			* -- 이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
			* 가장 핵심이 되는 부분이므로 수정후에는 테스트를 하여야 한다.
			* -- 데이터 길이는 매뉴얼 참고
			* 
			* -- 승인 요청 전문 포멧
			* + 데이터길이(6) + 암호화 구분(1) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 한다.)
			* 결제종류(10)		| 업체ID(20)		| 주문번호(40)	 	| 은행코드(4)			| 가상계좌번호(20) |
			* 거래금액(13)		| 입금예정일(8)	| 구매자명(20)		| 주민번호(13)		| 
			* 이동전화(21)		| 이메일(50)		| 구매자주소(100)		| 수신자명(20)		|
			* 수신자연락처(21)	| 배송지주소(100)	| 상품명(100)		| 기타요구사항(300)	| 상점 도메인(50)	 |	상점 페이지(100)|
			* 
			****************************************************************************/
			
			$this->ENCTYPE = "V";
			
			/****************************************************************************
			* 
			* 전송 전문 Make
			* 
			****************************************************************************/
			
			$this->sDataMsg = $this->ENCTYPE.
				/* $this->REQUEST["AuthTy"]."|". */
				"vir_n|".
				$this->REQUEST["StoreId"]."|".
				$this->REQUEST["OrdNo"]."|".
				$this->REQUEST["VIRTUAL_CENTERCD"]."|".
				$this->REQUEST["VIRTUAL_NO"]."|". 
				$this->REQUEST["Amt"]."|".
				$this->REQUEST["VIRTUAL_DEPODT"]."|".
				$this->REQUEST["OrdNm"]."|".
				$this->REQUEST["ZuminCode"]."|".
				$this->REQUEST["OrdPhone"]."|".
				$this->REQUEST["UserEmail"]."|".
				$this->REQUEST["OrdAddr"]."|".
				$this->REQUEST["RcpNm"]."|".
				$this->REQUEST["RcpPhone"]."|".
				$this->REQUEST["DlvAddr"]."|".
				$this->REQUEST["ProdNm"]."|".
				$this->REQUEST["Remark"]."|".
				$this->REQUEST["MallUrl"]."|".
				$this->REQUEST["MallPage"]."|".
				$this->RESULT["NetCancID"]."|";
				
			$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make MSG OK " );
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "hp" ) == 0 )
		{
			/****************************************************************************
			* 
			* [4] 핸드폰 결제
			*
			*  핸드폰 결제를 사용하지않는 상점은 AGS_pay.html에서 지불방법을 꼭 신용카드(전용)으로 설정해 놓으시기 바랍니다.
			* 
			*  이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
			*  가장 핵심이 되는 부분이므로 수정후에는 테스트를 하여야 한다.
			*  -- 승인 요청 전문 포멧
			*  + 데이터길이(6) + 핸드폰구분코드(1) + 데이터
			*  + 데이터 포멧(데이터 구분은 "|"로 한다.)
			* 
			****************************************************************************/
				
			$this->ENCTYPE = "h";
			$this->REQUEST["StrSubTy"] = "Bill";
			
			/****************************************************************************
			* 
			* 전송 전문 Make
			* 
			****************************************************************************/
			
			$this->sDataMsg = $this->ENCTYPE.
				$this->REQUEST["StrSubTy"]."|".
				$this->REQUEST["StoreId"]."|".
				$this->REQUEST["HP_SERVERINFO"]."|".
				$this->REQUEST["HP_ID"]."|".
				$this->REQUEST["HP_SUBID"]."|".
				$this->REQUEST["OrdNo"]."|".
				$this->REQUEST["Amt"]."|".
				$this->REQUEST["HP_UNITType"]."|".
				$this->REQUEST["HP_HANDPHONE"]."|".
				$this->REQUEST["HP_COMPANY"]."|".
				$this->REQUEST["HP_IDEN"]."|".
				$this->REQUEST["UserId"]."|".
				$this->REQUEST["UserEmail"]."|".
				$this->REQUEST["HP_IPADDR"]."|".
				$this->REQUEST["ProdNm"]."|".
				$this->RESULT["NetCancID"]."|";

			$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make MSG OK " );

		}
		else if( strcmp( $this->REQUEST["AuthTy"], "ars" ) == 0 )
		{
			/****************************************************************************
			* 
			* [5] ARS 결제
			*
			*  ARS 결제를 사용하지않는 상점은 AGS_pay.html에서 지불방법을 꼭 신용카드(전용)으로 설정해 놓으시기 바랍니다.
			* 
			*  이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
			*  가장 핵심이 되는 부분이므로 수정후에는 테스트를 하여야 한다.
			*  -- 승인 요청 전문 포멧
			*  + 데이터길이(6) + ARS구분코드(1) + 데이터
			*  + 데이터 포멧(데이터 구분은 "|"로 한다.)
			* 
			****************************************************************************/
				
			$this->ENCTYPE = "A";
			$this->REQUEST["StrSubTy"] = "ABill";
			
			/****************************************************************************
			* 
			* 전송 전문 Make
			* 
			****************************************************************************/

			$this->sDataMsg = $this->ENCTYPE.
				$this->REQUEST["StrSubTy"]."|".
				$this->REQUEST["StoreId"]."|".
				$this->REQUEST["HP_SERVERINFO"]."|".
				$this->REQUEST["HP_ID"]."|".
				$this->REQUEST["HP_UNITType"]."|".
				$this->REQUEST["Amt"]."|".
				$this->REQUEST["ProdNm"]."|".
				$this->REQUEST["UserEmail"]."|".
				$this->REQUEST["HP_SUBID"]."|".
				$this->REQUEST["OrdNo"]."|".
				$this->REQUEST["UserId"]."|".
				$this->REQUEST["ARS_PHONE"]."|".
				$this->REQUEST["HP_IDEN"]."|".
				$this->REQUEST["ARS_NAME"]."|".
				$this->REQUEST["HP_COMPANY"]."|".
				$this->REQUEST["HP_IPADDR"]."|".
				$this->RESULT["NetCancID"]."|";

			$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make MSG OK " );
		}else{
			$this->ERRMSG .= "결제수단 오류. AuthTy:[".$this->REQUEST["AuthTy"]."],SubTy:[".$this->REQUEST["SubTy"]."]";
			$this->log->WriteLog( ERROR, $this->ERRMSG );
			$this->RESULT["rSuccYn"] = "n";
			$this->RESULT["rResMsg"] = $this->ERRMSG;
			
			return false;
		}
		$this->log->WriteLog( INFO, "Make Msg End" );
		return true;
	}	// MakeMsg() End


	/*
		Make Cancel Msg                       
	*/
 	function MakeCancelMsg() 
	{
		$this->log->WriteLog( INFO, "Make Cancel Msg Start" );
		if( strcmp( $this->REQUEST["AuthTy"], "card" ) == 0 )
		{
			if( strcmp( $this->REQUEST["SubTy"], "isp" ) == 0 )
			{
				
				/****************************************************************************
				*
				* [1-1] 신용카드승인취소 - ISP
				*
				* -- 이부분은 취소 승인 처리를 위해 PG서버Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				*	    
				* -- 취소 승인 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.
				* 결제종류(6)	| 업체아이디(20) 	| 승인번호(20) 	| 승인시간(8)	| 거래고유번호(6) |
				*
				* -- 취소 승인 응답 전문 포멧
				* + 데이터길이(6) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.
				* 업체ID(20)	| 승인번호(20)	| 승인시각(8)	| 전문코드(4)	| 거래고유번호(6)	| 성공여부(1)	|
				*		   
				****************************************************************************/
				
				$this->ENCTYPE = 2;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/
						
				$this->sDataMsg = $this->ENCTYPE.
				"cancel"."|".
				$this->GetResult("StoreId")."|".
				$this->GetResult("rApprNo")."|".
				substr($this->GetResult("rApprTm"),0,8)."|".
				$this->GetResult("rDealNo")."|".
				$this->GetResult("NetCancID")."|";
 
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." "."Make Cancel MSG OK " );
			}
			else if( ( strcmp( $this->REQUEST["SubTy"], "visa3d" ) == 0 ) || ( strcmp( $this->REQUEST["SubTy"], "normal" ) == 0 ) )
			{
				/****************************************************************************
				*
				* [1-2] 신용카드승인취소 - VISA3D, 일반
				*
				* -- 이부분은 취소 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				*
				* -- 취소 승인 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 하며 카드번호,유효기간,비밀번호,주민번호는 암호화된다.)
				* 결제종류(6)	| 업체아이디(20) 	| 승인번호(8) 	| 승인시간(14) 	| 카드번호(16) 	|
				*
				* -- 취소 승인 응답 전문 포멧
				* + 데이터길이(6) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 하며 암호화Process에서 해독된후 실데이터를 수신하게 된다.
				* 업체ID(20)	| 승인번호(8)	| 승인시각(14)	| 전문코드(4)	| 성공여부(1)	|
				* 주문번호(20)	| 할부개월(2)	| 결제금액(20)	| 카드사명(20)	| 카드사코드(4) 	|
				* 가맹점번호(15)	| 매입사코드(4)	| 매입사명(20)	| 전표번호(6)
				*		   
				****************************************************************************/
				
				$this->ENCTYPE = 0;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/

				$this->sDataMsg = $this->ENCTYPE.
				"cancel"."|".
				$this->GetResult("StoreId")."|".
				$this->GetResult("rApprNo")."|".
				substr($this->GetResult("rApprTm"),0,8)."|".
				$this->GetResult("rDealNo")."|".
				$this->GetResult("NetCancID")."|";

				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." "."Make Cancel MSG OK " );
			}
		}else if( strcmp( $this->REQUEST["AuthTy"], "iche" ) == 0 && strcmp( $this->REQUEST["ICHE_SOCKETYN"], "Y" ) == 0){
			
				/****************************************************************************
				* 
				* [2-1] 인터넷뱅킹 계좌이체(소켓) 취소처리
				* 
				* -- 이부분은 인터넷뱅킹 결제 취소처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				* 
				* -- 인터넷뱅킹 결제 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.)
				* 결제종류(10)		| 업체ID(20)		| MTID(계좌이체결제 결과값)		| 결제금액(8)		| 은행코드(2)
				* 
				****************************************************************************/

				$this->ENCTYPE = R;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/

				$this->sDataMsg = $this->ENCTYPE.
					"RB-CanReq"."|".
					$this->GetResult("StoreId")."|".
					$this->GetResult("ICHE_POSMTID")."|".
					$this->GetResult("Amt")."|".
					$this->GetResult("ICHE_OUTBANKNAME")."|".
					$this->GetResult("NetCancID")."|";
					
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make Cancel MSG OK " );
		
		}else if( strcmp( $this->REQUEST["AuthTy"], "iche" ) == 0 && strcmp( $this->REQUEST["ICHEARS_SOCKETYN"], "Y" ) == 0){
				
				/****************************************************************************
				* 
				* [2-1] 텔레뱅킹 계좌이체(소켓) 취소처리
				* 
				* -- 이부분은 텔레뱅킹 결제 취소처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				* 
				* -- 텔레뱅킹 결제 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.)
				* 결제종류(10)		| 업체ID(20)		| MTID(계좌이체결제 결과값)		| 결제금액(8)		| 은행코드(2)
				* 
				****************************************************************************/

				$this->ENCTYPE = B;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/

				$this->sDataMsg = $this->ENCTYPE.
					"TB-CanReq"."|".
					$this->GetResult("StoreId")."|".
					""."|".
					""."|".
					$this->GetResult("NetCancID")."|";
					
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make Cancel MSG OK " );
		
		}else if( strcmp( $this->REQUEST["AuthTy"], "hp" ) == 0 ){
				
				/****************************************************************************
				* 
				* [3] 핸드폰 취소처리
				* 
				* -- 이부분은 핸드폰 결제 취소처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				* 
				* -- 핸드폰 결제 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.)
				* 결제종류(10)		| 업체ID(20)	| NetCancID		|
				* 
				****************************************************************************/

				$this->ENCTYPE = H;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/
				$this->sDataMsg = $this->ENCTYPE.
					"MobileCanReq"."|".
					$this->GetResult("StoreId")."|".
					$this->GetResult("NetCancID")."|";
					
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make Cancel MSG OK " );
		
		}else if( strcmp( $this->REQUEST["AuthTy"], "ars" ) == 0 ){
				
				/****************************************************************************
				* 
				* [4] ARS 취소처리
				* 
				* -- 이부분은 ARS 결제 취소처리를 위해 암호화Process와 Socket통신하는 부분이다.
				* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
				* -- 데이터 길이는 매뉴얼 참고
				* 
				* -- ARS 결제 요청 전문 포멧
				* + 데이터길이(6) + 암호화여부(1) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.)
				* 결제종류(10)		| 업체ID(20)	| NetCancID		|
				* 
				****************************************************************************/

				$this->ENCTYPE = A;
				
				/****************************************************************************
				* 
				* 전송 전문 Make
				* 
				****************************************************************************/
				$this->sDataMsg = $this->ENCTYPE.
					"ARSCanReq"."|".
					$this->GetResult("StoreId")."|".
					$this->GetResult("NetCancID")."|";
					
				$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Make Cancel MSG OK " );
		
		}else{
			//신용카드,계좌이체 이외의 결제수단은 취소기능 적용되지 않음.
			$this->log->WriteLog( WARN, "Cancel Passed. AuthTy : [".$this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]."] " );
			$this->RESULT["rCancelSuccYn"] = "n";
			$this->RESULT["rCancelResMsg"] = "Cannot Cancel AuthTy[".$this->REQUEST["AuthTy"]."]";					
			return false;
		}
		$this->log->WriteLog( INFO, "Make Cancel Msg End" );
		return true;
	}	//MakeCancelMsg End


	/*
		RecvMsg Parsing                       
	*/
 	function ParseMsg() 
	{
		$this->log->WriteLog( INFO, "Parse Msg Start" );
		/****************************************************************************
		* ※ 결제 형태 변수의 값에 따른 결제 구분
		*
		* ＊ AuthTy  = "card"		신용카드결제
		*	 - SubTy = "isp"		안전결제ISP
		*	 - SubTy = "visa3d"		안심클릭
		*	 - SubTy = "normal"		일반결제
		*
		* ＊ AuthTy  = "iche"		일반-계좌이체
		* 
		* ＊ AuthTy  = "virtual"	일반-가상계좌(무통장입금)
		* 
		* ＊ AuthTy  = "hp"			핸드폰결제
		*
		* ＊ AuthTy  = "ars"		ARS결제
		*
		****************************************************************************/
		
		if( strcmp( $this->REQUEST["AuthTy"], "card" ) == 0 )
		{
			if( strcmp( $this->REQUEST["SubTy"], "isp" ) == 0 )
			{
				/****************************************************************************
				*
				*  [1-1] 신용카드 안전결제ISP 처리
				* 
				* 
				* -- 승인 응답 전문 포멧
				* + 데이터길이(6) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 한다.
				* 업체ID(20)		| 전문코드(4)		| 거래고유번호(6)		| 승인번호(8)		| 
				* 거래금액(12)	| 성공여부(1)	 	| 실패사유(20)		| 승인시각(14)	| 
				* 카드사코드(4)	|
				*    
				****************************************************************************/
								
				$this->RESULT["rStoreId"] = $this->RecvValArray[0];
				$this->RESULT["rBusiCd"] = $this->RecvValArray[1];
				$this->RESULT["rOrdNo"] = $this->REQUEST["OrdNo"];
				$this->RESULT["rDealNo"] = $this->RecvValArray[2];
				$this->RESULT["rApprNo"] = $this->RecvValArray[3];
				$this->RESULT["rProdNm"] = $this->REQUEST["ProdNm"];
				$this->RESULT["rAmt"] = $this->RecvValArray[4];
				$this->RESULT["rInstmt"] = $this->REQUEST["KVP_QUOTA"];
				$this->RESULT["rSuccYn"] = $this->RecvValArray[5];
				$this->RESULT["rResMsg"] = $this->RecvValArray[6];
				$this->RESULT["rApprTm"] = $this->RecvValArray[7];
				$this->RESULT["rCardCd"] = $this->RecvValArray[8];	
				
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." "."RECV MSG Parsing OK " );
			}
			else if( ( strcmp( $this->REQUEST["SubTy"], "visa3d" ) == 0 ) || ( strcmp( $this->REQUEST["SubTy"], "normal" ) == 0 ) )
			{
				/****************************************************************************
				* 
				* [1-2] 안심클릭 or 일반결제 처리 승인응답 전문포맷
				* + 데이터길이(6) + 데이터
				* + 데이터 포멧(데이터 구분은 "|"로 하며 암호화Process에서 해독된후 실데이터를 수신하게 된다.
				* 업체ID(20)		| 전문코드(4)		 | 주문번호(40)	| 승인번호(8)		| 거래금액(12)  |
				* 성공여부(1)		| 실패사유(20)	 | 카드사명(20) 	| 승인시각(14)	| 카드사코드(4)	|
				* 가맹점번호(15)	| 매입사코드(4)	 | 매입사명(20)	| 전표번호(6)		|
				* 
				****************************************************************************/
				
				$this->RESULT["rStoreId"] = $this->RecvValArray[0];
				$this->RESULT["rBusiCd"] = $this->RecvValArray[1];
				$this->RESULT["rOrdNo"] = $this->RecvValArray[2];
				$this->RESULT["rApprNo"] = $this->RecvValArray[3];
				$this->RESULT["rInstmt"] = $this->REQUEST["Instmt"];
				$this->RESULT["rAmt"] = $this->RecvValArray[4];
				$this->RESULT["rSuccYn"] = $this->RecvValArray[5];
				$this->RESULT["rResMsg"] = $this->RecvValArray[6];
				$this->RESULT["rCardNm"] = $this->RecvValArray[7];
				$this->RESULT["rApprTm"] = $this->RecvValArray[8];
				$this->RESULT["rCardCd"] = $this->RecvValArray[9];
				$this->RESULT["rMembNo"] = $this->RecvValArray[10];
				$this->RESULT["rAquiCd"] = $this->RecvValArray[11];
				$this->RESULT["rAquiNm"] = $this->RecvValArray[12];
				$this->RESULT["rDealNo"] = $this->RecvValArray[13];
				$this->RESULT["rProdNm"] = $this->REQUEST["ProdNm"];
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." "."RECV MSG Parsing OK " );
			}
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "iche" ) == 0 && strcmp( $this->REQUEST["ICHE_SOCKETYN"], "Y" ) == 0)
		{
			/****************************************************************************
			* 
			* [2-1] 계좌이체 소켓방식(인터넷뱅킹) 결제 요청 응답 전문 포멧
			* + 데이터길이(6) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 하며 암호화Process에서 해독된후 실데이터를 수신하게 된다.
			* 결제종류(10)		| 상점아이디(20)	| 주문번호(40)	| 이용기관주문번호(50)	| 결과코드(4)  | 결과메시지(300)  |
			* 
			****************************************************************************/
				
			$this->RESULT["rStoreId"] = $this->RecvValArray[1];
			$this->RESULT["rOrdNo"] = $this->RecvValArray[2];
			$this->RESULT["rMTid"] = $this->RecvValArray[3];
			$this->RESULT["ES_SENDNO"] = $this->RecvValArray[4];
			$this->RESULT["rSuccYn"] = $this->RecvValArray[5];
			$this->RESULT["rResMsg"] = $this->RecvValArray[6];
			$this->RESULT["rAmt"] = $this->REQUEST["Amt"];
			$this->RESULT["rProdNm"] = $this->REQUEST["ProdNm"];
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."RECV MSG Parsing OK " );
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "iche" ) == 0 && strcmp( $this->REQUEST["ICHEARS_SOCKETYN"], "Y" ) == 0)
		{
			/****************************************************************************
			* 
			* [2-2] 계좌이체 텔레뱅킹 처리
			*
			* -- 텔레뱅킹 결제 요청 응답 전문 포멧
			* + 데이터길이(6) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 하며 암호화Process에서 해독된후 실데이터를 수신하게 된다.
			* 결제종류(10)	| 상점아이디(20)	| 주문번호(40)	| 이용기관주문번호(50)	| 결과코드(4)  | 결과메시지(300)  |* 
			*
			****************************************************************************/
			
			$this->RESULT["rStoreId"] = $this->RecvValArray[1];
			$this->RESULT["rOrdNo"] = $this->RecvValArray[2];
			$this->RESULT["rMTid"] = $this->RecvValArray[3];
			$this->RESULT["rSuccYn"] = $this->RecvValArray[4];
			$this->RESULT["rResMsg"] = $this->RecvValArray[5];
			$this->RESULT["rAmt"] = $this->REQUEST["Amt"];
			$this->RESULT["rProdNm"] = $this->REQUEST["ProdNm"];
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Parse MSG Passed " );
				
			$pos = strpos($this->RESULT["rResMsg"],':');
			if( $pos !== false ) 
			{
				$this->RESULT["ES_SENDNO"] = substr($this->RESULT["rResMsg"],$pos+1,6) ;
				$this->log->WriteLog( INFO, "ES_SENDNO : [".$this->RESULT["ES_SENDNO"]."] ");
			}				
							
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "virtual" ) == 0 ) 
		{
			/****************************************************************************
			*
			* [3] 가상계좌(무통장입금) 처리
			* 
			* -- 승인 응답 전문 포멧
			* + 데이터길이(6) + 암호화 구분(1) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 한다.
			* 결제종류(10)	| 업체ID(20)		| 승인일자(14)	| 가상계좌번호(20)	| 결과코드(1)		| 결과메시지(100)	 | 
			*
			****************************************************************************/
			
			$this->RESULT["rAuthTy"]    = $this->RecvValArray[0];
			$this->RESULT["rStoreId"]   = $this->RecvValArray[1];
			$this->RESULT["rApprTm"]    = $this->RecvValArray[2];
			$this->RESULT["rVirNo"]     = $this->RecvValArray[3];
			$this->RESULT["rSuccYn"]    = $this->RecvValArray[4];
			$this->RESULT["rResMsg"]    = $this->RecvValArray[5];
			
			$this->RESULT["rOrdNo"] = $this->REQUEST["OrdNo"];
			$this->RESULT["rProdNm"] = $this->REQUEST["ProdNm"];
			$this->RESULT["rAmt"] = $this->REQUEST["Amt"];
			
			$pos = strpos($this->RESULT["rResMsg"],':');
			if( $pos !== false ) 
			{
				$this->RESULT["ES_SENDNO"] = substr($this->RESULT["rResMsg"],$pos+1,6) ;
				$this->log->WriteLog( INFO, "ES_SENDNO : [".$this->RESULT["ES_SENDNO"]."] ");
			}
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."RECV MSG Parsing OK " );
			
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "hp" ) == 0 )
		{
			/****************************************************************************
			* 
			* [4] 핸드폰 결제
			*
			*  -- 승인 응답 전문 포멧
			*  + 데이터길이(6) + 데이터
			*  + 데이터 포멧(데이터 구분은 "|"로 한다.)
			* 업체ID(20)	| 결과코드(1)	| 결과메시지(100)	 | 핸드폰결제일(8)	 | 핸드폰결제 TID(12)	 | 거래금액(12)	 | 주문번호(40)	 |
			*
			****************************************************************************/
			
			$this->RESULT["rStoreId"] = $this->RecvValArray[0];	
			$this->RESULT["rSuccYn"] = $this->RecvValArray[1];
			$this->RESULT["rResMsg"] = $this->RecvValArray[2];
			$this->RESULT["rHP_DATE"] = $this->RecvValArray[3];
			$this->RESULT["rHP_TID"] = $this->RecvValArray[4];
			$this->RESULT["rAmt"] = $this->REQUEST["Amt"];
			$this->RESULT["rOrdNo"] = $this->REQUEST["OrdNo"];
			$this->RESULT["rProdNm"] = $this->REQUEST["ProdNm"];
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."RECV MSG Parsing OK " );

		}
		else if( strcmp( $this->REQUEST["AuthTy"], "ars" ) == 0 )
		{
			/****************************************************************************
			* 
			* [5] ARS 결제
			*
			*  -- 승인 응답 전문 포멧
			*  + 데이터길이(6) + 데이터
			*  + 데이터 포멧(데이터 구분은 "|"로 한다.)
			* 업체ID(20)	| 결과코드(1)	| 결과메시지(100)	 | ARS결제일(8)	 | ARS결제 TID(12)	 | 거래금액(12)	 | 주문번호(40)	 |
			*
			****************************************************************************/
			
			$this->RESULT["rStoreId"] = $this->RecvValArray[0];	
			$this->RESULT["rSuccYn"] = $this->RecvValArray[1];
			$this->RESULT["rResMsg"] = $this->RecvValArray[2];
			$this->RESULT["rHP_DATE"] = $this->RecvValArray[3];
			$this->RESULT["rHP_TID"] = $this->RecvValArray[4];
			$this->RESULT["rAmt"] = $this->REQUEST["Amt"];
			$this->RESULT["rOrdNo"] = $this->REQUEST["OrdNo"];
			$this->RESULT["rProdNm"] = $this->REQUEST["ProdNm"];
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."RECV MSG Parsing OK " );
		}else{
			$this->log->WriteLog( FATAL, "Unknown AuthTy. AuthTy:[".$this->REQUEST["AuthTy"]."],SubTy:[".$this->REQUEST["SubTy"]."]");
			return false;
		}
		$this->log->WriteLog( INFO, "Parse Msg End" );
		return true;
		
	}	//ParseMsg() End


	/*
		RecvCancelMsg Parsing                       
	*/
 	function ParseCancelMsg() 
	{
		$this->log->WriteLog( INFO, "Parse Cancel Msg Start" );
		if( strcmp( $this->REQUEST["AuthTy"], "card" ) == 0 )
		{
			if( strcmp( $this->REQUEST["SubTy"], "isp" ) == 0 )
			{
				/* [1-1] 안전결제ISP 처리 */					

				$this->RESULT["rStoreId"] = $this->RecvValArray[0];
				$this->RESULT["rApprNo"] = $this->RecvValArray[1];
				$this->RESULT["rApprTm"] = $this->RecvValArray[2];
				$this->RESULT["rBusiCd"] = $this->RecvValArray[3];
				$this->RESULT["rDealNo"] = $this->RecvValArray[4];
				$this->RESULT["rCancelSuccYn"] = $this->RecvValArray[5];
				$this->RESULT["rCancelResMsg"] = $this->RecvValArray[6];
				
				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." "."RECV MSG Parsing OK " );
			}
			else if( ( strcmp( $this->REQUEST["SubTy"], "visa3d" ) == 0 ) || ( strcmp( $this->REQUEST["SubTy"], "normal" ) == 0 ) )
			{
				/* [1-2] 안심클릭 or 일반결제 처리 */	
				$this->RESULT["rStoreId"] = $this->RecvValArray[0];
				$this->RESULT["rApprNo"] = $this->RecvValArray[1];
				$this->RESULT["rApprTm"] = $this->RecvValArray[2];
				$this->RESULT["rBusiCd"] = $this->RecvValArray[3];
				$this->RESULT["rCancelSuccYn"] = $this->RecvValArray[4];
				$this->RESULT["rOrdNo"] = $this->RecvValArray[5];
				$this->RESULT["rInstmt"] = $this->RecvValArray[6];
				$this->RESULT["rAmt"] = $this->RecvValArray[7];
				$this->RESULT["rCardNm"] = $this->RecvValArray[8];
				$this->RESULT["rCardCd"] = $this->RecvValArray[9];
				$this->RESULT["rMembNo"] = $this->RecvValArray[10];
				$this->RESULT["rAquiCd"] = $this->RecvValArray[11];
				$this->RESULT["rAquiNm"] = $this->RecvValArray[12];
				$this->RESULT["rDealNo"] = $this->RecvValArray[13];

				if($this->RESULT["rCancelSuccYn"] == "y")
				{
					$this->RESULT["rCancelResMsg"] = "정상취소";
				}
				else
				{
					$this->RESULT["rCancelResMsg"] = "취소실패";
				}


				$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." "."RECV MSG Parsing OK " );
			}
		
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "iche" ) == 0 && strcmp( $this->REQUEST["ICHE_SOCKETYN"], "Y" ) == 0)
		{
			/* [2-1] 계좌이체 인터넷뱅킹 취소*/	
			/* 	[RB-CanRes|상점ID|posmTid|주문번호|y|취소성공|] */
			$this->RESULT["rStoreId"] = $this->RecvValArray[1];
			$this->RESULT["ICHE_POSMTID"] = $this->RecvValArray[2];
			$this->RESULT["rOrdNo"] = $this->RecvValArray[3];
			$this->RESULT["rCancelSuccYn"] = $this->RecvValArray[4];
			$this->RESULT["rCancelResMsg"] = $this->RecvValArray[5];				

		}
		else if( strcmp( $this->REQUEST["AuthTy"], "iche" ) == 0 && strcmp( $this->REQUEST["ICHEARS_SOCKETYN"], "Y" ) == 0)
		{
			/* [2-2] 계좌이체 텔레뱅킹 취소*/	
			/* 	[TB-CanRes|상점ID|posmTid|주문번호|y|취소성공|] */
			$this->RESULT["rStoreId"] = $this->RecvValArray[1];
			$this->RESULT["rMTid"] = $this->RecvValArray[2];
			$this->RESULT["rCancelSuccYn"] = $this->RecvValArray[3];
			$this->RESULT["rCancelResMsg"] = $this->RecvValArray[4];						
			
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "hp" ) == 0 )
		{
			/****************************************************************************
			*
			* [4] 핸드폰 결제 취소
			*
			* -- 취소 응답 전문 포멧
			* + 데이터길이(6) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 하며 암호화Process에서 해독된후 실데이터를 수신하게 된다.
			* |	MobileCanRes	|	업체ID(20)	| 성공여부(1)	|	결과메세지	|	취소처리일시	|	이용기관주문번호	|
			*		   
			****************************************************************************/
			
			/* 	[MobileCanRes|상점ID|결과(y/n)|결과메세지|취소일시|이용기관주문번호|] */
			$this->RESULT["rStoreId"] = $this->RecvValArray[1];
			$this->RESULT["rCancelSuccYn"] = $this->RecvValArray[2];
			$this->RESULT["rCancelResMsg"] = $this->RecvValArray[3];
			$this->RESULT["rCancelDate"] = $this->RecvValArray[4];
			$this->RESULT["rTid"] = $this->RecvValArray[5];						
			
		}
		else if( strcmp( $this->REQUEST["AuthTy"], "ars" ) == 0 )
		{
			/****************************************************************************
			*
			* [5] ARS 결제 취소
			*
			* -- 취소 응답 전문 포멧
			* + 데이터길이(6) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 하며 암호화Process에서 해독된후 실데이터를 수신하게 된다.
			* |	ArsCanRes	|	업체ID(20)	| 성공여부(1)	|	결과메세지	|	취소처리일시	|	이용기관주문번호	|
			*		   
			****************************************************************************/
			
			/* 	[ArsCanRes|상점ID|결과(y/n)|결과메세지|취소일시|이용기관주문번호|] */
			$this->RESULT["rStoreId"] = $this->RecvValArray[1];
			$this->RESULT["rCancelSuccYn"] = $this->RecvValArray[2];
			$this->RESULT["rCancelResMsg"] = $this->RecvValArray[3];
			$this->RESULT["rCancelDate"] = $this->RecvValArray[4];
			$this->RESULT["rTid"] = $this->RecvValArray[5];						
			
		}
		else
		{
			$this->log->WriteLog( INFO, $this->REQUEST["AuthTy"]." "."Parse CancelMSG Passed " );
			$this->RESULT["rCancelSuccYn"] = "n";
			$this->RESULT["rCancelResMsg"] = "Cannot Cancel AuthTy[".$this->REQUEST["AuthTy"]."]";	
			return false;
		}
		$this->log->WriteLog( INFO, "Parse Cancel Msg End" );
		return true;
	}


	/*
		망취소 요청                       
	*/
 	function NetCancel() 
	{
		$this->log->WriteLog( WARN, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." Cancel Start");
		
		if( $this->REQUEST["UseNetCancel"] == "true" || $this->REQUEST["Type"] == "Cancel" )
		{
			$this->log->WriteLog( WARN, "Cancel Reason : ".$this->REQUEST["CancelMsg"]);	
			
			if( !($this->MakeCancelMsg()) )
			{
				$this->log->WriteLog( ERROR, "Make CancelMsg Error");
				return false;
			}
			if( !($this->SendRecvMsg()) )
			{
				$this->log->WriteLog( ERROR, "Send & Recv Msg Error");
				return false;
			}
			if( !($this->ParseCancelMsg()) )
			{
				$this->log->WriteLog( ERROR, "ParseCancelMsg Error");
				return false;
			}
			if( $this->RESULT["rCancelSuccYn"] == "y")
			{
				$this->log->WriteLog( WARN, "Cancel Success");
			}
			else
			{
				$this->log->WriteLog( FATAL, "Cancel FAIL");
			}
		}
		else
		{
			$this->log->WriteLog( WARN, "Cancel Passed (UseNetCancel value Is false)");
		}
		
		$this->log->WriteLog( WARN, $this->REQUEST["AuthTy"]."-".$this->REQUEST["SubTy"]." Cancel End");
		
		if($this->RESULT["rCancelSuccYn"] == "y"){
			//결제결과값 실패로 설정
			$this->SetPayResult( "rSuccYn", "n" );
			$this->SetPayResult( "rResMsg", $this->REQUEST["CancelMsg"] );
			return true;
		}else{
			return false;
		}
		
	}

	/*
		데이터 확인요청                       
	*/
 	function checkPayResult( $TID ) 
	{
		/*
			Log 기록 객체생성						
   		*/
		$this->log = new PayLog( $this->REQUEST );
		if(!$this->log->InitLog()) 
		{
			$this->ERRMSG .= "로그파일을 열수가 없습니다.[".$this->REQUEST["AgsPayHome"]."]" ; 
			$this->RESULT["rSuccYn"] = "n";
			$this->RESULT["rResMsg"] = $this->ERRMSG;
			$this->RESULT["rCancelSuccYn"] = "n";
			$this->RESULT["rCancelResMsg"] = $this->ERRMSG;
			return false;
		}

		$this->log->WriteLog( INFO, "[".$TID."] Check PayResult Start");
		
		
		//"AEGIS_".$TidTp . $this->REQUEST["StoreId"] . $datestr . rand(100,999);
				
		switch(substr($TID,6,4)){
		  case("ISP_"): 			// 신용카드 ISP
			$this->REQUEST["AuthTy"] = "card" ;
			$this->REQUEST["SubTy"] = "isp" ;
			break;
		  case("VISA"): 			// 신용카드 안심클릭/일반
			$this->REQUEST["AuthTy"] = "card" ;
			$this->REQUEST["SubTy"] = "visa3d" ;
			break;
		  case("IBK_"): 			// 인터넷뱅킹
			$this->REQUEST["AuthTy"] = "iche" ;
			break;
		  case("TBK_"): 			// 텔레뱅킹
			$this->REQUEST["AuthTy"] = "iche" ;
			break;
		  case("VIR_"): 			// 가상계좌
			$this->REQUEST["AuthTy"] = "virtual" ;
			break;
		  case("HPP_"): 			// 휴대폰 결제
			$this->REQUEST["AuthTy"] = "hp" ;
			break;
		  case("ARS_"): 			// ARS 전화결제
			$this->REQUEST["AuthTy"] = "ars" ;
			break;
		  default: 			// 미확인 결제방식
			$this->REQUEST["AuthTy"] = "unknown" ;
			break;
		}  
		
		/****************************************************************************
		* 전송 전문 Make
		****************************************************************************/
		$this->ENCTYPE = "I";
		
		$this->sDataMsg = $this->ENCTYPE.
			"PayInfo"."|".
			$this->REQUEST["StoreId"]."|".
			$TID."|";

		$this->sSendMsg = sprintf( "%06d%s", strlen( $this->sDataMsg ), $this->sDataMsg );
		
		if( !($this->SendRecvMsg()) )	//소켓을 통해 거래결과 확인
		{
			if( !($this->SendRecvMsgWeb()) )	//웹을 통해 거래결과 확인
			{
				
			}
		}
		
		if( !($this->ParseMsg()) )
		{
			$this->log->WriteLog( ERROR, "Parse Check PayResult Error");
			return false;
		}
		
		$this->log->WriteLog( INFO, "[".$TID."] Check PayResult End");
		
		$this->writeLogArray($this->RESULT);

		//log 객체 닫기
		$this->log->CloseLog( $this->GetResult("rResMsg") );

		return true;
	}


	/*
		결제데이터 Set                      
	*/
 	function SetValue( $key, $val ) 
	{
		$this->REQUEST[$key] = $val;
	}

	/*
		결제데이터 Get                      
	*/
 	function GetResult( $name ) 
	{
		$result = $this->RESULT[$name];
		if( strlen($result) == 0 || $result == "") $result = $this->REQUEST[$name];
		return $result;
	}

	/*
		결제결과 rSuccYn Set                      
	*/
 	function SetPayResult( $key, $val ) 
	{
		$this->RESULT[$key] = $val;
	}

	/*
		Make NetCancel ID();
	*/

	function MakeNetCancID()
	{
		$this->log->WriteLog( INFO, "Make NetCancel ID Start" );
		switch($this->REQUEST["AuthTy"]){
		  case("card"): 			// 신용카드
			if( strcmp( $this->REQUEST["SubTy"], "isp" ) == 0 )	$TidTp = "ISP_"; else  $TidTp = "VISA"; 
			break;
		  case("iche"): 		// 은행 계좌 이체 (IBK:인터넷뱅킹, TBK:텔레뱅킹)
			if( strcmp( $this->REQUEST["ICHE_SOCKETYN"], "Y" ) == 0 ) $TidTp = "IBK_"; else $TidTp = "TBK_";
			break;
		  case("virtual"): 		// 가상계좌
			$TidTp = "VIR_"; break;
		  case("hp"): 			// 휴대폰 결제
			$TidTp = "HPP_"; break;
		  case("ars"): 			// ARS 전화결제
			$TidTp = "ARS_"; break;
		  default:        	
			$TidTp = "UNKW";	//미확인 결제방식
		}

		list($usec, $sec) = explode(" ", microtime());
		$datestr = date("YmdHis", $sec).substr($usec,2,3); //YYYYMMDDHHMMSSSSS

		//TID는 최소 31자리 ,최대 51자리를 넘지 않는다.
		$this->RESULT["NetCancID"] = "AEGIS_".$TidTp . $this->REQUEST["StoreId"] . "_" . $datestr . rand(100,999);
		if( (!strlen( $this->RESULT["NetCancID"] ) >= 31 && strlen( $this->RESULT["NetCancID"] ) <= 51) )
		{
			$this->log->WriteLog( ERROR, $this->RESULT["NetCancID"]);
			return false;
		}
		$this->log->WriteLog( INFO, $this->RESULT["NetCancID"]);
		$this->log->WriteLog( INFO, "Make NetCancel ID End" );
		return true;
	}

	/*
		Set Error Msg ;
	*/
	function SetErrorMsg($rSuccYn,$rResMsg)
	{	
		$this->log->WriteLog( INFO, "Set Result Msg Start");
		$this->RESULT["rSuccYn"] = $rSuccYn;
		$this->RESULT["rResMsg"] = $rResMsg;
		$this->log->WriteLog( INFO, "Set Result Msg End");
	}

	/*
		Aegis 카드데이터 Encrypt
	*/
	function encrypt_aegis( $OrgData )
	{
		$this->log->WriteLog( INFO, "Encrypt Start");
		if( empty( $OrgData ) || $OrgData == "" ) 
		{
			$this->log->WriteLog( INFO, "Encrypt End");
			return "";
		}
		
		$temp = "";
		for( $i = 0; $i < strlen( $OrgData ); $i++ )
		{
			$temp .= substr( $OrgData, (strlen( $OrgData ) - 1) - $i, 1 );
		}

		//print "Reverse data : ".$temp."<br>";

		$one_char = "";
		$EncData  = "";
		for( $i = 0; $i < strlen( $temp ); $i++ )
		{
			$one_char = substr( $temp, $i, 1 );
			$EncData  .= ($one_char + $i * 77) % 10 ;
		}

		//print "Enc Data : ".$EncData."<br>";

		$this->log->WriteLog( INFO, "Encrypt End");

		return $EncData;
	}

	/*
		문자열 포멧
	*/
	function format_string($TSTR,$TLEN,$TAG)
	{
		if ( !isset($TSTR) ) 
		{
			for ( $i=0 ; $i < $TLEN ; $i++ ) 
			{
				if( $TAG == 'Y' ) 
				{
					$TSTR = $TSTR.chr(32);
				} 
				else 
				{
					$TSTR = $TSTR.'+';
				}
			}
		}
		
		$TSTR = trim($TSTR);
		
		$TSTR = stripslashes($TSTR); 
		
		// 입력자료가 길이보다 긴 경우 자르고 한글처리
		
		if ( strlen($TSTR) > $TLEN ) 
		{
			// $flag == 1 이면 그 바이트는 한글의 시작 바이트 이라서 거기까지 자르게 되면 
			// 한글이 깨지게 되는 현상이 발생합니다. 
			
			$flag = 0;
			
			for($i=0 ; $i< $TLEN ; $i++) 
			{ 
				$j = ord($TSTR[$i]); // 문자의 ASCII 값을 구합니다. 
									 // 구한 ASCII값이 127보다 크면 그 바이트가 한글의 시작바이트이거나 끝바이트(?)라는 뜻이죠. 
				if($j > 127) 
				{ 
					if( $flag ) $flag = 0; // $flag 값이 존재한다는 것은 이번 문자는 한글의 끝바이트이기 때문에 
										   // $flag 를 0으로 해줍니다. 
					else $flag = 1;        // 값이 존재하지 않으면 한글의 시작바이트이죠. 그러므로 $flag 는 1! 
				}
				else $flag = 0; // 다른 숫자나 영문일때는 그냥 넘어가면 되겠죠. 
			} 
			if( $flag ) 
			{
				// 이렇게 해서 마지막 문자까지의 $flag를 계산해서 $flag가 존재하면 
				$TSTR = substr($TSTR, 0, $TLEN - 1);
				if( $TAG == 'Y' ) 
				{
					$TSTR = $TSTR.chr(32);
				}
				else 
				{
					$TSTR = $TSTR.'+';
				}
			} 
			else 
			{
				// 한바이트를 더해서 자르던지 빼서 자르던지 해야겠죠. 
				$TSTR = substr($TSTR, 0, $TLEN); // 아님 말구.... 
			}
			
			return $TSTR; // 이제 결정된 스트링을 반환합니다.   
			
			// 입력자료가 길이보다 작은 경우 SPACE로 채운다
		} 
		else if ( strlen($TSTR) < $TLEN ) 
		{ 
			$TLENGTH = strlen($TSTR);
			for ( $i=0 ; $i < $TLEN - $TLENGTH; $i++ ) 
			{
				if( $TAG == 'Y' ) 
				{
					$TSTR = $TSTR.chr(32);
				} 
				else 
				{
					$TSTR = $TSTR.'+';
				}
			}
			
			return ($TSTR);
			
			// 입력자료가 길이와 같은경우
		} 
		else if ( strlen($TSTR) == $TLEN ) 
		{
			return ($TSTR);  
		}
	}

	/* 
		입력한 글자가 숫자아스키값에 해당하는지 판단.
	*/
	function IsNumber($word)
	{
		
		for($i = 0; $i < strlen($word); $i++)
		{
			$wordNum = ord( substr( $word, $i, 1 ) );

			if( $wordNum < 48 || $wordNum > 57 ) 
			{
				return false;
			}

		}

		return true;
	}
	/* 
		경고 메세지
	*/
	function AlertMsg( $msg , $go=0)
	{

		$msg = str_replace( "\"" ,"'" ,$msg );
		$msg = str_replace( "\n" ,"\\n" ,$msg );
		print "<script language='javascript'>";
		print "alert( '".$msg."' );";
		if( $go < 0 )
			print "history.go( ".$go." );";
		print "</script>";

	}
	function HistoryGo( $go )
	{
		print "<script language='javascript'>";
		print "history.go( ".$go." );";
		print "</script>";
	}

	function AlertExit( $msg )
	{

		AlertMsg( $msg );
		exit;

	}

	function AlertGoBack( $msg )
	{
		
		AlertMsg( $msg, -1);
		exit;
	}

}

/**************************************************************************************
*
* 올더게이트 결제로그 기록 클래스
* 
***************************************************************************************/	
class PayLog 
{
	var $log_fd;
	var $log;
	var $logLevel;
	var	$array_key;
	var $debug_msg;
	var $starttime;
	var $homedir;
	var $StoreId;

	function PayLog( $request )
	{
		$this->debug_msg = array( "", "FATAL", "ERROR", "WARN", "INFO", "DEBUG"  );
		$this->log = $request["log"];
		$this->logLevel = $request["logLevel"];
		$this->homedir = $request["AgsPayHome"];
		$this->StoreId = $request["StoreId"];
		$this->starttime=GetTime();
	}
	function InitLog() 
	{
		if( $this->log == "false" ) return true;

		$logfile = $this->homedir. "/log/".PROGRAM."_".TYPE."_".$this->StoreId."_".date("ymd").".log";
		
		$this->log_fd = fopen( $logfile, "a+" );
		if( !$this->log_fd ) return false;
		$this->WriteLog( INFO, "===============================================================" );
		$this->WriteLog( INFO, "START ".PROGRAM." ".TYPE." (OS:".php_uname('s').php_uname('r').",PHP:".phpversion().")" );
		return true;
	}
	function WriteLog($debug, $data) 
	{
		if( $this->log == "false" || !$this->log_fd ) return;

		if(strtoupper($this->logLevel) == "FATAL") $logLevel_int = 1;
		if(strtoupper($this->logLevel) == "ERROR") $logLevel_int = 2;
		if(strtoupper($this->logLevel) == "WARN") $logLevel_int = 3;
		if(strtoupper($this->logLevel) == "INFO") $logLevel_int = 4;
		if(strtoupper($this->logLevel) == "DEBUG") $logLevel_int = 5;
		
		if( $debug > $logLevel_int ){	return;    	}

		$prefix = $this->debug_msg[$debug]."\t[" . SetTimeStamp() . "] <" . getmypid() . "> ";
		if( is_array( $data ) )
		{
			foreach ($data as $key => $val)
			{
				fwrite( $this->log_fd, $prefix . $key . ":" . $val . "\r\n");
			}
		}
		else
		{
		   fwrite( $this->log_fd, $prefix . $data . "\r\n" );
		}
		fflush( $this->log_fd );
	}
	function CloseLog($msg)
	{
		if( $this->log == "false" ) return;

		$Transaction_time=GetTime()-$this->starttime;
		$this->WriteLog( INFO, "END ".$this->REQUEST["Type"]." ".$msg." Transaction time:[".round($Transaction_time,3)."sec]" );
		$this->WriteLog( INFO, "===============================================================" );
		fclose( $this->log_fd );
	}
}

function GetTime()
{
    list($sec1, $sec2) = explode(" ", microtime(true));
    return (float)$sec1 + (float)$sec2;
}

function SetTimeStamp()
{
    $microtm = explode(' ',microtime());
    list($t_Seconds, $Milliseconds) = array($microtm[1], (int)round($microtm[0]*1000,3));
		return date("Y-m-d H:i:s", $t_Seconds) . ":$Milliseconds";
} 

?>