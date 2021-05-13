<?php
$q = "select * from alice_category where p_code='' and `type`='board_menu' order by `rank` asc";
$bo_query = sql_query($q);

switch(!$member['mb_id']) {
	case true:
		$login_move = NFE_URL.'/include/login.php';
		$login_txt = '로그인';

		$member_move = NFE_URL.'/member/register.php';
		$member_txt = '회원가입';
		break;

	default:
		$login_move = NFE_URL.'/regist.php?mode=logout';
		$login_txt = '로그아웃';

		$member_move = NFE_URL.'/mypage/member_modify.php';
		$member_txt = '회원수정';
		break;
}
?>
<!-- 전체메뉴 -->
<style type="text/css">
.nav_left_view .nav_menu li { width:<?=$design['map_use'] ? '33.333333' : '50';?>% }
</style>
<div class="nav_left_view left_nav">
<div class="nav_wrap">
	<ul>
		<li class="close_btn"><a href="#none;" onClick="all_menu()"><img src="<?=NFE_URL;?>/images/close.png" alt="닫기"></a></li>					 
		<li class="title_area">전체메뉴</li>
		<?php if($member['mb_id']) {?>
		<li class="id_area"><?=$member['mb_name'];?><span>님</span></li>
		<?php }?>
		<li class="nav_menu">
			<ol>
			<?php
			if($design['map_use']) {
			?>
				<li>
				<a href="<?=NFE_URL;?>/job/location.php">
					<div class="nav_ico"><img src="<?=NFE_URL;?>/images/map_ico.png" alt="지도검색"></div>
					<div class="nav_txt">지도검색</div>
					</a>
				</li>
			<?php }?>
				<?php if(!$member['mb_id']) { //비회원?>
				<li>
				<a href="<?=$member_move;?>">
					<div class="nav_ico"><img src="<?=NFE_URL;?>/images/join_ico.png" alt="<?=$member_txt;?>"></div>
					<div class="nav_txt"><?=$member_txt;?></div>
					</a>
				</li>
				<?php } ?>
				<?php if($member['mb_id']) { ?>
				<li>
				<a href="<?=$member_move;?>">
					<div class="nav_ico"><img src="<?=NFE_URL;?>/images/admin_ico.png" alt="정보수정"></div>
					<div class="nav_txt">정보수정</div>
					</a>
				</li>
				<?php } ?>
				<li>
				<a href="<?=$login_move;?>">
					<div class="nav_ico"><img src="<?=NFE_URL;?>/images/login_ico.png" alt="<?=$login_txt;?>"></div>
					<div class="nav_txt"><?=$login_txt;?></div>
					</a>
				</li>
			</ol>
		</li>
		<li class="home_bt"><a href="<?=NFE_URL;?>/">홈바로가기</a></li>
		<li class="menu_tit"><a href="<?=NFE_URL;?>/job/index.php">구인정보</a></li>
		<li><a href="<?=NFE_URL;?>/job/index.php?code=hurry">급구 구인정보</a></li>					 
		<li><a href="<?=NFE_URL;?>/job/index.php?code=area">지역별 구인정보</a></li>
		<li><a href="<?=NFE_URL;?>/job/index.php?code=job_type">업직종별 구인정보</a></li>
		<li><a href="<?=NFE_URL;?>/job/index.php?code=subway">역세권별 구인정보</a></li>					 
		<li><a href="<?=NFE_URL;?>/job/index.php?code=univ">대학가별 구인정보</a></li>
		<li><a href="<?=NFE_URL;?>/job/index.php?code=date">기간별 구인정보</a></li>
		<li><a href="<?=NFE_URL;?>/job/index.php?code=pay">급여별 구인정보</a></li>					 
		<li><a href="<?=NFE_URL;?>/job/index.php?code=etc">대상별 구인정보</a></li>
		<li class="menu_tit"><a href="<?=NFE_URL;?>/resume/index.php">인재정보</a></li>
		<li><a href="<?=NFE_URL;?>/resume/index.php?code=hurry">급구 인재정보</a></li>					 
		<li><a href="<?=NFE_URL;?>/resume/index.php?code=area">지역별 인재정보</a></li>
		<li><a href="<?=NFE_URL;?>/resume/index.php?code=job_type">업직종별 인재정보</a></li>
		<li><a href="<?=NFE_URL;?>/resume/index.php?code=date">기간별 인재정보</a></li>
		<li class="menu_tit"><a href="<?=NFE_URL;?>/board/index.php">커뮤니티</a></li>
		<?php
		while($row=sql_fetch_array($bo_query)) {
			$q = "select * from alice_category where p_code='".$row['code']."' and `type`='board_menu' order by `rank` asc";
			$bo_query2 = sql_query($q);
			while($row2=sql_fetch_array($bo_query2)) {
				$query = sql_query("select * from alice_board where code='".$row2['code']."' order by m_rank asc");
			?>
			<li class="cmt_menu"><a href="<?=NFE_URL;?>/board/index.php?code=<?=$row2['code'];?>"><?=$row2['name'];?></a></li>
			<?php
				while($row3=sql_fetch_array($query)) {
					$arr = $netfu_util->get_board($print_board, $row3);
					if($arr['query_total']<=0) continue;
			?>
				<li class="sub_cate"><a href="<?=NFE_URL;?>/board/list.php?board_code=<?=$row['code'];?>&code=<?=$row3['code'];?>&bo_table=<?=$row3['bo_table'];?>"><?=$row3['bo_subject'];?></a></li>
			<?php
				}
			}
		}
		?>
		<li class="menu_tit">공지사항</li>
		<li><a href="<?=NFE_URL;?>/notice/notice_list.php">공지사항</a></li>
		</ul>
	</div>
</div>
<div class="nav_left_view wrap_bg" style="display:none;"></div>
<!-- //전체메뉴 -->