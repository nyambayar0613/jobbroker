<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>
<!--dl class="ntlt lnb6_col"><img class="t" src="../../images/comn/bul_10.png">메세지 출력 안내</dl>
<div class="ds4 smsbox">
<div width="98%">
<span>※최대 글자수는 90Byte이며 초과시 메세지 뒷부분은 삭제되어 발송됩니다. 아래의 치환문자들이 SMS 발송시 고객님이 입력하신 정보에 따라 각각 자동으로 치환되어 전송됩니다.</span>
<ul class="ds5">
<li class="namewidth">{도메인}</li>
<li class="namewidth2">사이트의 도메인명이 출력됩니다<br> 
예)netfu.co.kr</li>
</ul>
<ul class="ds5">
<li class="namewidth">{아이디}</li>
<li>고객님의 아이디가 출력됩니다<br> 
예)netfu</li>
</ul>
</div>
<div>
<ul class="ds5">
<li class="namewidth">{날짜}</li>
<li class="namewidth2">오늘날짜가 출력됩니다<br>
예)1월 1일</li>
</ul>
<ul class="ds5">
<li class="namewidth">{이름}</li>
<li>고객님의 이름이 출력됩니다<br>
예)넷퓨</li>
</ul>
</div>
<div>
<ul class="ds5">
<li class="namewidth">{계좌번호}</li>
<li class="namewidth2">온라인 입금시 고객님이 선택한 계좌번호가 출력됩니다</li>
</ul>
<ul class="ds5">
<li class="namewidth">{은행}</li>
<li>온라인 입금시 고객님이 선택한 은행명이 출력됩니다</li>
</ul>
</div>

<div>
<ul class="ds5">
<li class="namewidth">{예금주}</li>
<li class="namewidth2">온라인 입금시 고객님이 선택한 예금주명이 출력됩니다</li>
</ul>
<ul class="ds5">
<li class="namewidth">{회사}</li>
<li>회사명이 출력됩니다</li>
</ul>
</div>

</div>-->
<dl style="width:95.4%" class="ntlt lnb6_col"><img src="../../images/comn/bul_10.png" class="t">메세지 출력 안내</dl>
<table cellspacing="0" width="95.4%" class="smsbox smsbottom">
 <tbody bgcolor="#ffffff">
    <tr>
        <td class="smsboxbg" width="98%"colspan="4">
			<p>※ SMS 최대 글자수는 90Byte이며, LMS 최대 글자수는 2,000Byte 입니다.</p>
			<p>※ <strong>LMS 사용시</strong> : 문자내용이 90byte를 초과하면 <u>LMS(장문)</u>로 발송 됩니다.</p>
			<p>※ <strong>LMS 미사용시</strong> : 문자내용이 90byte를 초과하면 <u>SMS(단문)로 90byte 까지</u>만 잘려서 발송 됩니다.</p>
			<p style="color:#ff8040;font-weight:bold;">※ 미리보기시 90Byte 이하여도 아래의 변수들이 대입되는 경우 90Byte 를 초과할수 있습니다</p>
			<p style="color:#ff8040;font-weight:bold;">&nbsp;&nbsp;&nbsp;90Byte가 초과되는 경우, LMS 사용시 LMS(장문) 로 발송되며, 미사용시 SMS(단문) 로 발송됩니다.</p>
        </td>
    </tr>
    <tr>
        <td width="12%"  class="smsName">
            <p>{도메인}</p>
        </td>
        <td width="28%"  class="smsNamep">
            <p>사이트의 도메인명이 출력됩니다 <br>예)netfu.co.kr</p>
        </td>
        <td width="12%"   class="smsName" >
            <p>{아이디}</p>
        </td>
        <td width="48%"  class="smsNamep">
            <p>고객님의 아이디가 출력됩니다 <br> 
예)netfu</p>
        </td>
    </tr>
    <tr>
        <td width="12%"  class="smsName" >
            <p>{날짜}</p>
        </td>
        <td width="28%"  class="smsNamep">
            <p>오늘 날짜가 출력됩니다 <br>
예)1월 1일</p>
        </td>
        <td width="12%"  class="smsName" >
            <p>{이름}</p>
        </td>
        <td width="48%"  class="smsNamep">
            <p>고객님의 이름이 출력됩니다 <br>
예)넷퓨</p>
        </td>
    </tr>
    <tr>
        <td width="12%"  class="smsName" >
            <p>{계좌번호}</p>
        </td>
        <td width="28%"  class="smsNamep">
            <p>온라인 입금시 고객님이 선택한 계좌번호가
출력됩니다</p>
        </td>
        <td width="12%"  class="smsName" >
            <p>{은행}</p>
        </td>
        <td width="48%"  class="smsNamep">
            <p>온라인 입금시 고객님이 선택한 은행명이
출력됩니다</p>
        </td>
    </tr>
    <tr>
        <td width="12%"  class="smsName" >
            <p>{예금주}</p>
        </td>
        <td width="28%"  class="smsNamep">
            <p>온라인 입금시 고객님이 선택한 예금주명이
출력됩니다</p>
        </td>
        <td width="12%"  class="smsName" >
            <p>{회사}</p>
        </td>
        <td width="48%"  class="smsNamep">
            <p>기업회원 회사명이 출력됩니다</p>
        </td>
    </tr>
    <tr>
        <td width="12%"  class="smsName" >
            <p>{사이트명}</p>
        </td>
        <td width="28%"  class="smsNamep">
            <p>사이트명이 출력됩니다 <br>예)넷퓨</p>
        </td>
        <td width="12%"  class="smsName" >
            <p>{닉네임}</p>
        </td>
        <td width="48%"  class="smsNamep">
            <p>회원 닉네임이 출력됩니다. </p>
        </td>
    </tr>	</tbody>
</table>


