<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<script>
$(function(){
	$('#menuNavi').hover(function(){
		$('#quickAddmessage').toggle();
	});
});
</script>

<dl class="navi" id="menuNavi">
	<h1 style="background:url(../../images/ic/link.png) no-repeat left -1px;text-indent:20px"><?php echo $top_menu;?></h1>
	<dt class="ml2 psr"><a onClick="add_favorite();"><?php echo ($middle_menu)?" > ".$middle_menu:"";?> <?php echo ($sub_menu)?" > ".$sub_menu:"";?>	</a></dt>
  
  <div class="blnb prt mt20 bg pd3" style="display:none;width:245px;" id="quickAddmessage">
	  <dl class="wbg pbt7 tc w100">클릭하시면 현재 메뉴가 퀵메뉴에 추가 됩니다.</dl>
  </div>
</dl>

<script>
var add_favorite = function( ){
	var top_menu = "<?php echo $top_menu;?>", top_menu_code = "<?php echo $top_menu_code;?>";
	var middle_menu = "<?php echo $middle_menu;?>", middle_menu_code = "<?php echo $middle_menu_code;?>";
	var sub_menu = "<?=$sub_menu_name?>", sub_menu_code = "<?php echo $sub_menu_code;?>";
	var url = "<?php echo $sub_menu_url;?>";

	confirm_msgs = "[ " + top_menu + " > ";
	confirm_msgs += (middle_menu) ? middle_menu + " > " : "";
	confirm_msgs += (sub_menu) ? sub_menu : "";

	var confirm_msg = confirm_msgs + " ] 를 퀵메뉴에 추가 하시겠습니까?";

	if(confirm(confirm_msg)){

		$.post("../include/_ajax/navi.php", { mode:'quick_insert', uid:"<?php echo $admin_info[uid];?>", top_menu:top_menu, top_menu_code:top_menu_code, middle_menu:middle_menu, middle_menu_code:middle_menu_code, sub_menu:sub_menu, sub_menu_code:sub_menu_code, url:url }, function(result){
			if(!result){
				$('#quickMenuMsg').hide();
				$("#quick_list").append("<a href='.."+url+"'>"+sub_menu+"</a>");
				$("#quick").slideDown();
			} else {
				alert(result);
			}
		});

	}
}
</script>