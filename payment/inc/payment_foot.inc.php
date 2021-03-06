<style type="text/css">
.tax_div { display:none; }
</style>
<section class="cont_box service_con">
	<h2>Төлбөрийн мэдээлэл</h2>
	<table class="search_tb payment_price_input">
	<tbody>
		<tr>
			<th class="sch_hd">
				<div>Нийт дүн</div>
			</th>
			<td class="sch_td1">
				<div class="td_bx"><span class="date">&nbsp</span><span class="price _hap_price"></span></div>
			</td>
		</tr>
	</tbody>
	<tbody style="display:none;">
			<tr>
			<th class="sch_hd">
				<div>Хөнгөлөлт</div>
			</th>
			<td class="sch_td1">
				<div class="td_bx2"><div>Эзэмшиж буй point : <em><?=$member['mb_point'];?></em></div><label for="point"><input type="text" name="use_point"></label><button type="button" onClick="netfu_payment.point_use(this);return false;">포인트 사용</button></div>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<th class="sch_hd">
				<div>Төлбөрийн эцсийн дүн</div>
			</th>
			<td class="sch_td1 price_result">
				<div class="td_bx"><span class="date">&nbsp</span><span class="result_price _result_price"></span></div>
			</td>
		</tr>
	</tbody>
	</table>
</section>

<?php
$bank_query = sql_query("select * from `alice_bank` order by `rank` asc");
?>
<section class="cont_box service_con payment_method_tag">
	<h2>Төлбөрийн аргыг сонгоно уу</h2>
	<ul class="radio_group">
		<fieldset>
			<legend>결제수단 선택</legend>
			<?php
			$_array = explode("/", $netfu_payment->use_pg['pg_method']);
			if(is_array($_array)) { foreach($_array as $k=>$v) {
			?>
			<li><label for="credit_<?=$v;?>"><input type="radio" id="credit_<?=$v;?>" name="pay_method" value="<?=$v;?>" onClick="netfu_payment.pay_method_click()"><?=$netfu_payment->pay_method_arr[$v];?></label></li>
			<?php } }?>
		</fieldset>
	</ul>
	<ul class="info_con bank_ul" style="display:none;">
		<li class="row1">
			<label for="bank">Хадгаламжийн банк</label>
			<select name="bank">
				<?php
				while($row=sql_fetch_array($bank_query)) {
				?>
				<option value="<?=$row['no'];?>"><?=$row['bank_name'].' '.$row['bank_num'].' ('.$row['name'];?>)</option>
				<?php }?>
			</select>
		</li>
		<li class="row2">
			<label for="savers">Хадгаламж эзэмшигч</label>
			<input type="text" id="savers" name="bank_name">
		</li>
		<li class="row3">
			<label for="cash_receipt">Бэлэн мөнгөний баримт</label>
			<input type="checkbox" id="cash_receipt" name="tax_use" value="Y" onClick="netfu_payment.tax_change()">Гаргах
			<div class="tax_div">
				<div class="use cf">
					<label for="rcpt1"><input type="radio" id="rcpt1" name="pay_tax_type" value="1" onClick="netfu_payment.tax_change()" checked>Орлогын суутгалын хувьд</label>
					<label for="rcpt2"><input type="radio" id="rcpt2" name="pay_tax_type" value="2" onClick="netfu_payment.tax_change()">Зардлыг нотлох зорилгоор</label>
				</div>
				<div class="id_num cf tax_type tax_type_1">
					<label for="id_num">
					<select class="ipSelect" name="pay_tax_num_type" id="pay_tax_num_type" onchange="netfu_payment.tax_num_type(this);" style="width:90%">
					<option value="0">РД дугаар</option>
					<option value="1">Утасны дугаар</option>
					<option value="2">Кардын дугаар</option>
					</select> : </label>
					<input type="text" id="id_num" name="pay_tax_num_person" value="" hname="РД дугаар">
				</div>
				<div class="id_num cf tax_type tax_type_2 _none biz_num2">
					<input type="text" size="3" class="ipText biz_no" name="pay_tax_num_biz[]" hname="Компанийн бүртгэлийн дугаар"><span>-</span>
					<input type="text" size="2" class="ipText biz_no" name="pay_tax_num_biz[]" hname="Компанийн бүртгэлийн дугаар"><span>-</span>
					<input type="text" size="5" class="ipText biz_no" name="pay_tax_num_biz[]" hname="Компанийн бүртгэлийн дугаар">
				</div>
			</div>
		</li>
	</ul>
</section>

<div class="button_con button_con4">
	<a href="#none;" onClick="netfu_payment.submit(document.forms['forder'])" class="bottom_btn04">Төлбөр хийх<img src="<?=NFE_URL;?>/images/btn_arrow.png" alt="Төлбөр хийх"></a>
</div>