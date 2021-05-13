<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="srchb lnb4_col bg2_col">
<table class="bg_col">
<col width=130><col>
<?php
	foreach($service_title as $title_key => $title_val){
	$service_lists = $service_control->service_lists[$title_key];
	$service_lists_cnt = count($service_lists);
?>
<tr>
	<td class="ctlt"><img src="../../images/comn/bul_08.png" class="t"><?php echo $title_val;?></td>
	<td class="pdlnb2">
		<ul class="List">
			<?php 
				$i = 0;
				foreach($service_lists as $key => $val){
				$type_val = $title_key . "_" . $key;
			?>
			<li <?php echo ($i==0)?"class='f'":"";?>><a href='./service.php?type=<?php echo $type_val;?>' <?php echo ($type==$type_val)?"class='none b col'":"";?>><?php echo $val['name'];?></a></li>
			<?php 
				$i++;
				} // foreach end. 
			?>
		</ul>
	</td>
</tr>
<?php } // foreach end. ?>
</table>
</dl>