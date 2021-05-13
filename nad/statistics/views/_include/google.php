<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="srchb lnb4_col bg2_col">
<table class="bg_col">
  <col width=80><col>
  <tr>
    <td class="ctlt bno"><img src="../../images/comn/bul_08.png" class="t">통계분류</td>
    <td class="wbg pl7">
    <ul class="List">
    <li class="f"><a href='./google.php' <?=(!$type)?"class='none b col' ":"";?>>접속통계</a></li>
    <li><a href='./google.php?type=page' <?=($type=='page')?"class='none b col' ":"";?>>페이지 통계</a></li>
    <li><a href='./google.php?type=system' <?=($type=='system')?"class='none b col' ":"";?>>시스템 통계</a></li>
    </ul>
    </td>
  </tr>		 
</table>
</dl>