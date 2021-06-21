<script type="application/x-javascript">
    
    addEventListener("load", function()
    {
        setTimeout(updateLayout, 0);
    }, false);
 
    var currentWidth = 0;
    
    function updateLayout()
    {
        if (window.innerWidth != currentWidth)
        {
            currentWidth = window.innerWidth;
 
            var orient = currentWidth == 320 ? "profile" : "landscape";
            document.body.setAttribute("orient", orient);
            setTimeout(function()
            {
                window.scrollTo(0, 1);
            }, 100);            
        }
    }
 
    setInterval(updateLayout, 400);
    
</script>

<script language=javascript>
window.name = "BTPG_CLIENT";

var width = 330;
var height = 480;
var xpos = (screen.width - width) / 2;
var ypos = (screen.width - height) / 2;
var position = "top=" + ypos + ",left=" + xpos;
var features = position + ", width=320, height=440";
var date = new Date();
var date_str = "testoid_"+date.getFullYear()+""+date.getMinutes()+""+date.getSeconds();
if( date_str.length != 16 )
{
    for( i = date_str.length ; i < 16 ; i++ )
    {
        date_str = date_str+"0";
    }
}
function setOid()
{
    document.ini.P_OID.value = ""+date_str;
}

function on_web()
{
	var order_form = document.ini;
	var paymethod = order_form.paymethod.value;
	
	var wallet = window.open("", "BTPG_WALLET", features);
	<!--
	if (wallet == null) 
	{
		if ((webbrowser.indexOf("Windows NT 5.1")!=-1) && (webbrowser.indexOf("SV1")!=-1)) 
		{    // Windows XP Service Pack 2
			alert("팝업이 차단되었습니다. 브라우저의 상단 노란색 [알림 표시줄]을 클릭하신 후 팝업창 허용을 선택하여 주세요.");
		} 
		else 
		{
			alert("팝업이 차단되었습니다.");
		}
		return false;
	}
	-->
	
	order_form.target = "BTPG_WALLET";
	order_form.action = "https://mobile.inicis.com/smart/" + paymethod + "/";
	order_form.submit();
}

function onSubmit()
{
	var order_form = document.ini;
	var inipaymobile_type = order_form.inipaymobile_type.value;
  if( inipaymobile_type == "web" )
		return on_web();
}


function ajax_process(data) {
	var form = document.forms['ini'];
	form.P_AMT.value = data.price;
	form.paymethod.value = data.method;
	form.P_NOTI.value = 'payment_process:'+data.pno;
	setOid();
	onSubmit();
}

</script>

<form id="form1" name="ini" method="post" action=""  accept-charset= "euc-kr" >

<input type="hidden" name="P_NOTI" value="" />
<input type="hidden" name="inipaymobile_type" value="web" />
<input type="hidden" name="P_OID" value="<?=$_SESSION['__pay_order__'];?>" />
<input type="hidden" name="P_GOODS" value="<?=$__service_name;?>" />
<input type="hidden" name="P_AMT" value="" />
<input type="hidden" name="P_UNAME" value="<?=$member['mb_name'];?>" />
<input type="hidden" name="P_MNAME" value="<?php echo $env['site_title'];?>" />
<input type="hidden" name="P_MOBILE" value="<?php echo $member['mb_hphone'];?>" />
<input type="hidden" name="P_EMAIL" value="<?php echo $member['mb_email'];?>" />
<input type="hidden" name="paymethod" value="" />

<input type="hidden" name="P_MID" value="<?=$netfu_payment->use_pg['pg_id'];?>"> 
<input type=hidden name="P_NEXT_URL" value="http://<?=$_SERVER['HTTP_HOST'];?>/regist.php">
<input type=hidden name="P_NOTI_URL" value="http://<?=$_SERVER['HTTP_HOST'];?>/regist.php">
<input type=hidden name="P_HPP_METHOD" value="1">

</form>
