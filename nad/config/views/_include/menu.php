<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="srchb lnb4_col bg2_col">
<table class="bg_col">
  <col width=80><col>
  <tr>
    <td class="ctlt bno"><img src="../../images/comn/bul_08.png" class="t">사이트 설정</td>
    <td class="wbg pl7">
    <ul class="List">
    <li class="f"><a href='./index.php' <?=(!$type)?"class='none b col' ":"";?>>기본설정</a></li>
	<?php
	if(is_array($netfu_util->site_content)) { foreach($netfu_util->site_content as $k=>$v) {
	?>
	<li><a href='./content.php?type=<?=$k;?>' <?=($type==$k)?"class='none b col' ":"";?>><?=$v;?></a></li>
	<?php
	} }
	?>
    </ul>
    </td>
  </tr>		 
</table>
</dl>