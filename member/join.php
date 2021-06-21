<?php
$head_title = ($_GET['kind']=='company' ? 'Байгууллага' : 'Хувь хүн')."Гишүүнээр нэвтрэх";
$editor_use = true;
include_once "../include/top.php";
?>
<script type="text/javascript" src="<?=NFE_URL;?>/member/netfu_member.class.js?time=<?=time();?>"></script>
<script type="text/javascript">
var mem_submit = function(el) {
	var form = document.forms['fmember'];
	if(validate(form)) {
		form.submit();
	}
}
</script>
<style>
#touchGuideBox{width:130px !important}
</style>
<form name="fmember" action="<?=NFE_URL;?>/regist.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="member_write" />
<input type="hidden" name="kind" value="<?=$_GET['kind'];?>" />
<input type="hidden" name="mb_receive[]" value="memo" />
<?php
include NFE_PATH.'/member/inc/'.$_GET['kind'].'.inc.php';
?>

<div class="button_con">
	<a href="javascript:mem_submit(this)" class="bottom_btn01">Батлах</a><a href="#" class="bottom_btn02">Цуцлах</a>
</div>
</form>


<?php
include "../include/tail.php";
?>