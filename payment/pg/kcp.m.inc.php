<?php
$util = $this;
include_once base_dir."plugin/PG/kcp/cfg/site_conf_inc.php";

//$good_expr = $this->today.'~'.date("Y-m-d", strtotime($ddd));
if(!$good_expr) $good_expr = '0';

$tablet_size     = "1.0"; // 화면 사이즈 고정
$url = domain.'module/regist.php';
//$url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>
<input type="hidden" name="param_opt_1"     value="payment_process">
<input type="hidden" name="param_opt_2"     value="<?=$pay_no;?>">
<input type="hidden" name="param_opt_3"     value="<?=$param_opt_3;?>">


<input type="hidden" name="ActionResult" value="<?=$this->kcp_payment_method_m[$_POST['payment_method']];?>" title="Төлбөрийн арга" />
<input type="hidden" name="ordr_idxx" value="" title="<?=$_SESSION['payment_oid'];?>" />
<input type="hidden" name="good_name" value="<?=$service_name;?> Үйлчилгээ" title="Үйлчилгээний нэр" />
<input type="hidden" name="good_mny" value="<?=$price_re['price_int'];?>" title="Төлбөрийн хэмжээ" />
<input type="hidden" name="buyr_name" value="<?=$member_info['name'];?>" title="Захиалагчийн нэр" />
<input type="hidden" name="buyr_mail" value="<?=$member_info['email'];?>" title="Захиалагчийн Email" />
<input type="hidden" name="buyr_tel1" value="<?=$member_info['phone'];?>" title="Захиалагчийн холбоо барих мэдээлэл 1" />
<input type="hidden" name="buyr_tel2" value="<?=$member_info['hphone'];?>" title="Утсаны дугаар" />

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
<input type="hidden" name="quotaopt"        value="<?=$this->pg_info['kcp_pg']['quotaopt'];?>" title="installment option" />

<!-- 가상계좌 설정 -->
<input type="hidden" name="ipgm_date"       value=""/>

<!-- 가맹점에서 관리하는 고객 아이디 설정을 해야 합니다.(필수 설정) -->
<input type="hidden" name="shop_user_id"    value="<?=sess_uid;?>"/>

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
<input type="hidden" name="escw_used"       value="<?=$netk_page_form->config['escrow_use'];?>" title="Эскроу ашиглах эсэх"/>
<input type="hidden" name="pay_mod"         value="<?=$netk_page_form->config['escrow_use'];?>" title="Эскроу төлбөр хийх: Эскроу: Y, Хэвийн: N, KCP тохиргооны нөхцөл: О"/>
<?php
/*
<input type="hidden"  name="deli_term" value="03" title="배송 소요일 : 예상 배송 소요일을 입력"/>
<input type="hidden"  name="bask_cntx" value="3" title="장바구니 상품 개수 : 장바구니에 담겨있는 상품의 개수를 입력(good_info의 seq값 참조)" />
<?php
*/
?>


<input type="hidden" name="encoding_trans" value="UTF-8" /> <?// //추가 (인코딩 네임은 대문자) ?>
<input type="hidden" name="PayUrl" > <?/* 주문페이지 소스에 이미 PayUrl 이 input 값에 있다면 추가하지 않습니다.*/?>