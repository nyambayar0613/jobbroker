<?php
$get_img = $netfu_util->get_board_img($row['bo_table'], $bo_row);
$get_member = $netfu_member->get_member($bo_row['wr_id']);
$get_member = $netfu_member->member_info($get_member);
$get_board_info = $netfu_util->get_board_info($board, $bo_row);
$get_board_info2 = $board_control->get_list($bo_row, $board, "./skins/board/" . $board['bo_skin'], $board['bo_subject_len'] );

if($arr['img_size'][0]) $img_css = ' width:'.$arr['img_size'][0].'px;';
if($arr['img_size'][1]) $img_css .= ' height:'.$arr['img_size'][1].'px;';
?>
<div class="image_box">
	<a href="<?=NFE_URL;?>/board/detail.php?board_code=<?=$board_code;?>&code=<?=$code;?>&bo_table=<?=$row['bo_table'];?>&no=<?=$bo_row['wr_no'];?>&page=<?=$_GET['page'];?>"><img src="<?=$get_img?>" style="<?=$img_css;?>" alt=""></a>
</div>
<div class="text_box">
	<div class="title"><a href="<?=NFE_URL;?>/board/detail.php?board_code=<?=$board_code;?>&code=<?=$code;?>&bo_table=<?=$row['bo_table'];?>&no=<?=$bo_row['wr_no'];?>&page=<?=$_GET['page'];?>"><?=$bo_row['wr_subject'];?></a></div>
	<div class="info">
		<span class="name"><em class="cmt_ic_mbv"><?=$get_member['level_icon'];?></em><?=$bo_row['wr_name'];?></span>
		<span class="date"><?=date("Y.m.d", strtotime($bo_row['wr_datetime']));?></span>
		<?php if($bo_row['wr_secret']) {?><em class="cmt_ic"><img src="../images/ic/lock.gif" alt="Нууц үг"></em><?php }?>
		<?php if($get_board_info2['icon_file']) {?><em class="cmt_ic"><img src="../images/ic/file.gif" alt="Файл"></em><?php }?>
		<em class="cmt_ic_n"><?=$get_board_info['new'];?></em>
	</div>
</div>