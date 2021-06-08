<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<form method="post" name="process" action="./process/sms.php" id="SMSSendFrm">
<input type="hidden" name="mode" value="members_send"/>
<table class="sms">
	<tr><td><img src="../../images/nad/sms_01.gif"></td></tr>
	<tr>
		<td class="contxt">
			<textarea name="send_msg" id="send_msg" onKeyUp="CountChar(this, 2000);" required hname="текстийн агуулга"></textarea>
			<dt><span id="msg_bytes">0</span> Byte / <b>2000Byte</b></dt>
		</td>
	</tr>
	<tr>
		<td class="connum">
			<strong>Хүлээн авагч <!-- (<span id="rphone_cnt">0</span>명) --></strong>
			<textarea id="rphone_list" style="height:100px;" name="rphone_list" required hname="Хүлээн авагч"><?php echo ($mode=='sms')?$member['mb_hphone']."|".$member['mb_name']."|".$member['mb_id']:"";?></textarea>
			<dt class="mt2">Олон тоогоор илгээх үед таслалаар тусгаарлана (,).</dt>
			<!--<dl>보내는사람 &nbsp;&nbsp;<?php echo $env['call_center']?> <input type="text" class="tnum" style="width:86px;" name="sphone" value="<?php echo $env['call_center']?>" required hname="보내는사람"></dl> -->
			<input type="hidden" name="sphone" value="<?php echo $env['call_center']?>"/>
		</td>
	</tr>
	<tr><td><img src="../../images/nad/sms_05.gif" usemap="#Send"></td></tr>
	<map name="Send">
	<area shape="rect" coords="21,4,95,32" href="javascript:sms_send();" style="cusor:pointer;" alt="илгээх">
	<area shape="rect" coords="96,4,169,32" href="javascript:sms_cancel();" alt="цуцлах">
	</map>
</table>
</form>