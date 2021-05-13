<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="srchb lnb4_col bg2_col">

<table class="bg_col">
  <col width=120><col>	 
	<?php foreach($sub_menus as $key => $val){ ?>
	<tr>
		<td class="ctlt"><img src="../../images/comn/bul_08.png" class="t"><?php echo $val['name'];?></td>
		<td class="pdlnb2">
			<ul class="List">
				<?php 
					$i = 0;
					foreach($val['subs'] as $_key => $_subs){ 
				?>
				<li <?php echo ($i==0)?"class='f'":"";?>><a href='./category.php?type=<?php echo $_key;?>' <?=($type==$_key)?"class='none b col'":"";?>><?php echo $_subs['name']?></a></li>
				<?php 
					$i++;
					}	// subs foreach end.
				?>
			</ul>
		</td>
	</tr>
	<?php }	// sub menu foreach end. ?>
</table>

</dl>