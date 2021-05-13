<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>
	<dl id="footer">Copyright ⓒ <a href="http://netfu.co.kr" target="_blank"><b class="wht">NETFU Corp.</b></a> All Rights Reserved.</dl>
</div>
<script>
// jquery form plugin 을 통한 폼 필드 초기화
var resetFrm = function(id){
	$('#'+id).resetForm();
}
</script>
<?php echo $config->_tail();?>