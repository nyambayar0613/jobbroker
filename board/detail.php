<?php
include_once "../include/top.php";

if($_GET['no']) $_GET['wr_no'] = $_GET['no'];
else if($_GET['wr_no']) $_GET['no'] = $_GET['wr_no'];
$wr_no = $_GET['wr_no'];

if($is_member)	// 회원일때만
	$utility->set_session('ss_delete_token',$token);	// 삭제 토큰 세션


$board = $board_config_control->get_boardTable($_GET['bo_table']);	// 게시판 정보 (단수)
$_table = 'alice_write_'.addslashes($_GET['bo_table']);
$write = $bo_row = sql_fetch("select * from ".$_table." where `wr_no`='".addslashes($_GET['no'])."'");
$view = $board_control->get_view($_GET['bo_table'], $bo_row['wr_no']);

// : 비밀글
$_secret_allow = $_SESSION['view_secret_'.$_GET['bo_table'].'_'.$_GET['no']];
if(!$_SESSION['sess_admin_uid'] && $bo_row['wr_secret'] && $bo_row['wr_id']!=$member['mb_id'] && !$_secret_allow) {
	die($netfu_util->page_move('', NFE_URL.'/board/password.php?board_code='.$_GET['board_code'].'&code='.$_GET['code'].'&bo_table='.$_GET['bo_table'].'&no='.$_GET['no'].'&mode=read'));
}

## : 버튼주소 모음
$list_href = "./list.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table;
// 로그인중이고 자신의 글이라면 또는 관리자라면 패스워드를 묻지 않고 바로 수정, 삭제 가능
if (($member['mb_id'] && ($member['mb_id'] == $bo_row['wr_id'])) || $is_admin) {
	$update_href = "./write.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$bo_row['wr_no'];
	$delete_href = "javascript:del('./regist.php?token=".$token."&mode=board_delete&board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no."&page=".$page."');";

	if ($is_admin) {
		$delete_href = "javascript:del('./regist.php?token=".$token."&mode=board_delete&board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no."&page=".$page."');";
	}

// 회원이 쓴 글이 아니라면
} else {
	$update_href = "./password.php?mode=update&board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no."&page=".$page;
	$delete_href = "./password.php?token=".$token."&mode=delete&board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no."&page=".$page;
}
$write_href = "./write.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table;




// wr_no 값이 있으면 글읽기

if ($wr_no){
	// 글이 없을 경우 해당 게시판 목록으로 이동
	if (!$write['wr_no']){
		// 글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동된 경우입니다.
		if ($cwin)
			$utility->popup_msg_close($board_control->_errors('0021'));	
		else
			$utility->popup_msg_js($board_control->_errors('0021'),"./board.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table);
	}

	// 로그인된 회원의 권한이 설정된 읽기 권한보다 작다면
	if ($member['mb_level'] < $board['bo_read_level'] && !$is_admin){
		if ($member['mb_id'])
			$utility->popup_msg_js($board_control->_errors('0022'));	// 글을 읽을 권한이 없습니다.
		else
			$utility->popup_msg_js($board_control->_errors('0023'),$alice['member_path']."/login.php?wr_no=".$wr_no."&url=".urlencode("../../board/board.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no));	// 글을 읽을 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.
	}

	// 자신의 글이거나 관리자라면 통과
	if (($write['wr_id'] && $write['wr_id'] == $member['mb_id']) || $is_admin) {
		
	} else {
		// 비밀글이라면
		if ($write['wr_secret']){
			// 회원이 비밀글을 올리고 관리자가 답변글을 올렸을 경우
			// 회원이 관리자가 올린 답변글을 바로 볼 수 없던 오류를 수정
			$is_owner = false;
			if ($write['wr_reply'] && $member['mb_id']) {
				$query = " select wr_id from $write_table where wr_num = '$write[wr_num]' and wr_reply = '' and wr_is_comment = '0' ";
				$row = $db->query_fetch($query);
				if ($row['wr_id'] == $member['mb_id'])
					$is_owner = true;
			}

			//$ss_name = "ss_secret_".$bo_table."_".$write['wr_num'];
			$ss_name = "view_secret_".$bo_table."_".$write['wr_no'];

			if (!$is_owner){
				//$ss_name = "ss_secret_{$bo_table}_{$wr_id}";
				// 한번 읽은 게시물의 번호는 세션에 저장되어 있고 같은 게시물을 읽을 경우는 다시 패스워드를 묻지 않습니다.
				// 이 게시물이 저장된 게시물이 아니면서 관리자가 아니라면
				if (!$_SESSION[$ss_name])
					$utility->popup_msg_js("",$alice['board_path']."/password.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no."&mode=read");
			}
			$utility->set_session($ss_name, TRUE);
		}
	}

	// 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
	$hit_up = $board_control->hit_up($bo_table, $wr_no);
	if($hit_up){
		// 자신의 글이면 통과
		if ($write['wr_id'] && $write['wr_id'] == $member['mb_id']) {
			
		} else if ($is_guest && $board['bo_read_level'] == 1 && $write['wr_ip'] == $_SERVER['REMOTE_ADDR']) {
			// 비회원이면서 읽기레벨이 1이고 등록된 아이피가 같다면 자신의 글이므로 통과
			
		} else {
			// 글읽기 포인트가 설정되어 있다면
			if ($board['bo_read_point'] && $member['mb_point'] + $board['bo_read_point'] < 0)
				$utility->popup_msg_js("보유하신 포인트(".number_format($member['mb_point']).")가 없거나 모자라서 글읽기(".number_format($board['bo_read_point']).")가 불가합니다.\\n\\n포인트를 모으신 후 다시 글읽기 해 주십시오.");

			$point_control->point_insert($member['mb_id'], $board['bo_read_point'], $board['bo_subject']." ".$wr_no." 글읽기", $bo_table, $wr_no, "읽기");
		}

	}

} else {

	if ($member['mb_level'] < $board['bo_list_level']){
		if ($member['mb_id'])
			$utility->popup_msg_js($board_control->_errors('0018'));	// 목록을 볼 권한이 없습니다.
		else
			$utility->popup_msg_js($board_control->_errors('0024'),$alice['member_path']."/login.php?wr_no=".$wr_no."&url=".urlencode("../../board/board.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no));	// 목록을 볼 권한이 없습니다.
	}

	if (!$page) $page = 1;

}

$tmp_name = $utility->get_text($utility->str_cut($bo_row['wr_name'], $board['bo_cut_name'] * 2)); // 설정된 자리수 만큼만 이름 출력 (UTF-8로 계산하기 때문에 X 2)
$get_member = $member_control->get_member($bo_row['wr_id']);

// 0 : 닉네임, 1 : 아이디, 2 : 이름, 3 : 익명
if($board['bo_use_name']=='0'){
	$bo_row['wr_name'] = $tmp_name;
} else if($board['bo_use_name']=='1'){
	$bo_row['wr_name'] = $bo_row['wr_id'];
} else if($board['bo_use_name']=='2'){
	$bo_row['wr_name'] = ($get_member['mb_name']) ? $get_member['mb_name'] : $tmp_name;
} else if($board['bo_use_name']=='3'){
	$bo_row['wr_name'] = "익명";
}
?>
<script type="text/javascript" src="<?=NFE_URL;?>/board/netfu_board.class.js?num=<?=time();?>"></script>
<script type="text/javascript">
function file_download(link, file) {
    document.location.href=link;
}

// 삭제 검사 확인
function del(href) {
	if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
		document.location.href = encodeURI(href);
	}
}
</script>


<?php
$_banner = 'board_view_top';
include NFE_PATH.'/include/inc/banner.inc.php';
?>

<!-- 커뮤니티 텍스트형 -->
<section class="cont_box notice_txt">
<h2><span class="tit_ico"><img src="/images/title_icon02.png" alt=""></span><?=stripslashes($board['bo_subject']);?></h2>
<div class="notice_inner cf">
	<div class="view_wrap">
	  <div class="view_top cf">
			<div class="view_title"><a href="#"><?=stripslashes($bo_row['wr_subject']);?></a></div>
			<div class="view_info">
				<span class="mb_id"><strong><?=stripslashes($bo_row['wr_name']);?></strong></span>
				<span><?=date("Y.m.d H:i", strtotime($bo_row['wr_datetime']));?></span>
				<span class="hits">조회수 : <em><?=number_format($bo_row['wr_hit']);?></em></span>
			</div>
		</div>

		<?php if($view['file']['count']){ ?>
		<dl class="f11 psr mt7 dot psr" style="background-position:bottom;padding:0 0 7px 5px">
		<table>
		<?php
			// 가변 파일
			$cnt = 0;
			for ($i=0; $i<$view['file']['count']; $i++) {
				if ($view['file'][$i]['source'] && !$view[file][$i]['view']) {
					$cnt++;
					echo "<tr><td>&nbsp;&nbsp;<img src='../images/ic/file.gif' align=absmiddle border='0'>";
					echo "<a href=\"javascript:file_download('{$view[file][$i][href]}', '{$view[file][$i][source]}');\" title='{$view[file][$i][content]}'>";
					echo "&nbsp;<span style=\"color:#888;\">{$view[file][$i][source]} ({$view[file][$i][size]})</span>";
					echo "&nbsp;<span style=\"color:#ff6600; font-size:11px;\">[{$view[file][$i][download]}]</span>";
					echo "&nbsp;<span style=\"color:#d3d3d3; font-size:11px;\">DATE : {$view[file][$i][datetime]}</span>";
					echo "</a></td></tr>";
				}
			}
		?>
		</table>
		</dl>
		<?php } ?>

		<?php
		// 파일 출력
		for ($i=0; $i<=$view['file']['count']; $i++) {	// 이미지의 경우 그냥 출력한다.
			if ($view['file'][$i]['view']) 
			echo $view['file'][$i]['view'] . "<br/><br/>";
		}
		?>
		<style type="text/css">
		div.view_con img { height:auto; }
		</style>
		<div class="view_con cf">
			<?php echo $view['content'];?>
		</div>

		<script type="text/javascript">
		$("div.view_con").find("img").each(function(){
			if($(this).attr("src").indexOf("/data/")>=0) {
				$(this).css({"height":"auto"});
			}
		});
		</script>
	</div>
</div>

<div class="button-group view_bt">
	<ul>
		<li><a href="<?php echo $list_href;?>">목록</a></li>
		<li><a href="<?php echo $update_href;?>">수정</a></li>
		<li><a href="<?php echo $delete_href;?>">삭제</a></li>
		<li><a href="<?php echo $write_href;?>">글작성</a></li>
	</ul>
</div>
</section>
<!-- //커뮤니티 텍스트형 -->

<?php
$_banner = 'board_view_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';
?>

<!-- 댓글 -->
<?php
include "./reply.php";


if($board['bo_use_list_view'] == 1) {
	include "./inc/board_list.inc.php";
}
?>



<?php
//include_once NFE_PATH."/include/inc/passwd_confirm.inc.php";

include_once(NFE_PATH.'/include/tail.php');
?>