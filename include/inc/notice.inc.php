<?php
$n_query = sql_query("select * from alice_notice order by `no` desc");
$_nums = sql_num_rows($n_query);
if($_nums<=0) return false;
?>
<!-- 공지사항 -->
<section class="cont_box notice_con" style="position:relative;">
	<ul class="cont_box_inner cycle-slideshow"
		data-cycle-fx=scrollVert
		data-cycle-slides="> li"
		data-cycle-timeout=2000
		data-reverse=true
	>
		<?php
		while($row=sql_fetch_array($n_query)) {
		?>
		<li>
			<div class="text_box">
				<div class="title">
					<h2 style="position:absolute;left:0px;">[<?=$netfu_util->notice_cate[$row['wr_type']];?>]</h2>
					<a href="<?=NFE_URL;?>/notice/notice_view.php?no=<?=$row['no'];?>"><?=$netfu_util->get_stag($row['wr_subject']);?></a><span class="n_date"><?=$netfu_util->get_date('dot', $row['wr_date']);?></span>
				</div>
			</div>
		</li>
		<?php
		}
		?>
	</ul>
</section>