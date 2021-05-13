<script type="text/javascript">
$(document).ready(function(){
    $(".job_more_option").click(function(){
		var offset = $(this).offset();
		var no = $(this).attr("no");
		$.post(base_url+"/regist.php", "mode=get_ajax_job_detail&no="+no, function(data){
			data = $.parseJSON(data);
			$(".job_detail_box").html(data.body);
			$(".job_detail_box").css({top:offset.top+"px", left:0+"px", display:"block"});
		});
    });
});
</script>


<?php
// /include/inc/job_box_detail.inc.php 에서 ajax 사용합니다.
?>

<!-- 상세보기 -->
<div class="job_detail_box detail_ly more_btn_ly cf"></div>
<!-- //상세보기 -->