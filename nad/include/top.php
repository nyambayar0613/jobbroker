<?php include_once "../include/_engine.php"; ?>
<style>#question input { width: 4em }#icon_question input { width: 4em }</style>
<script>
var top_menu_code = "<?php echo $top_menu_code; ?>";
$(function(){
	// 쿠키로 저장된 값 불러오기
	if($.cookie('leftmenu_'+top_menu_code) == 'close'){	// 기본은 열려 있는 상태로.
		$("#left").hide();
		$("#lopen").show();
		$('#menuTopLine').attr('src','../../images/nad/adbg_01.gif');
		$('#menuBottomLine').attr('src','../../images/nad/adbg_03.gif');
	} else {
		$("#left").show();
		$("#lopen").hide();
		$('#menuTopLine').attr('src','../../images/nad/adbg2_01.gif');
		$('#menuBottomLine').attr('src','../../images/nad/adbg2_03.gif');
	}
});
var left_menu_close = function(top_code){
	$("#left").hide();
	$("#lopen").show();
	$('#menuTopLine').attr('src','../../images/nad/adbg_01.gif');
	$('#menuBottomLine').attr('src','../../images/nad/adbg_03.gif');
	$.cookie('leftmenu_'+top_menu_code, 'close', { expires:1, domain:domain, path:'/', secure:0});		// 쿠키 저장
}
var left_menu_open = function(top_code){
	$("#left").show();
	$("#lopen").hide();
	$('#menuTopLine').attr('src','../../images/nad/adbg2_01.gif');
	$('#menuBottomLine').attr('src','../../images/nad/adbg2_03.gif');
	$.cookie('leftmenu_'+top_menu_code, 'open', { expires:1, domain:domain, path:'/', secure:0});		// 쿠키 저장
}
</script>
<body>

	<!-- 상단 대메뉴 -->
	<div id="header" class="tmn">
		<dl class="gnb">
			<table>
			  <tr>
				<td class="logo"><a href="../main/">admin<!--<img src="../../images/nad/admin.png" class="mb5">--></a></td>

				<?php if($is_super_admin){ ?>
				<td class="<?php echo ($tmp_menu=='100')?'on':'';?>"><a href="../alba/" onmouseover="MM_showHideLayers('submn1','','show')" onmouseout="MM_showHideLayers('submn1','','hide')">서비스관리</a></td>
				<?php } else {
					if(@in_array('100000',$auth_top_menu)){	// 서비스관리 ?>
						<td class="<?php echo ($tmp_menu=='100')?'on':'';?>"><a href="../alba/" onmouseover="MM_showHideLayers('submn1','','show')" onmouseout="MM_showHideLayers('submn1','','hide')">서비스관리</a></td>
				<?php 
					}
				}
				if($is_super_admin){
				?>
				<td class="<?php echo ($tmp_menu=='200')?'on':'';?>"><a href="../config/" onmouseover="MM_showHideLayers('submn2','','show')" onmouseout="MM_showHideLayers('submn2','','hide')">환경설정</a></td>
				<?php } else {
					if(@in_array('200000',$auth_top_menu)){	// 환경설정
				?>
					<td class="<?php echo ($tmp_menu=='200')?'on':'';?>"><a href="../config/" onmouseover="MM_showHideLayers('submn2','','show')" onmouseout="MM_showHideLayers('submn2','','hide')">환경설정</a></td>
				<?php 
					}
				}
				if($is_super_admin){
				?>
				<td class="<?php echo ($tmp_menu=='300')?'on':'';?>"><a href="../member/" onmouseover="MM_showHideLayers('submn3','','show')" onmouseout="MM_showHideLayers('submn3','','hide')">회원관리</a></td>
				<?php } else {
					if(@in_array('300000',$auth_top_menu)){	// 회원관리
				?>
					<td class="<?php echo ($tmp_menu=='300')?'on':'';?>"><a href="../member/" onmouseover="MM_showHideLayers('submn3','','show')" onmouseout="MM_showHideLayers('submn3','','hide')">회원관리</a></td>
				<?php 
					}
				}
				if($is_super_admin){
				?>
				<td class="<?php echo ($tmp_menu=='400')?'on':'';?>"><a href="../design/" onmouseover="MM_showHideLayers('submn4','','show')" onmouseout="MM_showHideLayers('submn4','','hide')">디자인관리</a></td>
				<?php } else {
					if(@in_array('400000',$auth_top_menu)){	// 디자인관리
				?>
					<td class="<?php echo ($tmp_menu=='400')?'on':'';?>"><a href="../design/" onmouseover="MM_showHideLayers('submn4','','show')" onmouseout="MM_showHideLayers('submn4','','hide')">디자인관리</a></td>
				<?php 
					}
				}
				if($is_super_admin){
				?>
				<td class="<?php echo ($tmp_menu=='500')?'on':'';?>"><a href="../payment/" onmouseover="MM_showHideLayers('submn5','','show')" onmouseout="MM_showHideLayers('submn5','','hide')">결제관리</a></td>
				<?php } else {
					if(@in_array('500000',$auth_top_menu)){	// 결제관리
				?>
					<td class="<?php echo ($tmp_menu=='500')?'on':'';?>"><a href="../payment/" onmouseover="MM_showHideLayers('submn5','','show')" onmouseout="MM_showHideLayers('submn5','','hide')">결제관리</a></td>
				<?php 
					}
				}
				if($is_super_admin){
				?>
				<td class="<?php echo ($tmp_menu=='600')?'on':'';?>"><a href="../board/" onmouseover="MM_showHideLayers('submn6','','show')" onmouseout="MM_showHideLayers('submn6','','hide')">커뮤니티관리</a></td>
				<?php } else {
					if(@in_array('600000',$auth_top_menu)){	// 커뮤니티
				?>
					<td class="<?php echo ($tmp_menu=='600')?'on':'';?>"><a href="../board/" onmouseover="MM_showHideLayers('submn6','','show')" onmouseout="MM_showHideLayers('submn6','','hide')">커뮤니티관리</a></td>
				<?php 
					}
				}
				if($is_super_admin){
				?>
				<td class="<?php echo ($tmp_menu=='700')?'on':'';?>"><a href="../statistics/" onmouseover="MM_showHideLayers('submn7','','show')" onmouseout="MM_showHideLayers('submn7','','hide')">통계관리</a></td>
				<?php } else {
					if(@in_array('700000',$auth_top_menu)){	// 통계관리
				?>
				<td class="<?php echo ($tmp_menu=='700')?'on':'';?>"><a href="../statistics/" onmouseover="MM_showHideLayers('submn7','','show')" onmouseout="MM_showHideLayers('submn7','','hide')">통계관리</a></td>
				<?php 
					}
				}
/*
				if($is_super_admin){
				?>
				<td class="<?php echo ($tmp_menu=='800')?'on':'';?>"><a href="../mobile/" onmouseover="MM_showHideLayers('submn8','','show')" onmouseout="MM_showHideLayers('submn8','','hide')">모바일웹</a></td>
				<?php } else {
					if(@in_array('800000',$auth_top_menu)){	// 모바일웹
				?>
				<td class="<?php echo ($tmp_menu=='800')?'on':'';?>"><a href="../mobile/" onmouseover="MM_showHideLayers('submn8','','show')" onmouseout="MM_showHideLayers('submn8','','hide')">모바일웹</a></td>
				<?php 
					}
				}
*/
				?>

			  </tr>
			</table>
			<table class="smn">
			  <tr>
				<td class="<?php echo ($top_menu_sel=='600201')?'over':'';?> bgno"><a href="../board/notice.php">공지사항</a></td><!-- smno_01.png -->
				<td class="<?php echo ($top_menu_sel=='600203')?'over':'';?>"><a href="../board/qna.php">고객문의</a></td><!-- smno_03.png -->
				<td class="<?php echo ($top_menu_sel=='600204')?'over':'';?>"><a href="../board/concert.php">광고문의</a></td><!-- smno_04.png -->
				<!-- <td class="<?php echo ($top_menu_sel=='900101')?'over':'';?>"><a href="../mobile/index.php">모바일웹</a></td> -->
			  </tr>
			</table>
		</dl>
	</div>
	<!-- //상단 대메뉴 -->

	<h3>서브레이어메뉴</h3>
	<dl class="psr" style="top:-7px;left:0px;z-index:10000;">
		<h3>1.서비스관리</h3>
		<ul id="submn1" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn1','','show')" onmouseout="MM_showHideLayers('submn1','','hide')">
			<?php
				foreach($menu['100']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
		<h3>2.환경설정</h3>
		<ul id="submn2" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn2','','show')" onmouseout="MM_showHideLayers('submn2','','hide')">
			<?php
				foreach($menu['200']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
		<h3>8.쇼핑몰관리</h3>
		<ul id="submn8" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn8','','show')" onmouseout="MM_showHideLayers('submn8','','hide')">
			<?php
				foreach($menu['800']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
		<h3>8.주문관리</h3>
		<ul id="submn9" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn9','','show')" onmouseout="MM_showHideLayers('submn9','','hide')">
			<?php
				foreach($menu['900']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>

		<h3>3.회원관리</h3>
		<ul id="submn3" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn3','','show')" onmouseout="MM_showHideLayers('submn3','','hide')">
			<?php
				foreach($menu['300']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>

		<h3>4.디자인관리</h3>
		<ul id="submn4" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn4','','show')" onmouseout="MM_showHideLayers('submn4','','hide')">
			<?php
				foreach($menu['400']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>

		<h3>5.결제관리</h3>
		<ul id="submn5" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn5','','show')" onmouseout="MM_showHideLayers('submn5','','hide')">
			<?php
				foreach($menu['500']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>

		<h3>6.커뮤니티</h3>
		<ul id="submn6" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn6','','show')" onmouseout="MM_showHideLayers('submn6','','hide')">
			<?php
				foreach($menu['600']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>

		<h3>7.통계관리</h3>
		<ul id="submn7" class="subbg" style="display:none" onmouseover="MM_showHideLayers('submn7','','show')" onmouseout="MM_showHideLayers('submn7','','hide')">
			<?php
				foreach($menu['700']['menus'] as $mkey => $mval){
					if(!$is_super_admin){ if(@in_array($mval['code'],$auth_middle_menu)==false)  continue; }
			?>
			<li>
				<h1><?php echo $mval['name'] ?></h1>
				<ul class="slist01">
					<?php 
						foreach($mval['sub_menu'] as $val){ 
							if(!$is_super_admin){ if(@in_array($val['code'],$auth_sub_menu)==false)  continue; }
					?>
					<li><a href="<?php echo $val['url']; ?>"><?php echo $val['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>

</dl>

<div id="nwrap">
