<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

<dl class="srchb lnb4_col bg2_col">
<table class="bg_col">
  <col width=80><col>
  <tr>
    <td class="ctlt bno"><img src="../../images/comn/bul_08.png" class="t">등록폼 설정</td>
    <td class="wbg pl7">
    <ul class="List">
	<?
		$i = 0;
		foreach($type_arr as $key => $val){	
	?>
		<li <?php echo ($i==0)?"class='f'":"";?>><a href='./board.php?type=<?php echo $key?>' <?=($type==$key)?"class='none b col'":"";?>><?php echo $val['name']?></a></li>
	<?
		$i++;
		}
	?>
    </ul>
    </td>
  </tr>		 
</table>
</dl>