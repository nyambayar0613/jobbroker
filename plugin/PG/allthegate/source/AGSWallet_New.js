//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 파일명 : AGSWallet_New.js
// 작성일자 : 2015/09/03
//
// AGSWallet 플러그인 동작을 제어하는 자바스크립트소스
//
// Copyright 2011 AEGISENTERPRISE.Co.,Ltd. All rights reserved.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function callbackBeforeSubmit() {
	//"지불처리중"이라는 팝업창연결 부분
	var openwin = window.open("//www.allthegate.com/payment/webPay/AGS_progress.html","popup","width=300,height=160");
}

document.AGSPay = new Object();
document.AGSPay.object = new Object();

function StartSmartUpdate(){}

function MakePayMessage(form)
{		
	/* 각 결제 공통 사용 변수 */
	$('input[name=Flag]').attr('id', 'Flag');
	$('input[name=AuthTy]').attr('id', 'AuthTy');
	$('input[name=SubTy]').attr('id', 'SubTy');
	/* 신용카드 결제 사용 변수 */
	$('input[name=DeviId]').attr('id', 'DeviId');		
	$('input[name=QuotaInf]').attr('id', 'QuotaInf');
	$('input[name=NointInf]').attr('id', 'NointInf');
	$('input[name=AuthYn]').attr('id', 'AuthYn');
	$('input[name=Instmt]').attr('id', 'Instmt');
	$('input[name=partial_mm]').attr('id', 'partial_mm');
	$('input[name=noIntMonth]').attr('id', 'noIntMonth');
	$('input[name=KVP_RESERVED1]').attr('id', 'KVP_RESERVED1');
	$('input[name=KVP_RESERVED2]').attr('id', 'KVP_RESERVED2');
	$('input[name=KVP_RESERVED3]').attr('id', 'KVP_RESERVED3');
	$('input[name=KVP_CURRENCY]').attr('id', 'KVP_CURRENCY');
	$('input[name=KVP_CARDCODE]').attr('id', 'KVP_CARDCODE');
	$('input[name=KVP_SESSIONKEY]').attr('id', 'KVP_SESSIONKEY');
	$('input[name=KVP_ENCDATA]').attr('id', 'KVP_ENCDATA');
	$('input[name=KVP_CONAME]').attr('id', 'KVP_CONAME');
	$('input[name=KVP_NOINT]').attr('id', 'KVP_NOINT');
	$('input[name=KVP_QUOTA]').attr('id', 'KVP_QUOTA');
	$('input[name=CardNo]').attr('id', 'CardNo');
	$('input[name=MPI_CAVV]').attr('id', 'MPI_CAVV');
	$('input[name=MPI_ECI]').attr('id', 'MPI_ECI');
	$('input[name=MPI_MD64]').attr('id', 'MPI_MD64');
	$('input[name=ExpMon]').attr('id', 'ExpMon');
	$('input[name=ExpYear]').attr('id', 'ExpYear');
	$('input[name=Passwd]').attr('id', 'Passwd');
	$('input[name=SocId]').attr('id', 'SocId');
	/* 계좌이체 결제 사용 변수 */
	$('input[name=ICHE_OUTBANKNAME]').attr('id', 'ICHE_OUTBANKNAME');			
	$('input[name=ICHE_OUTACCTNO]').attr('id', 'ICHE_OUTACCTNO');	
	$('input[name=ICHE_OUTBANKMASTER]').attr('id', 'ICHE_OUTBANKMASTER');
	$('input[name=ICHE_AMOUNT]').attr('id', 'ICHE_AMOUNT');
	/* 핸드폰 결제 사용 변수 */
	$('input[name=HP_SERVERINFO]').attr('id', 'HP_SERVERINFO');
	$('input[name=HP_HANDPHONE]').attr('id', 'HP_HANDPHONE');
	$('input[name=HP_COMPANY]').attr('id', 'HP_COMPANY');
	$('input[name=HP_IDEN]').attr('id', 'HP_IDEN');
	$('input[name=HP_IPADDR]').attr('id', 'HP_IPADDR');
	/* 가상계좌 결제 사용 변수 */
	$('input[name=ZuminCode]').attr('id', 'ZuminCode');
	$('input[name=VIRTUAL_CENTERCD]').attr('id', 'VIRTUAL_CENTERCD');
	$('input[name=VIRTUAL_DEPODT]').attr('id', 'VIRTUAL_DEPODT');
	$('input[name=VIRTUAL_NO]').attr('id', 'VIRTUAL_NO');
	/* ARS 결제 사용 변수 */
	$('input[name=ARS_PHONE]').attr('id', 'ARS_PHONE');
	$('input[name=ARS_NAME]').attr('id', 'ARS_NAME');
	$('input[name=mTId]').attr('id', 'mTId');
	/* 에스크로 결제 사용 변수 */
	$('input[name=ES_SENDNO]').attr('id', 'ES_SENDNO');
	/* 계좌이체(소켓) 결제 사용 변수 */
	$('input[name=ICHE_SOCKETYN]').attr('id', 'ICHE_SOCKETYN');
	$('input[name=ICHE_POSMTID]').attr('id', 'ICHE_POSMTID');
	$('input[name=ICHE_FNBCMTID]').attr('id', 'ICHE_FNBCMTID');
	$('input[name=ICHE_APTRTS]').attr('id', 'ICHE_APTRTS');
	$('input[name=ICHE_REMARK1]').attr('id', 'ICHE_REMARK1');
	$('input[name=ICHE_REMARK2]').attr('id', 'ICHE_REMARK2');
	$('input[name=ICHE_ECWYN]').attr('id', 'ICHE_ECWYN');
	$('input[name=ICHE_ECWID]').attr('id', 'ICHE_ECWID');
	$('input[name=ICHE_ECWAMT1]').attr('id', 'ICHE_ECWAMT1');
	$('input[name=ICHE_ECWAMT2]').attr('id', 'ICHE_ECWAMT2');
	$('input[name=ICHE_CASHYN]').attr('id', 'ICHE_CASHYN');
	$('input[name=ICHE_CASHGUBUN_CD]').attr('id', 'ICHE_CASHGUBUN_CD');
	$('input[name=ICHE_CASHID_NO]').attr('id', 'ICHE_CASHID_NO');
	/* 계좌이체-텔래뱅킹(소켓) 결제 사용 변수 */
	$('input[name=ICHEARS_SOCKETYN]').attr('id', 'ICHEARS_SOCKETYN');
	$('input[name=ICHEARS_ADMNO]').attr('id', 'ICHEARS_ADMNO');
	$('input[name=ICHEARS_POSMTID]').attr('id', 'ICHEARS_POSMTID');
	$('input[name=ICHEARS_CENTERCD]').attr('id', 'ICHEARS_CENTERCD');
	$('input[name=ICHEARS_HPNO]').attr('id', 'ICHEARS_HPNO');
	
	/* 일반변수 */
	$('input[name=StoreId]').attr('id', 'StoreId');		
	$('input[name=Job]').attr('id', 'Job');
	$('input[name=TempJob]').attr('id', 'TempJob');
	$('input[name=OrdNo]').attr('id', 'OrdNo');
	$('input[name=Amt]').attr('id', 'Amt');
	$('input[name=StoreNm]').attr('id', 'StoreNm');
	$('input[name=ProdNm]').attr('id', 'ProdNm');
	$('input[name=MallUrl]').attr('id', 'MallUrl');
	$('input[name=UserEmail]').attr('id', 'UserEmail');
	$('input[name=ags_logoimg_url]').attr('id', 'ags_logoimg_url');
	$('input[name=SubjectData]').attr('id', 'SubjectData');
	$('input[name=UserId]').attr('id', 'UserId');
	$('input[name=OrdNm]').attr('id', 'OrdNm');
	$('input[name=OrdPhone]').attr('id', 'OrdPhone');
	$('input[name=OrdAddr]').attr('id', 'OrdAddr');
	$('input[name=RcpNm]').attr('id', 'RcpNm');
	$('input[name=RcpPhone]').attr('id', 'RcpPhone');
	$('input[name=DlvAddr]').attr('id', 'DlvAddr');
	$('input[name=Remark]').attr('id', 'Remark');
	$('input[name=CardSelect]').attr('id', 'CardSelect');
	$('input[name=MallPage]').attr('id', 'MallPage');
	$('input[name=VIRTUAL_DEPODT]').attr('id', 'VIRTUAL_DEPODT');
	$('input[name=HP_ID]').attr('id', 'HP_ID');
	$('input[name=HP_PWD]').attr('id', 'HP_PWD');
	$('input[name=HP_SUBID]').attr('id', 'HP_SUBID');
	$('input[name=ProdCode]').attr('id', 'ProdCode');
	$('input[name=HP_UNITType]').attr('id', 'HP_UNITType');
	//$('input[name=call_popup]').attr('id', 'call_popup');

	//if($('#CardSelect').val() == undefined) $("#frmAGS_pay").append($('<input type="hidden" name="CardSelect" id="CardSelect" value="">'));		
	//if($('#SubjectData').val() == undefined) $("#frmAGS_pay").append($('<input type="hidden" name="SubjectData" id="SubjectData" value="업체명;판매상품;계산금액;일반결제;">'));
	//if($('#call_popup').val() == undefined) $("#frmAGS_pay").append($('<input type="radio" name="call_popup" id="call_popup" value="popup">'));			

	//alert($('#SubjectData').val());
	//$('input[name=StoreId]').val();
	//alert($('input[name=StoreId]').val());

	Allthegate.client.pay(document.frmAGS_pay, callbackBeforeSubmit);
	return true;
}