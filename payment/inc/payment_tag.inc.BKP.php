<?php
// : 결제 장바구니소스
// : job_payment.php 참조
?>
<table class="search_tb2">
	<tr>
		<th class="sch_hd">
			<div class="sch_hd_tit"><?=$price_row['_subject'];?></div>
		</th>
		<td class="sch_td1">
			 <div class="td_bx">
				 <div class="date cf">
					 <p><?=$_date_txt;?></p>
					 <?php
					 if($price_row['_date_txt']) {?>
					 <p>(<?=$price_row['_date_txt'];?>)</p>
					 <?php }?>
				 </div>
				 <div class="price"><?=number_format($netfu_util->sale_price($price_row['_sale'], $price_row['_price']));?>төгрөг</div>
			 </div>
		</td>
	</tr>
</table>