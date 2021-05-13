<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="srchb lnb4_col bg2_col">
<table class="bg_col">
  <col width=80><col>
  <tr>
    <td class="ctlt bno"><img src="../../images/comn/bul_08.png" class="t">통계분류</td>
    <td class="wbg pl7">
    <ul class="List">
    <li class="f"><a href='./' <?=(!$type)?"class='none b col' ":"";?>>접속통계</a></li>
    <li><a href='./?type=time' <?=($type=='time')?"class='none b col' ":"";?>>시간별 통계</a></li>
    <li><a href='./?type=week' <?=($type=='week')?"class='none b col' ":"";?>>요일별 통계</a></li>
    <li><a href='./?type=date' <?=($type=='date')?"class='none b col' ":"";?>>일별 통계</a></li>
    <li><a href='./?type=month' <?=($type=='month')?"class='none b col' ":"";?>>월별 통계</a></li>
    <li><a href='./?type=domain' <?=($type=='domain')?"class='none b col' ":"";?>>접속전 도메인</a></li>
    <li><a href='./?type=ip' <?=($type=='ip')?"class='none b col' ":"";?>>접속 IP</a></li>
    <li><a href='./?type=browser' <?=($type=='browser')?"class='none b col' ":"";?>>접속 브라우저</a></li>
    <li><a href='./?type=os' <?=($type=='os')?"class='none b col' ":"";?>>접속 OS</a></li>
    </ul>
    </td>
  </tr>		 
</table>
</dl>