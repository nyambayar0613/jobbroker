<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>
<dl class="paging">
<?php
	$pages = str_replace("처음", "<img src='".$alice['images_path']."/comn/first.gif' border='0' align='absmiddle' title='처음'>", $pages);
	$pages = str_replace("이전", "<img src='".$alice['images_path']."/comn/pre.gif' border='0' align='absmiddle' title='이전'>", $pages);
	$pages = str_replace("다음", "<img src='".$alice['images_path']."/comn/next.gif' border='0' align='absmiddle' title='다음'>", $pages);
	$pages = str_replace("맨끝", "<img src='".$alice['images_path']."/comn/last.gif' border='0' align='absmiddle' title='맨끝'>", $pages);
	$pages = preg_replace("/<b>([0-9]*)<\/b>/", "$1", $pages);
	echo $pages;
?>
</dl> 