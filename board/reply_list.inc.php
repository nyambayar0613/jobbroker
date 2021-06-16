<style type="text/css">
.comment_con.reply_reply_write._none { display:none; }
.del_con._none { display:none; }
</style>
<?php
// : 댓글 쿼리문
$q = " select * from ".$write_table." where `wr_parent` = '".$bo_row['wr_no']."' and `wr_is_comment` = 1 order by `wr_comment`, `wr_comment_reply` ";
$query = sql_query($q);
$total_num = mysql_num_rows($query);

while($reply_row=sql_fetch_array($query)) {
	//$_child_count = sql_num_rows(sql_query("select count(*) as c from ".$write_table." where wr_comment='".$reply_row['."'"));

	$is_edit = false;
	$is_del = false;
	$is_reply = true;
	if(($reply_row['wr_id'] == $member['mb_id'] || $is_admin) || !$reply_row['wr_id']) {
		$is_edit = true;
		$is_del = true;
	}

	$reply_reply_row = array();
	if(!$reply_row['wr_comment_reply']) {
		$reply_reply_row = sql_fetch("select count(*) as c from ".$write_table." where `wr_parent`='".$bo_row['wr_no']."' and wr_comment='".$reply_row['wr_comment']."' and wr_comment_reply!=''");
		if($reply_reply_row['c']>0) {
			$is_edit = false;
			$is_del = false;
			$is_reply = true;
		}
	} else {
		$is_edit = true;
		$is_reply = false;
	}

	if($reply_row['wr_comment_reply']) $_reply_num++;
	else $_reply_num = 0;
?>
<div id="c_<?=$reply_row['wr_no'];?>">
	<div class="reply_box depth <?=$reply_row['wr_comment_reply'] ? 'depth2' : 'depth1';?> cf"><!--depth3-->
		<div class="rpy_icon"><?=$reply_row['wr_comment_reply'] ? '└' : '';?></div>
		<div class="rpy_cont cf">
			<div class="reply_hd cf">
				<ul>
					<li class="rpy_name"><?=$reply_row['wr_name'];?></li>
					<li class="rpy_date"><?=date("Y-m-d H:i", strtotime($reply_row['wr_datetime']));?></li>
				</ul>
			</div>
			<div class="reply_txt cf"><?=nl2br(stripslashes($reply_row['wr_content']));?></div>
			<div class="rpy_etc cf">
				<?php if($is_edit) {?><span class="rpy_btn" onClick="netfu_board.reply_update(this, '<?=$reply_row['wr_no'];?>')">수정</span><?php }?>
				<?php if($is_reply) {?><span class="rpy_btn" onClick="netfu_board.reply_reply(this, 'reply_reply', '<?=$reply_row['wr_no'];?>')">답글</span><?php }?>
				<?php if($is_del) {?><span class="rpy_del" onClick="netfu_board.reply_delete(this, '<?=$reply_row['wr_no'];?>')">삭제</span><?php }?>
			</div>
		</div>
	</div>

	<!-- 답글 텍스트 폼 -->
	<div class="cont_box comment_con reply_reply_write reply_write_<?=$reply_row['wr_no'];?> _none">
		<div class="comment_box cf">
			<div class="cmt_write">
				<?php
				if(!$member['mb_id']) {
				?>
				<div class="cmt_hd cf">
					<ul>
                        <li class="wr_name"><label>Нэр<input type="text" name="wr_name"  hname="Нэр" required></label></li>
                        <li class="wr_pw"><label>Нууц дугаар<input type="password" name="wr_password" maxlength="16" hname="Нууц дугаар" required></label></li>
                        <li class="captcha_key"><label>Автомат бүртгэлээс сэргийлэх<input type="text" name="wr_key" hname="Автомат бүртгэлээс сэргийлэх" required></label><span class="reply_rand_text"><img src="<?=NFE_URL;?>/include/rand_text.php" /></span></li>
					</ul>
				</div>
				<?php }?>
				<div class="input_box">
                    <div class="text-box"><textarea name="wr_content" rows="3" hname="Сэтгэгдэлийн агуулга" required placeholder="Сэтгэглэл олууна уу."></textarea></div>
                    <button onClick="return netfu_board.reply_write(this)">Бүртгэх</button>
				</div>
			</div>
		</div>
	</div>
	<!-- // 답글 텍스트 폼 -->

	<div class="del_con _none">
		<span>Нууц дугаар : <input type="password" name="reply_confirm_password[]" id="" maxlength="16"></span>
		<button onClick="netfu_board.reply_process(this, '<?=$reply_row['wr_no'];?>');return false;">Оруулах</button>
		<button>Цуцлах</button>
	</div>
</div>
<?php }
?>