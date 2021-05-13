<?php
// : 결제정보 불러오기
$pay_row = sql_fetch("select * from alice_payment where `no`='".addslashes($pno)."'");
$_post_un = unserialize(stripslashes($pay_row['post_un']));
// : 가격체크
$get_price = $netfu_payment->get_service_type($_post_un);

if($pay_row['pay_price']!=$get_price['use_price_hap']) {
	$arr['msg'] = "금액이 맞지 않습니다. 다시 시도해주시기 바랍니다.";
	return false;
}




	require(NFE_PATH."/plugin/PG/inicis/mobile/libs/INImx.php");
	
	$inimx = new INImx;


	/////////////////////////////////////////////////////////////////////////////
	///// 1. 변수 초기화 및 POST 인증값 받음                                 ////
	/////////////////////////////////////////////////////////////////////////////
	
	$inimx->reqtype 		= "PAY";  //결제요청방식
	$inimx->inipayhome 	= NFE_PATH."/plugin/PG/inicis/mobile"; //로그기록 경로 (이 위치의 하위폴더에 log폴더 생성 후 log폴더에 대해 777 권한 설정)
	$inimx->status			= $P_STATUS;
	$inimx->rmesg1			= $P_RMESG1;
	$inimx->tid		= $P_TID;
	$inimx->req_url		= $P_REQ_URL;
	$inimx->noti		= $P_NOTI;
	
	
	/////////////////////////////////////////////////////////////////////////////
	///// 2. 상점 아이디 설정 :                                              ////
	/////    결제요청 페이지에서 사용한 MID값과 동일하게 세팅해야 함...      ////
	/////    인증TID를 잘라서 사용가능 : substr($P_TID,'10','10');           ////
	/////////////////////////////////////////////////////////////////////////////
	$inimx->id_merchant = substr($P_TID,'10','10');  //
	
	/////////////////////////////////////////////////////////////////////////////
	///// 3. 인증결과 확인 :                                                 ////
	/////    인증값을 가지고 성공/실패에 따라 처리 방법                      ////
	/////////////////////////////////////////////////////////////////////////////
  if($inimx->status =="00")   // 모바일 인증이 성공시
  {


	/////////////////////////////////////////////////////////////////////////////
	///// 4. 승인요청 :                                                      ////
	/////    인증성공시  P_REQ_URL로 승인요청을 함...                        ////
	/////////////////////////////////////////////////////////////////////////////
	$inimx->startAction();  // 승인요청
	$inimx->getResult();  //승인결과 파싱, P_REQ_URL에서 내려준 결과값 파싱 

	$result = $payment_control->payment_status($inimx);
	$_pay_result = true;
	return false;

  }else{

	$update = sql_query("update alice_payment set `pg_un`='".base64_encode(serialize($resultMap))."' where `no`='".addslashes($pno)."'");
	return false;
  }
	  
	  /**
	  결과값 파싱 전문은 INImx내 변수로 담아 표현하고 있습니다. ( 메뉴얼얼내 값 대조하여 필요한 값 저장할 수 있도록 부탁드립니다.)
	  
	      --공통
				$this->m_tid  = $resultString['P_TID'];                                     // 거래번호
				$this->m_resultCode = $resultString['P_STATUS'];                            // 거래상태 - 지불결과 성공:00, 실패:00 이외 실패
				$this->m_resultMsg  = $resultString['P_RMESG1'];                            // 지불 결과 메시지
				$this->m_cardQuota  = $resultString['P_RMESG2'];                            // 신용카드 할부 개월 수 (메뉴얼 확인 필요)
				$this->m_payMethod = $resultString['P_TYPE'];                               // 지불수단 
				$this->m_mid  = $resultString['P_MID'];                                     // 상점아이디
				$this->m_moid  = $resultString['P_OID'];                                    // 상점주문번호
				$this->m_resultprice = $resultString['P_AMT'];                              // 거래금액
				$this->m_buyerName  = $resultString['P_UNAME'];                             // 구매자명
				$this->m_nextUrl  = $resultString['P_NEXT_URL'];                            // 가맹점 전달 P_NEXT_URL 
				$this->m_notiUrl  = $resultString['P_NOTEURL'];                             // 가맹점 전달 NOTE_URL --->>이거도 설명 에매하네 
				$this->m_authdt  = $resultString['P_AUTH_DT'];                              // 승인일자(YYYYmmddHHmmss)
				$this->m_pgAuthDate  = substr($resultString['P_AUTH_DT'],'0','8');          
				$this->m_pgAuthTime  = substr($resultString['P_AUTH_DT'],'8','6');          
				$this->m_mname  = $resultString['P_MNAME'];                                 // 가맹점명
				$this->m_noti  = $resultString['P_NOTI'];                                   // 기타주문정보
				$this->m_authCode = $resultString['P_AUTH_NO'];                             // 신용카드 승인번호 - 신용카드 거래에서만 사용		
				$this->m_cardCode = $resultString['P_FN_CD1'];                              // 카드코드 
				
				
				--신용카드		
        $this->m_cardIssuerCode = $resultString['P_CARD_ISSUER_CODE'];              // 발급사 코드 
				$this->m_cardNum  = $resultString['P_CARD_NUM'];                            // 카드번호 
				$this->m_cardMumbernum  = $resultString['P_CARD_MEMBER_NUM'];               // 가맹점번호
				$this->m_cardpurchase  = $resultString['P_CARD_PURCHASE_CODE'];             // 매입사 코드 
				$this->m_prtc  = $resultString['P_CARD_PRTC_CODE'];                         // 부분취소 가능 여부
				$this->m_cardinterest  = $resultString['P_CARD_INTEREST'];                  // 무이자 할부여부 (일반 : 0, 무이자 : 1)
				$this->m_cardcheckflag  = $resultString['P_CARD_CHECKFLAG'];                // 체크카드여부 (신용카드:0, 체크카드:1, 기프트카드:2)
				$this->m_cardName  = $resultString['P_FN_NM'];                              // 결제카드한글명
				$this->m_cardSrcCode  = $resultString['P_SRC_CODE'];                        // 앱연동 여부 P : 페이핀, K : 국민앱카드
				
				
				--휴대폰
				$this->m_codegw  = $resultString['P_HPP_CORP'];                             // 휴대폰 통신사코드
				$this->m_hppapplnum  = $resultString['P_APPL_NUM'];                         // 휴대폰결제 승인번호
				$this->m_hppnum  = $resultString['P_HPP_NUM'];                              // 고객 휴대폰 번호
				
				
				--가상계좌
				$this->m_vacct  = $resultString['P_VACT_NUM'];                              // 입금할 계좌 번호
				$this->m_dtinput = $resultString['P_VACT_DATE'];                            // 입금마감일자(YYYYmmdd)
        $this->m_tminput = $resultString['P_VACT_TIME'];                            // 입금마감시간(hhmmss)
				$this->m_nmvacct = $resultString['P_VACT_NAME'];                            // 계좌주명
				$this->m_vcdbank = $resultString['P_VACT_BANK_CODE'];                       // 은행코드
	  */
	  
?>