<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="srchb lnb4_col bg2_col">
<table class="bg_col">
  <col width=80><col>
  <tr>
    <td class="ctlt bno"><img src="../../images/comn/bul_08.png" class="t">페이지 설정</td>
    <td class="wbg pl7">
    <ul class="List">
    <li class="f"><a href='./pg_page.php' <?=(!$type)?"class='none b col' ":"";?>>채용공고 결제 페이지</a></li>
    <li><a href='./pg_page.php?type=alba_resume' <?=($type=='alba_resume')?"class='none b col' ":"";?>>이력서 결제 페이지</a></li>
    </ul>
    </td>
  </tr>		 
</table>
</dl>