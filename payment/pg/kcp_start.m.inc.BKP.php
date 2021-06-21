<?
    /* = -------------------------------------------------------------------------- = */
    /* =   환경 설정 파일 Include END                                               = */
    /* ============================================================================== */
?>
<?
    /* kcp와 통신후 kcp 서버에서 전송되는 결제 요청 정보 */
    $req_tx          = $_POST[ "req_tx"         ]; // 요청 종류         
    $res_cd          = $_POST[ "res_cd"         ]; // 응답 코드         
    $tran_cd         = $_POST[ "tran_cd"        ]; // 트랜잭션 코드     
    $ordr_idxx       = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호   
    $good_name       = $_POST[ "good_name"      ]; // 상품명            
    $good_mny        = $_POST[ "good_mny"       ]; // 결제 총금액       
    $buyr_name       = $_POST[ "buyr_name"      ]; // 주문자명          
    $buyr_tel1       = $_POST[ "buyr_tel1"      ]; // 주문자 전화번호   
    $buyr_tel2       = $_POST[ "buyr_tel2"      ]; // 주문자 핸드폰 번호
    $buyr_mail       = $_POST[ "buyr_mail"      ]; // 주문자 E-mail 주소
    $use_pay_method  = $_POST[ "use_pay_method" ]; // 결제 방법         
	$enc_info        = $_POST[ "enc_info"       ]; // 암호화 정보       
    $enc_data        = $_POST[ "enc_data"       ]; // 암호화 데이터     
    $cash_yn         = $_POST[ "cash_yn"        ];
    $cash_tr_code    = $_POST[ "cash_tr_code"   ];
    /* 기타 파라메터 추가 부분 - Start - */
    $param_opt_1    = $_POST[ "param_opt_1"     ]; // 기타 파라메터 추가 부분
    $param_opt_2    = $_POST[ "param_opt_2"     ]; // 기타 파라메터 추가 부분
    $param_opt_3    = $_POST[ "param_opt_3"     ]; // 기타 파라메터 추가 부분
    /* 기타 파라메터 추가 부분 - End -   */


  $tablet_size     = "1.0"; // 화면 사이즈 고정
  $url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>
<link href="<?=NFE_URL;?>/plugin/PG/kcp/mobile_sample/css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>

<!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
<script type="text/javascript" src="<?=NFE_URL;?>/plugin/PG/kcp/mobile_sample/js/approval_key.js?time=<?=time();?>"></script>

<script type="text/javascript">
  var controlCss = "<?=NFE_URL;?>/plugin/PG/kcp/mobile_sample/css/style_mobile.css";
  var isMobile = {
    Android: function() {
      return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
      return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
      return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
      return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
      return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
      return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
  };

  if( isMobile.any() )
    document.getElementById("cssLink").setAttribute("href", controlCss);
</script>
<script type="text/javascript">
   /* 주문번호 생성 예제 */
  function init_orderid()
  {
    var today = new Date();
    var year  = today.getFullYear();
    var month = today.getMonth() + 1;
    var date  = today.getDate();
    var time  = today.getTime();

    if (parseInt(month) < 10)
      month = "0" + month;

    if (parseInt(date) < 10)
      date  = "0" + date;

    var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;
    var ipgm_date  = year + "" + month + "" + date;

    document.order_info.ordr_idxx.value = order_idxx;
    document.order_info.ipgm_date.value = ipgm_date;
  }

   /* kcp web 결제창 호츨 (변경불가) */
  function call_pay_form()
  {
    var v_frm = document.order_info; 

	if(v_frm.encoding_trans == undefined) {
		v_frm.action = PayUrl; 
	} else {
		if(v_frm.encoding_trans.value == "UTF-8") {
			v_frm.action = PayUrl.substring(0,PayUrl.lastIndexOf("/")) + "/jsp/encodingFilter/encodingFilter.jsp"; 
			v_frm.PayUrl.value = PayUrl; 
		} else {
			 v_frm.action = PayUrl; 
		}
	}

    if (v_frm.Ret_URL.value == "")
    {
	  /* Ret_URL값은 현 페이지의 URL 입니다. */
	  alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");
      return false;
    }
    else
    {
      v_frm.submit();
    }
  }

   /* kcp 통신을 통해 받은 암호화 정보 체크 후 결제 요청 (변경불가) */
  function chk_pay()
  {
    self.name = "tar_opener";
    var pay_form = document.pay_form;

    if (pay_form.res_cd.value == "3001" )
    {
      alert("사용자가 취소하였습니다.");
      pay_form.res_cd.value = "";
    }
    
    if (pay_form.enc_info.value)
      pay_form.submit();
  }

  function jsf__chk_type()
  {
    if ( document.order_info.ActionResult.value == "card" )
    {
      document.order_info.pay_method.value = "CARD";
    }
    else if ( document.order_info.ActionResult.value == "acnt" )
    {
      document.order_info.pay_method.value = "BANK";
    }
    else if ( document.order_info.ActionResult.value == "vcnt" )
    {
      document.order_info.pay_method.value = "VCNT";
    }
    else if ( document.order_info.ActionResult.value == "mobx" )
    {
      document.order_info.pay_method.value = "MOBX";
    }
    else if ( document.order_info.ActionResult.value == "ocb" )
    {
      document.order_info.pay_method.value = "TPNT";
      document.order_info.van_code.value = "SCSK";
    }
    else if ( document.order_info.ActionResult.value == "tpnt" )
    {
      document.order_info.pay_method.value = "TPNT";
      document.order_info.van_code.value = "SCWB";
    }
    else if ( document.order_info.ActionResult.value == "scbl" )
    {
      document.order_info.pay_method.value = "GIFT";
      document.order_info.van_code.value = "SCBL";
    }
    else if ( document.order_info.ActionResult.value == "sccl" )
    {
      document.order_info.pay_method.value = "GIFT";
      document.order_info.van_code.value = "SCCL";
    }
    else if ( document.order_info.ActionResult.value == "schm" )
    {
      document.order_info.pay_method.value = "GIFT";
      document.order_info.van_code.value = "SCHM";
    }
  }


  var ajax_process = function(data) {
		var form = document.forms['order_info'];
		form.good_mny.value = data.price;
		form.ActionResult.value = data.method;
		form.param_opt_2.value = data.pno;
		jsf__chk_type();
		init_orderid();
		chk_pay();
		form.ordr_idxx.value = data.oid;
		kcp_AJAX();
	}

	var onload_func = function() {
		jsf__chk_type();
		init_orderid();
		chk_pay();
	}

	$(window).ready(function(){
		onload_func();
	});
</script>
</head>

<form name="order_info" method="post">
<input type="hidden" name="param_opt_1"     value="payment_process">
<input type="hidden" name="param_opt_2"     value="">
<input type="hidden" name="param_opt_3"     value="">


<input type="hidden" name="ActionResult" value="" title="결제방법" />
<input type="hidden" name="ordr_idxx" value="" title="<?=$_SESSION['__pay_order__'];?>" />
<input type="hidden" name="good_name" value="<?=$__service_name;?>" title="서비스명" />
<input type="hidden" name="good_mny" value="" title="결제금액" />
<input type="hidden" name="buyr_name" value="<?=$member['mb_name'];?>" title="주문자명" />
<input type="hidden" name="buyr_mail" value="<?=$member['mb_email'];?>" title="주문자 Email" />
<input type="hidden" name="buyr_tel1" value="<?=$member['mb_phone'];?>" title="주문자 연락처1" />
<input type="hidden" name="buyr_tel2" value="<?=$member['mb_hphone'];?>" title="휴대폰번호" />

<!-- 공통정보 -->
<input type="hidden" name="req_tx"          value="pay" />
<input type="hidden" name="shop_name"       value="<?=$g_conf_site_name ?>" />
<input type="hidden" name="site_cd"         value="<?=$g_conf_site_cd?>" />
<input type="hidden" name="currency"        value="410"/>                          <!-- 통화 코드 -->
<input type="hidden" name="eng_flag"        value="N" title="한/영" />

<!-- 결제등록 키 -->
<input type="hidden" name="approval_key"    id="approval">

<!-- 인증시 필요한 파라미터(변경불가)-->
<input type="hidden" name="pay_method" value="" />
<input type="hidden" name="van_code"        value="">

<!-- 신용카드 설정 -->
<input type="hidden" name="quotaopt"        value="12" title="할부옵션" />

<!-- 가상계좌 설정 -->
<input type="hidden" name="ipgm_date"       value=""/>

<!-- 가맹점에서 관리하는 고객 아이디 설정을 해야 합니다.(필수 설정) -->
<input type="hidden" name="shop_user_id"    value="<?=$member['mb_id'];?>"/>

<!-- 복지포인트 결제시 가맹점에 할당되어진 코드 값을 입력해야합니다.(필수 설정) -->
<input type="hidden" name="pt_memcorp_cd"   value=""/>

<!-- 현금영수증 설정 -->
<input type="hidden" name="disp_tax_yn"     value="Y"/>

<!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
<input type="hidden" name="Ret_URL"         value="<?=$url?>">

<!-- 화면 크기조정 -->
<input type="hidden" name="tablet_size"     value="<?=$tablet_size?>">




<?php
// : 에스크로 정보
// : 에스크로에 대한 정보가 모바일엔 이상하게 없음.
/*
?>
<input type="hidden" name="rcvr_name" value="" title="수취인명" />
<input type="hidden" name="rcvr_tel1" value="" title="수취인 연락처1" />
<input type="hidden" name="rcvr_tel2" value="" title="수취인 휴대번호" />
<input type="hidden" name="rcvr_mail" value="" title="수취인 E-mail" />
<input type="hidden" name="rcvr_zipx" value="" title="수취인 우편번호" />
<input type="hidden" name="rcvr_add1" value="" title="수취인 주소" />
<input type="hidden" name="rcvr_add2" value="" title="수취인 상세주소" />

<?php
*/
// : Payplus Plugin 에스크로결제 사용시 필수 정보
?>
<input type="hidden" name="escw_used"       value="N" title="에스크로 사용 여부"/>
<input type="hidden" name="pay_mod"         value="N" title="에스크로 결제처리 모드 : 에스크로: Y, 일반: N, KCP 설정 조건: O"/>
<?php
/*
<input type="hidden"  name="deli_term" value="03" title="배송 소요일 : 예상 배송 소요일을 입력"/>
<input type="hidden"  name="bask_cntx" value="3" title="장바구니 상품 개수 : 장바구니에 담겨있는 상품의 개수를 입력(good_info의 seq값 참조)" />
<?php
*/
?>


<input type="hidden" name="encoding_trans" value="UTF-8" /> <?// //추가 (인코딩 네임은 대문자) ?>
<input type="hidden" name="PayUrl" > <?/* 주문페이지 소스에 이미 PayUrl 이 input 값에 있다면 추가하지 않습니다.*/?>
</form>



<form name="pay_form" method="post" action="<?=NFE_URL;?>/regist.php">
<input type="hidden" name="req_tx"         value="<?=$req_tx?>">               <!-- 요청 구분          -->
<input type="hidden" name="res_cd"         value="<?=$res_cd?>">               <!-- 결과 코드          -->
<input type="hidden" name="tran_cd"        value="<?=$tran_cd?>">              <!-- 트랜잭션 코드      -->
<input type="hidden" name="ordr_idxx"      value="<?=$ordr_idxx?>">            <!-- 주문번호           -->
<input type="hidden" name="good_mny"       value="<?=$good_mny?>">             <!-- 휴대폰 결제금액    -->
<input type="hidden" name="good_name"      value="<?=$good_name?>">            <!-- 상품명             -->
<input type="hidden" name="buyr_name"      value="<?=$buyr_name?>">            <!-- 주문자명           -->
<input type="hidden" name="buyr_tel1"      value="<?=$buyr_tel1?>">            <!-- 주문자 전화번호    -->
<input type="hidden" name="buyr_tel2"      value="<?=$buyr_tel2?>">            <!-- 주문자 휴대폰번호  -->
<input type="hidden" name="buyr_mail"      value="<?=$buyr_mail?>">            <!-- 주문자 E-mail      -->
<input type="hidden" name="cash_yn"		   value="<?=$cash_yn?>">              <!-- 현금영수증 등록여부-->
<input type="hidden" name="enc_info"       value="<?=$enc_info?>">
<input type="hidden" name="enc_data"       value="<?=$enc_data?>">
<input type="hidden" name="use_pay_method" value="<?=$use_pay_method?>">
<input type="hidden" name="cash_tr_code"   value="<?=$cash_tr_code?>">

<!-- 추가 파라미터 -->
<input type="hidden" name="param_opt_1"	   value="<?=$param_opt_1?>">
<input type="hidden" name="param_opt_2"	   value="<?=$param_opt_2?>">
<input type="hidden" name="param_opt_3"	   value="<?=$param_opt_3?>">
</form>