<script type="text/javascript">
$(document).ready(function(){
    $(".resume_more_option").click(function(){
		var offset = $(this).offset();
		var no = $(this).attr("no");
		$.post(base_url+"/regist.php", "mode=get_ajax_resume_detail&no="+no, function(data){
			data = $.parseJSON(data);
			$(".resume_detail_box").html(data.body);
			$(".resume_detail_box").css({top:offset.top+"px", left:0+"px", display:"block"});
		});
    });
});
</script>

<?php
// /include/inc/resume_box_detail.inc.php 에서 ajax로 사용합니다.
?>

<!-- 인재정보 상세보기 -->
<div class="resume_detail_box detail_ly more_btn_ly cf" style="display:block"></div>
<!-- //인재정보 상세보기 -->