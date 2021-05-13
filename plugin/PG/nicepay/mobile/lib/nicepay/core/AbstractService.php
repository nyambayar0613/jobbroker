<?php
/**
 * Abstract Service Class
 * 
 * @author : crimson
 *
 */
abstract class AbstractService{
	 
	/**
	 * Execute Service
	 * @param ParameterSet $webMessageDTO
	 */
	public function service($webMessageDTO){

		if(LogMode::isAppLogable()){
			$logJournal = NicePayLogJournal::getInstance();
			$logJournal->writeAppLog("MID          : ".$webMessageDTO->getParameter("MID"));
			$logJournal->writeAppLog("TID          : ".$webMessageDTO->getParameter("TID"));
			$logJournal->writeAppLog("PayMethod    : ".$webMessageDTO->getParameter("PayMethod"));
			$logJournal->writeAppLog("GoodsName    : ".$webMessageDTO->getParameter("GoodsName"));
			$logJournal->writeAppLog("BuyerName    : ".$webMessageDTO->getParameter("BuyerName"));
			$logJournal->writeAppLog("Amt          : ".$webMessageDTO->getParameter("Amt"));
			$logJournal->writeAppLog("Moid         : ".$webMessageDTO->getParameter("Moid"));
			$logJournal->writeAppLog("MallReserved : ".$webMessageDTO->getParameter("MallReserved"));
			$logJournal->writeAppLog("MallIP       : ".$webMessageDTO->getParameter("MallIP"));
			$logJournal->writeAppLog("ClickpayCl   : ".$webMessageDTO->getParameter("ClickpayCl"));
			$logJournal->writeAppLog("EncMode	   : ".$webMessageDTO->getParameter("EncMode"));
			$logJournal->writeAppLog("TrKey        : ".$webMessageDTO->getParameter("TrKey"));
		}
		
		// 요청 메시지 생성하기
		$requestBytes = $this->createMessage($webMessageDTO);
		
		if(LogMode::isAppLogable()){
			$logJournal = NicePayLogJournal::getInstance();
			//$logJournal->writeAppLog("송신 ".strlen($requestBytes)." Bytes");
			$logJournal->writeAppLog("MERCHANT --> NICE [".(string)$requestBytes."]");
		}
		
		// 요청 메시지 보내기
		$responseBytes = $this->send($requestBytes);
		
		if(LogMode::isAppLogable()){
			$logJournal = NicePayLogJournal::getInstance();
			//$logJournal->writeAppLog("수신 ".strlen($responseBytes)." Bytes");
			$logJournal->writeAppLog("MERCHANT <-- NICE [".(string)$responseBytes."]");
		}
		
		// 수신 후 메시지 파싱하기
		$responseDTO = $this->parseMessage($responseBytes);
		
		if(LogMode::isAppLogable()){
			$logJournal = NicePayLogJournal::getInstance();
			$logJournal->writeAppLog("응답 결과    : [".trim($responseDTO->getParameter("ResultCode"))."|".trim($responseDTO->getParameter("ResultMsg"))."]");
			$logJournal->writeAppLog("제휴사 메시지: [".trim($responseDTO->getParameter("ErrorCD"))."|".trim($responseDTO->getParameter("ErrorMsg"))."]");
			$logJournal->writeAppLog("TID          : " .trim($responseDTO->getParameter("TID")));
			$logJournal->writeAppLog("PayMethod    : " .trim($responseDTO->getParameter("PayMethod")));
			$logJournal->writeAppLog("Moid         : " .trim($responseDTO->getParameter("Moid")));
			$logJournal->writeAppLog("AuthDate     : " .trim($responseDTO->getParameter("AuthDate")));
			$logJournal->writeAppLog("AuthCode     : " .trim($responseDTO->getParameter("AuthCode")));
			
			if (trim($responseDTO->getParameter("PayMethod")) == "CARD") {
				$logJournal->writeAppLog("CardCode     : ".trim($responseDTO->getParameter("CardCode")));
				$logJournal->writeAppLog("CardName     : ".trim($responseDTO->getParameter("CardName")));
				$logJournal->writeAppLog("CardQuota    : ".trim($responseDTO->getParameter("CardQuota")));
				$logJournal->writeAppLog("CardInterest : ".trim($responseDTO->getParameter("CardInterest")));
				$logJournal->writeAppLog("AcquCardCode : ".trim($responseDTO->getParameter("AcquCardCode")));
				$logJournal->writeAppLog("AcquCardName : ".trim($responseDTO->getParameter("AcquCardName")));
			} else if (trim($responseDTO->getParameter("PayMethod")) == "BANK") {
				$logJournal->writeAppLog("BankCode     : ".trim($responseDTO->getParameter("BankCode")));
				$logJournal->writeAppLog("BankName     : ".trim($responseDTO->getParameter("BankName")));
				$logJournal->writeAppLog("RcptType     : ".trim($responseDTO->getParameter("RcptType")));
				$logJournal->writeAppLog("RcptTID      : ".trim($responseDTO->getParameter("RcptTID")));
				$logJournal->writeAppLog("RcptAuthCode : ".trim($responseDTO->getParameter("RcptAuthCode")));
			} else if (trim($responseDTO->getParameter("PayMethod")) == "CELLPHONE") {
				$logJournal->writeAppLog("Carrier      : ".trim($responseDTO->getParameter("Carrier")));
				$logJournal->writeAppLog("DstAddr      : ".trim($responseDTO->getParameter("DstAddr")));
			} else if (trim($responseDTO->getParameter("PayMethod")) == "VBANK") {
				$logJournal->writeAppLog("VbankBankCode: ".trim($responseDTO->getParameter("VbankBankCode")));
				$logJournal->writeAppLog("VbankBankName: ".trim($responseDTO->getParameter("VbankBankName")));
				$logJournal->writeAppLog("VbankNum     : ".trim($responseDTO->getParameter("VbankNum")));
				$logJournal->writeAppLog("VbankExpDate : ".trim($responseDTO->getParameter("VbankExpDate")));
				$logJournal->writeAppLog("VbankAccountName : ".trim($responseDTO->getParameter("VbankAccountName")));
			}
		}
		
		return $responseDTO;
		
	}
	
	/**
	 * Create a ByteMessage
	 * @param ParameterSet $webMessageDTO
	 */
	public abstract function createMessage($webMessageDTO);
	
	/**
	 * Send to m&Bank Interface System
	 * @param ParameterSet $webMessageDTO
	 */
	public abstract function send($webMessageDTO);
	
	/**
	 * Receive Bytes Message from m&Bank Interface System. 
	 * Parsing a ByteMessage, Transform Bytes to ParameterSet 
	 * @param ParameterSet $responseBytes
	 */
	public abstract function parseMessage($responseBytes);
	
}
?>
