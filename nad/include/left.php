<?php if (!defined("_ALICE_")) exit; // 개별 페이지 접근 불가 ?>

	<dl class="lmt">
		<dl>
			<a onClick="left_menu_close('<?php echo $top_menu_code;?>');"><img src=../../images/icon/icon_close6.gif></a>
			<h2><?php echo $top_menu;?></h2>
			<small class="dgr fon11"><?php echo $menu[$tmp_menu]['eng_name'];?></small>
		</dl>
	</dl>

	<dl class="slmn">
		<?php 
			foreach($menu[$tmp_menu]['menus'] as $lkey => $lval){ 
		?>
		<dl>
			<h2><?php echo $lval['name']; ?></h2>
			<ul>
				<?php 
				foreach($lval['sub_menu'] as $val){ 
					if($is_super_admin){
				?>
				<li class="nemuList<?php echo ($val['code']==$sub_menu_code)?" on col":""; ?>"><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
				<?php } else { 
					if(@in_array($val['code'],$auth_sub_menu)){
				?>
				<li class="nemuList<?php echo ($val['code']==$sub_menu_code)?" on col":""; ?>"><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
				<?php
						}
					}
				}	// foreach end.
				?>
			</ul>
		</dl>
		<?php } ?>
	</dl>
	<!--<img src="../../images/nad/bglm_02.gif" class="btm">-->