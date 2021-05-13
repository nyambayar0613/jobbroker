<?php
// : 댓글 쿼리문
$q = " select * from ".$write_table." where `wr_parent` = '".$bo_row['wr_no']."' and `wr_is_comment` = 1 order by `wr_comment`, `wr_comment_reply` ";
$query = sql_query($q);
$total_num = mysql_num_rows($query);

/* 댓글 권한 확인 */
$is_comment_write = false;
if($member['mb_level'] >= $board['bo_comment_level']){
	$is_comment_write = true;
}
$is_comment_write = ($board['bo_use_comment']) ? true : false; // 댓글 기능 사용 유무 확인
/* //댓글 권한 확인 */
?>

<?php if ($is_comment_write) { ?>
<form name="fviewcomment" method="post" action="../regist.php" onSubmit="return false">
<input type='hidden' name='mode' id='mode' value='board_reply_write'>
<input type="hidden" name="reply_mode" value="" />
<input type='hidden' name='board_code' value='<?=$board_code?>'>
<input type='hidden' name='code' value='<?=$code?>'>
<input type='hidden' name='bo_table' value='<?=$bo_table?>'>
<input type='hidden' name='wr_no' value='<?=$bo_row['wr_no']?>'>
<input type='hidden' name='comment_id' id='comment_id' value=''>
<input type='hidden' name='sca' value='<?=$sca?>' >
<input type='hidden' name='stx' value='<?=$stx?>'>
<!-- <input type='hidden' name='sfl' value='<?=$sfl?>' >
<input type='hidden' name='spt' value='<?=$spt?>'> -->
<input type='hidden' name='page' value='<?=$_GET['page']?>'>
<input type='hidden' name='cwin' value='<?=$cwin?>'>
<input type='hidden' name='is_good' value=''>
<input type="hidden" name="text_key" value="" />
<?php if($is_member){ ?>
<input type='hidden' name='wr_name' value='<?php echo $member['mb_nick'];?>'>
<input type='hidden' name='wr_password' value='<?php echo $member['mb_password'];?>'>
<?php } ?>

<section class="cont_box comment_con">
<h2>댓글<span class="reply_total"><?=number_format($total_num);?></span></h2>
<div class="comment_box cf">
	<div class="cmt_write">
		<?php
		if(!$member['mb_id']) {
		?>
		<div class="cmt_hd cf">
			<ul>
				
				<li class="wr_name"><label>이름<input type="text" name="wr_name"  hname="이름" required></label></li>
				<li class="wr_pw"><label>비밀번호<input type="password" name="wr_password" maxlength="16" hname="비밀번호" required></label></li>
				<li class="captcha_key"><label>자동등록방지문자<input type="text" name="wr_key" hname="자동등록방지" required></label><span class="reply_rand_text"><img src="<?=NFE_URL;?>/include/rand_text.php" /></span></li>
			</ul>
		</div>
		<?php }?>
		<div class="input_box">
			<div class="text-box"><textarea name="wr_content" rows="3" hname="댓글내용" required placeholder="댓글을 입력하세요."></textarea></div>
			<button onClick="return netfu_board.reply_write(this)">등록</button>
		</div>
	</div>
</div>

<?php }?>
</section>
<section class="reply_con cf">
<?php
include NFE_PATH.'/board/reply_list.inc.php';
?>
</section>

</form>