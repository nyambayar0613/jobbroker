<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>
<script>
$(function(){
	$('#bqmn').hover(function(){
		$('#quick').slideDown();
	});
	$('#quick').mouseleave(function(){
		$('#quick').slideUp();
	});
});
</script>
<div id="quick">
<dl>
	<img src="../../images/comn/arr_p.gif">
	  <h1 class=""><b>퀵메뉴바로보기</b></h1>
	  <dt id="quick_list">
		<?php 
			if($quick_list){
				foreach($quick_list as $quick){ 
		?>
		<a href="..<?php echo $quick['url']?>"><?php echo $quick['sub_menu'] ?></a>
		<?php 
				} // foreach end.
			} else {
		?>
		<span class='col' id="quickMenuMsg">&nbsp;우측의 메뉴 네비게이션을 클릭하여 퀵메뉴를 추가해 주세요.</span>
		<?php
			}	// if end.
		?>
	  </dt>
	</dl>
</div>