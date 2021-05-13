<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>
<table width="100%">
	<!--<tr>
		<td height="6">
			<img src="../../images/nad/adbg2_01.gif" id="menuTopLine">
		</td>
	</tr>
	<tr>-->
	<td class="vt">
		<dl class="lmnt pt10 pl4">
			<b>관리자</b>
			<dt class="dgr num3 tl"><?php echo $admin_info['uid']; ?></dt>  
			<!--<dt class="mt5"><a href="../main/"><img src="../../images/nad/badmin.gif"></a></dt>-->
			<dt class="logoutBtn mt25 mb10"><a onClick="admin_logout();">로그아웃<!--<img src="../../images/nad/blogout.gif">--></a></dt>
		</dl>
		<dl class="quickMenu  lmnt psr">
			<dt><a id="bqmn"><img class="vm" src="../../images/nad/lmn_l08.gif"  alt="퀵메뉴"></a></dt>
			<dt><a href="../../" target="_blank"><img src="../../images/nad/lmn_l02.gif"></a></dt>
<dt><a href="../alba/"><img src="../../images/nad/lmn_l04.gif"></a></dt>
			<dt><a href="../alba/resume.php"><img src="../../images/nad/lmn_l05.gif"></a></dt>
			<dt><a href="../config/sadmin.php"><img src="../../images/nad/lmn_l01.gif"></a></dt>
			<dt><a href="../board/"><img src="../../images/nad/lmn_l03.gif"></a></dt>
			
			<dt class="bb0"><a href="../design/"><img src="../../images/nad/lmn_l06.gif"></a></dt>
			<!-- <dt class="mt7"><a onClick="void(window.open('../main/pop_shortcut.php','','width=,height=,resizable=no,scrollbars=no'))"><img src="../../images/nad/lmn_l03.gif"></a></dt> -->
			<?php include_once "quick_menu.php"; ?>
		</dl>
		<!--<dl><dl class="lmnt"><a href="../main/manual.html"><img src="../../images/nad/bman.gif" class="mt2"></a></dl></dl -->
		<dl class="mt10">
			<dt class="mt10"><a href="../member/mail.php"><img src="../../images/nad/lmn_s02.gif"></a></dt>    
			<dt class="mt10"><a href="http://www.netfu.co.kr/client_center/board_direct.html?s_code=cs" target="_blank"><img src="../../images/nad/lmn_s03.gif"></a></dt>
		</dl>
	</td>
	</tr>
</table>
	<!--<img src="../../images/nad/adbg_03.gif" class="btm" id="menuBottomLine">adbg2 -->
<script>
// 관리자 로그아웃
var admin_logout = function(){

	if(confirm('로그아웃 하시겠습니까?')){
		$.post("../include/_ajax/admin_logout.php", { uid:"<?php echo $admin_info[uid];?>" }, function(result){
			if(result!='admin_logout_complete'){
				alert(result);
			}
			location.href = "<?php echo $alice['admin_path']; ?>";
		});
	}
}
</script>