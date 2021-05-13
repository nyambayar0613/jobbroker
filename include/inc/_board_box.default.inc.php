<div class="text_box">
	<div class="title"><a href="./board.php?board_code=<?php echo $_GET['board_code'];?>&code=<?php echo $code;?>&bo_table=<?php echo $board['bo_table'];?>&wr_no=<?php echo $bo_row['wr_no'];?>"><?php echo stripslashes($bo_row['wr_subject']);?></a></div>
	<div class="info">
		<span class="name"><?=$bo_row['wr_name'];?></span>
		<span class="date"><?=date("Y.m.d", strtotime($bo_row['wr_datetime']));?></span>
	</div>
</div>