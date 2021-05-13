<?php
$caus_cd = $netfu_util->adult ? '01' : '00';
$_SESSION['__auth_click_page__'] = $_SERVER['PHP_SELF'];
?>
<form name="form_auth" method="get">
<input type="hidden" name="rqst_caus_cd" value="<?=$caus_cd;?>" />
<input type="hidden" name="in_tp_bit" value="0" />
<input type="hidden" name="param_r1" value="<?=$page_type;?>" />

<input type="hidden" name="action_ipin" value="<?=NFE_URL;?>/modules/okname/ipin/adult1.php" />
<input type="hidden" name="action_sms" value="<?=NFE_URL;?>/modules/okname/hs_cnfrm/adultfrm_popup1.php" />



<input type="hidden" name="encPsnlInfo" />
<input type="hidden" name="virtualno" />
<input type="hidden" name="dupinfo" />
<input type="hidden" name="realname" />
<input type="hidden" name="cprequestnumber" />
<input type="hidden" name="age" />
<input type="hidden" name="sex" />
<input type="hidden" name="nationalinfo" />
<input type="hidden" name="birthdate" />
<input type="hidden" name="coinfo1" />
<input type="hidden" name="coinfo2" />
<input type="hidden" name="ciupdate" />
<input type="hidden" name="cpcode" />
<input type="hidden" name="authinfo" />

</form>